<?php

namespace App\MesServices;

use App\Entity\User;
use App\Entity\Orderbuy;
use App\Entity\Orderdetails;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\CartService\CartService;

class OrderbuyService 
{
    private $em;
    private $cartService;

    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
    $this->em = $em;
    $this->cartService =$cartService;
} 
    public function create(User $user)
    {
         /** @var Orderbuy $orderbuy */
        
         $orderbuy = new Orderbuy();
         $orderbuy->setUser($user);
         $orderbuy->setTotal($this->cartService->getTotal());
         $orderbuy->setTotalTTC($this->cartService->getTotalTTC());
         $orderbuy->setAdressId($user->getAdress());
         $this->em->persist($orderbuy);
         $this->em->flush();
         
         $orderdetails = new Orderdetails();
 
          /** @var CartRealProduct[] $detailCart */
          $detailCart = $this->cartService->getDetailedCartItems();
 
          foreach ($detailCart as $item) {
             $orderdetails = new Orderdetails();
             $orderdetails->setProduct($item->getProduct());
             $orderdetails->setQuantity($item->getQty());
             $orderdetails->setOrderbuyId($orderbuy);
             $this->em->persist($orderdetails);
          }
 
          $this->em->flush();
    }
}
