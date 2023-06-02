<?php

namespace App\Service;

use App\Repository\BidRepositoryInterface;

class SecondPriceAuction implements AuctionInterface
{
    public function __construct(
        private readonly BidRepositoryInterface $bidRepository
    ) {
    }

    public function findWinner(int $reservePrice): array
    {
        $bids = $this->bidRepository->getBidsByBuyer();

        $winningPrice = $reservePrice;
        $winner = '';

        $validBids = [];

        foreach ($bids as $buyer => $bidList) {
            foreach ($bidList as $bid) {
                if ($bid >= $reservePrice) {
                    $validBids[] = ['buyer' => $buyer, 'bid' => $bid];
                }
            }
        }

        usort($validBids, function($aBid, $bBid) {
            return $bBid['bid'] <=> $aBid['bid'];
        });

        if (count($validBids) > 0) {
            $winner = $validBids[0]['buyer'];
            $validBidsCount = count($validBids);
            for ($i = 1; $i < $validBidsCount; $i++) {
                if ($validBids[$i]['buyer'] != $winner) {
                    $winningPrice = $validBids[$i]['bid'];
                    break;
                }
            }
        }


        return ['winner' => $winner, 'winningPrice' => $winningPrice];
    }
}