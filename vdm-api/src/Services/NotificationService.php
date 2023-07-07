<?php

namespace App\Services;

use App\Services\Mercure\Jwt\StaticJwtProvider;
use App\Services\Mercure\Publisher;
use App\Services\Mercure\PublisherInterface;
use App\Services\Mercure\Update;

final class NotificationService
{
    private readonly PublisherInterface $publisher;

    public function __construct()
    {
        $this->publisher = new Publisher(
            'http://mercure_hub/.well-known/mercure',
            new StaticJwtProvider(
                'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.a8cjcSRUAcHdnGNMKifA4BK5epRXxQI0UBp2XpNrBdw'
            ),
        );
    }

    public function sendMercureNotification(Update $update)
    {
        $this->publisher->__invoke($update);
    }
}
