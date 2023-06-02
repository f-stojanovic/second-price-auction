<?php

namespace App\Service;

interface AuctionInterface
{
    public function findWinner(int $reservePrice): array;
}