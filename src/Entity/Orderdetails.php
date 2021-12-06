<?php

namespace App\Entity;

use App\Repository\OrderdetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderdetailsRepository::class)
 */
class Orderdetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=orderbuy::class, inversedBy="orderdetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderbuyId;

    /**
     * @ORM\ManyToMany(targetEntity=product::class, inversedBy="orderdetails")
     */
    private $productId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceTotal;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="orderdetailId")
     */
    private $invoices;

    public function __construct()
    {
        $this->productId = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderbuyId(): ?orderbuy
    {
        return $this->orderbuyId;
    }

    public function setOrderbuyId(?orderbuy $orderbuyId): self
    {
        $this->orderbuyId = $orderbuyId;

        return $this;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPriceTotal(): ?int
    {
        return $this->priceTotal;
    }

    public function setPriceTotal(int $priceTotal): self
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setOrderdetailId($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getOrderdetailId() === $this) {
                $invoice->setOrderdetailId(null);
            }
        }

        return $this;
    }
}
