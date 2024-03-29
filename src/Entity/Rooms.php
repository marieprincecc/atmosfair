<?php

namespace App\Entity;

use App\Repository\RoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomsRepository::class)
 */
class Rooms
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="rooms")
     */
    private $productId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $room;

    public function __toString()
    {
        return $this->room;
    }

    public function __construct()
    {
        $this->productId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|product[]
     */
    public function getProductId(): Collection
    {
        return $this->productId;
    }

    public function addProductId(product $productId): self
    {
        if (!$this->productId->contains($productId)) {
            $this->productId[] = $productId;
        }

        return $this;
    }

    public function removeProductId(product $productId): self
    {
        $this->productId->removeElement($productId);

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(string $room): self
    {
        $this->room = $room;

        return $this;
    }
}
