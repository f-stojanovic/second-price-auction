<?php

namespace App\Entity;

use App\Repository\BidRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BidRepository::class)]
class Bid
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $uuid;

    #[ORM\Column(type: "float")]
    private ?float $amount;

    #[ORM\ManyToOne(targetEntity: Buyer::class, inversedBy: "bids")]
    #[ORM\JoinColumn(name: "buyer_id", referencedColumnName: "uuid", nullable: false)]
    private ?Buyer $buyer;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return Buyer|null
     */
    public function getBuyer(): ?Buyer
    {
        return $this->buyer;
    }

    /**
     * @param Buyer|null $buyer
     */
    public function setBuyer(?Buyer $buyer): void
    {
        $this->buyer = $buyer;
    }
}
