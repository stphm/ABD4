<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\GameRoomRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security('is_granted("ROLE_ADMIN")')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'admin.dashboard')]
    public function index(
        BookingRepository $bookingRepository,
        UserRepository $userRepository,
        GameRoomRepository $gameRoomRepository
    ): Response {
        return $this->render('dashboard/index.html.twig', [
            'daily_bookings' => $bookingRepository->countDailyBookings(),
            'daily_users' => $userRepository->countDailyUsers(),
            'total_users' => $userRepository->countTotalUsers(),
            'total_rooms' => $gameRoomRepository->countTotalRooms(),
        ]);
    }
}
