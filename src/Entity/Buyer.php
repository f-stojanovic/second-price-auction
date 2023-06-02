<?php

namespace App\Entity;

use App\Repository\BuyerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BuyerRepository::class)]
class Buyer
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $uuid;

    #[ORM\Column(type: "string")]
    private ?string $name;


    #[ORM\OneToMany(mappedBy: "buyer", targetEntity: Bid::class, cascade: ["persist", "remove"])]
    private Collection $bids;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->bids = new ArrayCollection();
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getBids(): ArrayCollection
    {
        return $this->bids;
    }

    /**
     * @param ArrayCollection $bids
     */
    public function setBids(ArrayCollection $bids): void
    {
        $this->bids = $bids;
    }


    public function addBid(Bid $bid): self
    {
        if (!$this->bids->contains($bid)) {
            $this->bids[] = $bid;
            $bid->setBuyer($this);
        }

        return $this;
    }

    public function removeBid(Bid $bid): self
    {
        if ($this->bids->contains($bid)) {
            $this->bids->removeElement($bid);
            // set the owning side to null (unless already changed)
            if ($bid->getBuyer() === $this) {
                $bid->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getBuyerIdAsString(): string
    {
        return $this->uuid->toBase32();
    }

}
