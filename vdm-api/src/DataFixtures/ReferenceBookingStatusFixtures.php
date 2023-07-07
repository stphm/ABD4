<?php

namespace App\DataFixtures;

use App\Entity\ReferenceBookingStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReferenceBookingStatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $label) {
            $referenceBookingPaymentStatus = new ReferenceBookingStatus();
            $referenceBookingPaymentStatus->setLabel($label);

            $manager->persist($referenceBookingPaymentStatus);
        }
        $manager->flush();
    }

    private function getData(): \Generator
    {
        yield ReferenceBookingStatus::STATUS_PENDING;

        yield ReferenceBookingStatus::STATUS_VALIDATED;

        yield ReferenceBookingStatus::STATUS_REFUSED;
    }
}
