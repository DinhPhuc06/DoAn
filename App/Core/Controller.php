<?php

namespace App\Core;

/**
 * Controller cha - Các controller con require và kế thừa từ class này.
 * Chỉ điều phối request (GET/POST), gọi Model để xử lý dữ liệu, gọi View để hiển thị.
 */
abstract class Controller
{
    /** Đường dẫn thư mục view (model con gán, ví dụ: Views_Admin) */
    protected string $viewPath = '';

    /** Có dùng layout (header/sidebar/footer) khi render hay không */
    protected bool $useLayout = true;

    public function __construct()
    {
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', dirname(__DIR__, 2));
        }
    }

    /**
     * Render view với data. Nếu useLayout = true thì bọc bằng layout.
     * @param string $view Tên view (vd: 'Customer/index' -> Customer/index.php)
     * @param array<string, mixed> $data Data truyền sang view (extract thành biến)
     */
    protected function render(string $view, array $data = []): void
    {
        $basePath = $this->viewPath ?: (BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views');
        $viewFile = $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $view) . '.php';

        if (!is_file($viewFile)) {
            throw new \RuntimeException('View not found: ' . $view);
        }

        extract($data, EXTR_SKIP);

        if ($this->useLayout) {
            ob_start();
            include $viewFile;
            $content = ob_get_clean();
            $content = $content ?: '';
            include $basePath . DIRECTORY_SEPARATOR . 'Layout' . DIRECTORY_SEPARATOR . 'layout.php';
            return;
        }

        include $viewFile;
    }

    /**
     * Chuyển hướng
     * @param string $url URL đích
     * @param int $code HTTP status (302, 301)
     */
    protected function redirect(string $url, int $code = 302): void
    {
        http_response_code($code);
        header('Location: ' . $url);
        exit;
    }

    /**
     * Lấy input từ GET hoặc POST (ưu tiên POST)
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    /**
     * Kiểm tra request có phải POST
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }


    protected function verifyCsrfToken(): bool
    {
        $token = $this->input('_token');
        return \App\Core\verify_csrf_token($token ?? '');
    }

    protected function validate(array $data, array $rules, array $messages = []): \App\Core\Validator
    {
        return \App\Core\Validator::make($data, $rules, $messages);
    }
}
