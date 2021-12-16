<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Orderbuy::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Orderdetails::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderdetailId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?orderbuy
    {
        return $this->orderId;
    }

    public function setOrderId(orderbuy $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOrderdetailId(): ?orderdetails
    {
        return $this->orderdetailId;
    }

    public function setOrderdetailId(?orderdetails $orderdetailId): self
    {
        $this->orderdetailId = $orderdetailId;

        return $this;
    }
}
