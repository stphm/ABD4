<?php

namespace App\EventListener;

use App\Event\BookingConfirmedEvent;
use App\Services\Mercure\Update;
use App\Services\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class BookingSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly NotificationService $notification,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BookingConfirmedEvent::class => 'onBookingConfirmed',
        ];
    }

    public function onBookingConfirmed(BookingConfirmedEvent $event): void
    {
        try {
            $update = new Update(
                'bookings.confirmed',
                json_encode(
                    [
                        'id' => $event->getBookingId(),
                        'url' => $this->urlGenerator->generate(
                            'bookings.show',
                            ['id' => $event->getBookingId()],
                            UrlGeneratorInterface::ABSOLUTE_URL
                        ),
                    ]
                )
            );
            $this->notification->sendMercureNotification($update);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
