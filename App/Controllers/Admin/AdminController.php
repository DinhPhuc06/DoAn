<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Service;

class AdminController extends Controller
{
    private User $userModel;
    private RoomType $roomTypeModel;
    private Room $roomModel;
    private Booking $bookingModel;
    private Service $serviceModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewPath = BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Views';
        $this->layoutPath = BASE_PATH . '/App/Views/Layouts/admin-layout.php';
        $this->userModel = new User();
        $this->roomTypeModel = new RoomType();
        $this->roomModel = new Room();
        $this->bookingModel = new Booking();
        $this->serviceModel = new Service();
    }

    public function dashboard(): void
    {
        // Get statistics
        $totalUsers = $this->userModel->count();
        $totalRoomTypes = $this->roomTypeModel->count();
        $totalRooms = $this->roomModel->count();
        $totalBookings = $this->bookingModel->count();

        // Recent bookings
        $recentBookings = $this->bookingModel->getRecent(5);

        $this->useLayout = true;
        $this->render('Admin/dashboard', [
            'title' => 'Dashboard - Admin Panel',
            'pageTitle' => 'Dashboard',
            'currentPage' => 'dashboard',
            'totalUsers' => $totalUsers,
            'totalRoomTypes' => $totalRoomTypes,
            'totalRooms' => $totalRooms,
            'totalBookings' => $totalBookings,
            'recentBookings' => $recentBookings,
        ]);
    }
}
