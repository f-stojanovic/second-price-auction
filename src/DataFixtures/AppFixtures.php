<?php

namespace App\DataFixtures;

use App\Entity\Buyer;
use App\Entity\Bid;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create buyers
        $buyerA = new Buyer();
        $buyerA->setName('A');

        $buyerB = new Buyer();
        $buyerB->setName('B');

        $buyerC = new Buyer();
        $buyerC->setName('C');

        $buyerD = new Buyer();
        $buyerD->setName('D');

        $buyerE = new Buyer();
        $buyerE->setName('E');

        // Create bids for each buyer
        $buyerA->addBid($this->createBid($buyerA, 110));
        $buyerA->addBid($this->createBid($buyerA, 130));

        // Buyer B has no bids

        $buyerC->addBid($this->createBid($buyerC, 125));

        $buyerD->addBid($this->createBid($buyerD, 105));
        $buyerD->addBid($this->createBid($buyerD, 115));
        $buyerD->addBid($this->createBid($buyerD, 90));

        $buyerE->addBid($this->createBid($buyerE, 132));
        $buyerE->addBid($this->createBid($buyerE, 135));
        $buyerE->addBid($this->createBid($buyerE, 140));

        // Persist buyers and bids
        $manager->persist($buyerA);
        $manager->persist($buyerB);
        $manager->persist($buyerC);
        $manager->persist($buyerD);
        $manager->persist($buyerE);

        $manager->flush();
    }

    private function createBid(Buyer $buyer, float $amount): Bid
    {
        $bid = new Bid();
        $bid->setBuyer($buyer);
        $bid->setAmount($amount);

        return $bid;
    }
}