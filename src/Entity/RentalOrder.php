<?php

namespace App\Entity;

use App\Repository\RentalOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=RentalOrderRepository::class)
 */
class RentalOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({ "order_list" })
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="rentalOrdersStartStations")
     * @Serializer\Groups({ "order_list" })
     */
    private $startStation;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="rentalOrdersEndStations")
     * @Serializer\Groups({ "order_list" })
     */
    private $endStation;

    /**
     * @ORM\ManyToOne(targetEntity=Campervan::class, inversedBy="rentalOrders")
     * @Serializer\Groups({ "order_list" })
     */
    private $campervan;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({ "order_list" })
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({ "order_list" })
     */
    private $endDate;

    /**
     * @ORM\ManyToMany(targetEntity=PortableEqipment::class, inversedBy="rentalOrders")
     * @Serializer\Groups({ "order_list" })
     */
    private $equipments;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartStation(): ?Station
    {
        return $this->startStation;
    }

    public function setStartStation(?Station $startStation): self
    {
        $this->startStation = $startStation;

        return $this;
    }

    public function getEndStation(): ?Station
    {
        return $this->endStation;
    }

    public function setEndStation(?Station $endStation): self
    {
        $this->endStation = $endStation;

        return $this;
    }

    public function getCampervan(): ?Campervan
    {
        return $this->campervan;
    }

    public function setCampervan(?Campervan $campervan): self
    {
        $this->campervan = $campervan;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this; 
    }

    /**
     * @return Collection|PortableEqipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(PortableEqipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
        }

        return $this;
    }

    public function removeEquipment(PortableEqipment $equipment): self
    {
        $this->equipments->removeElement($equipment);

        return $this;
    }

}
