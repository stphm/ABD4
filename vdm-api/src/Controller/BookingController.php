<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\Query\SearchCriteriaQuery;
use App\Repository\ReferenceBookingPaymentStatusRepository;
use App\Repository\ReferenceBookingStatusRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security('is_granted("ROLE_ADMIN")')]
#[Route('/booking')]
class BookingController extends AbstractController
{
    #[Route('', name: 'bookings.index')]
    public function index(): Response
    {
        return $this->redirectToRoute('bookings.search');
    }

    #[Route('/search', name: 'bookings.search')]
    public function search(
        BookingRepository $bookingRepository,
        ReferenceBookingStatusRepository $refBookingStatusRepository,
        ReferenceBookingPaymentStatusRepository $refBookingPaymentStatusRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $queryBuilder = $bookingRepository->createQueryBuilder('b');

        $criteria = [
            'status' => $request->query->getInt('status'),
            'customer' => $request->query->get('customer'),
            'paymentStatus' => $request->query->getInt('paymentStatus'),
            'dateFrom' => $request->query->get('dateFrom'),
            'dateTo' => $request->query->get('dateTo'),
            'theme' => $request->query->getInt('theme'),
            '_query' => trim($request->query->get('query')),
        ];

        $query = new SearchCriteriaQuery($queryBuilder, $criteria);

        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 15),
            [
                'defaultSortFieldName' => 'b.createdAt',
                'defaultSortDirection' => 'desc',
            ]
        );

        return $this->render('booking/search.html.twig', [
            'pagination' => $pagination,
            'booking_status' => $refBookingStatusRepository->findAll(),
            'booking_payment_status' => $refBookingPaymentStatusRepository->findAll(),
            'search_criteria' => $criteria,
        ]);
    }

    #[Route('/{id}', name: 'bookings.show', requirements: ['id' => '\d+'])]
    public function show(int $id, BookingRepository $bookingRepository): Response
    {
        $booking = $bookingRepository->find($id);

        if (!$booking) {
            throw $this->createNotFoundException('Booking not found');
        }

        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }
}
