<?php

namespace App\Entity;

use App\Repository\PortableEqipmentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=PortableEqipmentTypeRepository::class)
 */
class PortableEqipmentType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({ "type_list" })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({ "equipment_list", "type_list", "order_list" })
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=PortableEqipment::class, mappedBy="type")
     * @Serializer\Groups({ "type_list" })
     */
    private $portableEqipments;

    public function __construct()
    {
        $this->portableEqipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $portableEqipment->setType($this);
        }

        return $this;
    }

    public function removePortableEqipment(PortableEqipment $portableEqipment): self
    {
        if ($this->portableEqipments->removeElement($portableEqipment)) {
            // set the owning side to null (unless already changed)
            if ($portableEqipment->getType() === $this) {
                $portableEqipment->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->type;
    }
}
