<?php

namespace App\Entity;

use App\Repository\CampervanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampervanRepository::class)
 */
class Campervan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOnTheRoad;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="campervans")
     */
    private $atStation;

    /**
     * @ORM\OneToMany(targetEntity=RentalOrder::class, mappedBy="campervan")
     */
    private $rentalOrders;

    public function __construct()
    {
        $this->rentalOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarNumber(): ?string
    {
        return $this->carNumber;
    }

    public function setCarNumber(string $carNumber): self
    {
        $this->carNumber = $carNumber;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getIsOnTheRoad(): ?bool
    {
        return $this->isOnTheRoad;
    }

    public function setIsOnTheRoad(bool $isOnTheRoad): self
    {
        $this->isOnTheRoad = $isOnTheRoad;

        return $this;
    }

    public function getAtStation(): ?Station
    {
        return $this->atStation;
    }

    public function setAtStation(?Station $atStation): self
    {
        $this->atStation = $atStation;

        return $this;
    }

    /**
     * @return Collection|RentalOrder[]
     */
    public function getRentalOrders(): Collection
    {
        return $this->rentalOrders;
    }

    public function addRentalOrder(RentalOrder $rentalOrder): self
    {
        if (!$this->rentalOrders->contains($rentalOrder)) {
            $this->rentalOrders[] = $rentalOrder;
            $rentalOrder->setCampervan($this);
        }

        return $this;
    }

    public function removeRentalOrder(RentalOrder $rentalOrder): self
    {
        if ($this->rentalOrders->removeElement($rentalOrder)) {
            // set the owning side to null (unless already changed)
            if ($rentalOrder->getCampervan() === $this) {
                $rentalOrder->setCampervan(null);
            }
        }

        return $this;
    }
}
