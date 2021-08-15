<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StationRepository::class)
 */
class Station
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=PortableEqipment::class, mappedBy="atStation")
     */
    private $portableEqipments;

    /**
     * @ORM\OneToMany(targetEntity=Campervan::class, mappedBy="atStation")
     */
    private $campervans;

    /**
     * @ORM\OneToMany(targetEntity=RentalOrder::class, mappedBy="startStation")
     */
    private $rentalOrdersStartStations;

    /**
     * @ORM\OneToMany(targetEntity=RentalOrder::class, mappedBy="endStation")
     */
    private $rentalOrdersEndStations;

    public function __construct()
    {
        $this->portableEqipments = new ArrayCollection();
        $this->campervans = new ArrayCollection();
        $this->rentalOrdersStartStations = new ArrayCollection();
        $this->rentalOrdersEndStations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|PortableEqipment[]
     */
    public function getPortableEqipments(): Collection
    {
        return $this->portableEqipments;
    }

    public function addPortableEqipment(PortableEqipment $portableEqipment): self
    {
        if (!$this->portableEqipments->contains($portableEqipment)) {
            $this->portableEqipments[] = $portableEqipment;
            $portableEqipment->setAtStation($this);
        }

        return $this;
    }

    public function removePortableEqipment(PortableEqipment $portableEqipment): self
    {
        if ($this->portableEqipments->removeElement($portableEqipment)) {
            // set the owning side to null (unless already changed)
            if ($portableEqipment->getAtStation() === $this) {
                $portableEqipment->setAtStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Campervan[]
     */
    public function getCampervans(): Collection
    {
        return $this->campervans;
    }

    public function addCampervan(Campervan $campervan): self
    {
        if (!$this->campervans->contains($campervan)) {
            $this->campervans[] = $campervan;
            $campervan->setAtStation($this);
        }

        return $this;
    }

    public function removeCampervan(Campervan $campervan): self
    {
        if ($this->campervans->removeElement($campervan)) {
            // set the owning side to null (unless already changed)
            if ($campervan->getAtStation() === $this) {
                $campervan->setAtStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RentalOrder[]
     */
    public function getRentalOrdersStartStations(): Collection
    {
        return $this->rentalOrdersStartStations;
    }

    public function addRentalOrdersStartStation(RentalOrder $rentalOrdersStartStation): self
    {
        if (!$this->rentalOrdersStartStations->contains($rentalOrdersStartStation)) {
            $this->rentalOrdersStartStations[] = $rentalOrdersStartStation;
            $rentalOrdersStartStation->setStartStation($this);
        }

        return $this;
    }

    public function removeRentalOrdersStartStation(RentalOrder $rentalOrdersStartStation): self
    {
        if ($this->rentalOrdersStartStations->removeElement($rentalOrdersStartStation)) {
            // set the owning side to null (unless already changed)
            if ($rentalOrdersStartStation->getStartStation() === $this) {
                $rentalOrdersStartStation->setStartStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RentalOrder[]
     */
    public function getRentalOrdersEndStations(): Collection
    {
        return $this->rentalOrdersEndStations;
    }

    public function addRentalOrdersEndStation(RentalOrder $rentalOrdersEndStation): self
    {
        if (!$this->rentalOrdersEndStations->contains($rentalOrdersEndStation)) {
            $this->rentalOrdersEndStations[] = $rentalOrdersEndStation;
            $rentalOrdersEndStation->setEndStation($this);
        }

        return $this;
    }

    public function removeRentalOrdersEndStation(RentalOrder $rentalOrdersEndStation): self
    {
        if ($this->rentalOrdersEndStations->removeElement($rentalOrdersEndStation)) {
            // set the owning side to null (unless already changed)
            if ($rentalOrdersEndStation->getEndStation() === $this) {
                $rentalOrdersEndStation->setEndStation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

}
