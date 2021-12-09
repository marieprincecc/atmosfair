<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $greatness;

    /**
     * @ORM\Column(type="integer")
     */
    private $pot;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $toxicity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $familly;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $water;

    /**
     * @ORM\Column(type="integer")
     */
    private $entretient;

    /**
     * @ORM\ManyToMany(targetEntity=Polluting::class, mappedBy="productId",cascade={"persist"})
     */
    private $pollutings;

    /**
     * @ORM\ManyToMany(targetEntity=Rooms::class, mappedBy="productId", cascade={"persist"})
     */
    private $rooms;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pathImage;

    public function __construct()
    {
        $this->pollutings = new ArrayCollection();
        $this->rooms = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGreatness(): ?int
    {
        return $this->greatness;
    }

    public function setGreatness(int $greatness): self
    {
        $this->greatness = $greatness;

        return $this;
    }

    public function getPot(): ?int
    {
        return $this->pot;
    }

    public function setPot(int $pot): self
    {
        $this->pot = $pot;

        return $this;
    }

    public function getToxicity(): ?string
    {
        return $this->toxicity;
    }

    public function setToxicity(string $toxicity): self
    {
        $this->toxicity = $toxicity;

        return $this;
    }

    public function getFamilly(): ?string
    {
        return $this->familly;
    }

    public function setFamilly(string $familly): self
    {
        $this->familly = $familly;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getWater(): ?int
    {
        return $this->water;
    }

    public function setWater(int $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getEntretient(): ?int
    {
        return $this->entretient;
    }

    public function setEntretient(int $entretient): self
    {
        $this->entretient = $entretient;

        return $this;
    }

    /**
     * @return Collection|Polluting[]
     */
    public function getPollutings(): Collection
    {
        return $this->pollutings;
    }

    public function addPolluting(Polluting $polluting): self
    {
        if (!$this->pollutings->contains($polluting)) {
            $this->pollutings[] = $polluting;
            $polluting->addProductId($this);
        }

        return $this;
    }

    public function removePolluting(Polluting $polluting): self
    {
        if ($this->pollutings->removeElement($polluting)) {
            $polluting->removeProductId($this);
        }

        return $this;
    }

    /**
     * @return Collection|Rooms[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Rooms $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->addProductId($this);
        }

        return $this;
    }

    public function removeRoom(Rooms $room): self
    {
        if ($this->rooms->removeElement($room)) {
            $room->removeProductId($this);
        }

        return $this;
    }


    public function getPathImage(): ?string
    {
        return $this->pathImage;
    }

    public function setPathImage(string $pathImage): self
    {
        $this->pathImage = $pathImage;

        return $this;
    }
}
