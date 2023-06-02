<?php

namespace App\Controller;

use App\Service\AuctionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuctionController extends AbstractController
{
    public function __construct(
       private readonly AuctionInterface $auctionRunner
    ) {
    }

    #[Route('/', name: 'auction_result_action')]
    public function getAuctionResultAction(): Response
    {
        $reservePrice = 100;

        $result = $this->auctionRunner->findWinner($reservePrice);

        return $this->render('auction-result.html.twig', [
            'result' => $result,
        ]);
    }
}