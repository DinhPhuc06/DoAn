<?php

namespace App\Core;

/**
 * Router - Điều phối request đến Controller/Method tương ứng
 * Hỗ trợ GET, POST, PUT, DELETE và middleware
 */
class Router
{
    private static array $routes = [];
    private static array $middlewares = [];
    private static ?string $basePath = null;

    /**
     * Đăng ký route GET
     * @param string|array $middlewares Middleware class name(s), ví dụ: AuthMiddleware::class hoặc [AuthMiddleware::class]
     */
    public static function get(string $path, string $controller, string $method = 'index', $middlewares = []): void
    {
        self::addRoute('GET', $path, $controller, $method, $middlewares);
    }

    /**
     * Đăng ký route POST
     */
    public static function post(string $path, string $controller, string $method = 'index', $middlewares = []): void
    {
        self::addRoute('POST', $path, $controller, $method, $middlewares);
    }

    /**
     * Đăng ký route với method tùy ý
     */
    public static function add(string $method, string $path, string $controller, string $action = 'index', $middlewares = []): void
    {
        self::addRoute($method, $path, $controller, $action, $middlewares);
    }

    /**
     * Thêm route vào danh sách
     * @param array|string $middlewares Một hoặc nhiều middleware class
     */
    private static function addRoute(string $method, string $path, string $controller, string $action, $middlewares = []): void
    {
        $middlewares = is_array($middlewares) ? $middlewares : [$middlewares];
        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => self::normalizePath($path),
            'controller' => $controller,
            'action' => $action,
            'middlewares' => array_filter($middlewares),
        ];
    }

    /**
     * Chuẩn hóa path (loại bỏ / đầu cuối, thêm / đầu)
     */
    private static function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        return $path === '' ? '/' : '/' . $path;
    }

    /**
     * Dispatch request - Tìm route phù hợp và gọi controller
     */
    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = self::getCurrentUri();

        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = [];
            if (self::matchRoute($route['path'], $uri, $params)) {
                $controllerClass = $route['controller'];
                $action = $route['action'];
                $middlewares = $route['middlewares'] ?? [];

                $runController = function () use ($controllerClass, $action, $params) {
                    if (!class_exists($controllerClass)) {
                        self::handleError(404, "Controller not found: {$controllerClass}");
                        return;
                    }
                    $controller = new $controllerClass();
                    if (!method_exists($controller, $action)) {
                        self::handleError(404, "Method not found: {$controllerClass}::{$action}()");
                        return;
                    }
                    call_user_func_array([$controller, $action], $params);
                };

                // Chạy middleware stack (sau cùng = gọi controller)
                $next = $runController;
                foreach (array_reverse($middlewares) as $middlewareClass) {
                    if (!class_exists($middlewareClass)) {
                        continue;
                    }
                    $current = $next;
                    $next = function () use ($middlewareClass, $current) {
                        $m = new $middlewareClass();
                        $m->handle($current);
                    };
                }
                $next();
                return;
            }
        }

        // Không tìm thấy route
        self::handleError(404, "Route not found: {$method} {$uri}");
    }

    /**
     * So khớp route pattern với URI
     * Hỗ trợ: /user/{id}, /user/{id}/edit
     */
    private static function matchRoute(string $pattern, string $uri, array &$params = []): bool
    {
        $params = [];
        $patternParts = explode('/', trim($pattern, '/'));
        $uriParts = explode('/', trim($uri, '/'));

        if (count($patternParts) !== count($uriParts)) {
            return false;
        }

        foreach ($patternParts as $index => $part) {
            if (preg_match('/^{(\w+)}$/', $part, $matches)) {
                $params[] = $uriParts[$index] ?? null;
            } elseif ($part !== ($uriParts[$index] ?? '')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Lấy URI hiện tại (loại bỏ query string và base path)
     */
    private static function getCurrentUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = parse_url($uri, PHP_URL_PATH);
        $basePath = self::getBasePath();

        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        return self::normalizePath($uri);
    }

    /**
     * Lấy base path của ứng dụng
     */
    private static function getBasePath(): string
    {
        if (self::$basePath !== null) {
            return self::$basePath;
        }

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $scriptDir = dirname($scriptName);
        self::$basePath = $scriptDir === '/' ? '' : $scriptDir;

        return self::$basePath;
    }

    /**
     * Xử lý lỗi (404, 500)
     */
    private static function handleError(int $code, string $message = ''): void
    {
        http_response_code($code);

        if (class_exists('\App\Core\ErrorHandler')) {
            \App\Core\ErrorHandler::handle($code, $message);
            return;
        }

        // Fallback: hiển thị lỗi đơn giản
        echo "<h1>Error {$code}</h1>";
        if ($message && (defined('APP_DEBUG') && APP_DEBUG)) {
            echo "<p>{$message}</p>";
        }
    }

    /**
     * Set base path (dùng khi app nằm trong subfolder)
     */
    public static function setBasePath(string $path): void
    {
        self::$basePath = rtrim($path, '/');
    }
}
