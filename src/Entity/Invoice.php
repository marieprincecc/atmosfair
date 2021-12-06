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
     * @ORM\OneToOne(targetEntity=orderbuy::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderId;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity=orderdetails::class, inversedBy="invoices")
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

    public function getUserId(): ?user
    {
        return $this->userId;
    }

    public function setUserId(?user $userId): self
    {
        $this->userId = $userId;

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
