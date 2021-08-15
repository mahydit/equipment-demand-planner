<?php

namespace App\Entity;

use App\Repository\PortableEqipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PortableEqipmentRepository::class)
 */
class PortableEqipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=PortableEqipmentType::class, inversedBy="portableEqipments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="portableEqipments")
     */
    private $atStation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isUsed;

    /**
     * @ORM\ManyToMany(targetEntity=RentalOrder::class, mappedBy="equipments")
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?PortableEqipmentType
    {
        return $this->type;
    }

    public function setType(?PortableEqipmentType $type): self
    {
        $this->type = $type;

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

    public function getIsUsed(): ?bool
    {
        return $this->isUsed;
    }

    public function setIsUsed(bool $isUsed): self
    {
        $this->isUsed = $isUsed;

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
            $rentalOrder->addEquipment($this);
        }

        return $this;
    }

    public function removeRentalOrder(RentalOrder $rentalOrder): self
    {
        if ($this->rentalOrders->removeElement($rentalOrder)) {
            $rentalOrder->removeEquipment($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
