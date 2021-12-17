<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderbuyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=OrderbuyRepository::class)
 * @ORM\HasLifecycleCallbacks 
 */
class Orderbuy
{
    public const PENDING = "en cours de validation";

    public const SEND = "envoyé";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderbuys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Adress::class, inversedBy="orderbuys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adressId;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalTTC;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = self::PENDING;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Orderdetails::class, mappedBy="orderbuyId")
     */
    private $orderdetails;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPayed = false;

    public function __construct()
    {
        $this->orderdetails = new ArrayCollection();
    }

    /**
    * @ORM\PrePersist
    */
    public function prePersist()
    {
    if(empty($this->date))
    {
    $this->date = new DateTime();
    }
    } 

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdressId(): ?adress
    {
        return $this->adressId;
    }

    public function setAdressId(?adress $adressId): self
    {
        $this->adressId = $adressId;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalTTC(): ?int
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(int $totalTTC): self
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Orderdetails[]
     */
    public function getOrderdetails(): Collection
    {
        return $this->orderdetails;
    }

    public function addOrderdetail(Orderdetails $orderdetail): self
    {
        if (!$this->orderdetails->contains($orderdetail)) {
            $this->orderdetails[] = $orderdetail;
            $orderdetail->setOrderbuyId($this);
        }

        return $this;
    }

    public function removeOrderdetail(Orderdetails $orderdetail): self
    {
        if ($this->orderdetails->removeElement($orderdetail)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail->getOrderbuyId() === $this) {
                $orderdetail->setOrderbuyId(null);
            }
        }

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

        return $this;
    }
}
