<?php

namespace App\Entity;

use App\Repository\PollutingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PollutingRepository::class)
 */
class Polluting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=product::class, inversedBy="pollutings")
     */
    private $productId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subst;

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

    public function getSubst(): ?string
    {
        return $this->subst;
    }

    public function setSubst(string $subst): self
    {
        $this->subst = $subst;

        return $this;
    }
}
