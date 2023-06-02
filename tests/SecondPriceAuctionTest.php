<?php

namespace App\Tests;

use App\Repository\BidRepository;
use App\Service\SecondPriceAuction;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SecondPriceAuctionTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @dataProvider auctionDataProvider
     */
    public function testFindWinner(array $bids)
    {
        // Mock the bid repository
        $bidRepositoryMock = $this->getMockBuilder(BidRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $bidRepositoryMock->expects($this->once())
            ->method('getBidsByBuyer')
            ->willReturn($bids);

        $yourService = new SecondPriceAuction($bidRepositoryMock);

        $reservePrice = 100;

        $result = $yourService->findWinner($reservePrice);

        $expectedResult = [
            'winner' => 'E',
            'winningPrice' => 130,
        ];
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function auctionDataProvider(): array
    {
        $bids = [
            'A' => [110, 130],
            'B' => [],
            'C' => [125],
            'D' => [105, 115, 90],
            'E' => [132, 135, 140],
        ];

        return [
            [$bids, 100, 'E', 130],
        ];
    }
}