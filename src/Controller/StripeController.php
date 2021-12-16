<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use App\Entity\Adress;
use App\Entity\Orderbuy;
use App\Entity\Orderdetails;
use Stripe\Checkout\Session;
use App\MesServices\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\CartService\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/create-checkout-session', name: 'create_checkout_session')]  
    public function createSession(CartService $cartService)
    {
        Stripe::setApiKey('sk_test_51IBjOmJxItuCvN48kVDdR9Tg52Npf4IJydX0TFxyioJFxo5vdlObzoYYTmiVZ2BD2XqGQkvsWaj8UNNzEz3ekgMo00jPcW004c');

        $domain = 'https://localhost:8000';
        
        /** @var User $user */
        $user = $this->getUser();

        /** @var CartRealProduct[] $detailCart */
        $detailCart = $cartService->getDetailedCartItems();

        $productForStripe = [];

        foreach($detailCart as $item)
        {
            $productForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getProduct()->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct()->getName(),
                        'images' => [
                            $domain . $item->getProduct()->getPathImage()
                        ]
                    ]
                ],
                'quantity' => $item->getQty()
            ];
        }

        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'payment_method_types' => [
                'card',
            ],
            'line_items' => [
                $productForStripe
            ],
            'mode' => 'payment',
              'success_url' => $domain . '/paiementreussi',
              'cancel_url' => $domain . '/paiementechoue',
          ]);

          return $this->redirect($checkout_session->url);
    }

    #[Route('/paiementreussi', name: 'payment_success')] 
    public function paymentSuccess(CartService $cartService,EntityManagerInterface $em,
                                MailerService $mailerService)
    {
        /** @var User $user */
        $user = $this->getUser();
        $adressUser = $user->getAdress();

        /** @var Orderbuy $orderbuy */
        
        $orderbuy = new Orderbuy();
        $orderbuy->setUser($user);
        $orderbuy->setTotal($cartService->getTotal());
        $orderbuy->setTotalTTC($cartService->getTotalTTC());
        $orderbuy->setAdressId($adressUser);
        $em->persist($orderbuy);
        $em->flush();
        
        $orderdetails = new Orderdetails();

         /** @var CartRealProduct[] $detailCart */
         $detailCart = $cartService->getDetailedCartItems();

         foreach ($detailCart as $item) {
            $orderdetails = new Orderdetails();
            $orderdetails->setProduct($item->getProduct());
            $orderdetails->setQuantity($item->getQty());
            $orderdetails->setOrderbuyId($orderbuy);
            $em->persist($orderdetails);
         }

         $em->flush();

         $mailerService->sendCommandMail($user, $orderbuy, $orderdetails);

         $this->addFlash("success","Votre commande a bien été pris en compte.");
         $cartService->emptyCart();
         return $this->redirectToRoute("cart_detail");
    } 

    #[Route('/paiementechoue', name: 'payment_cancel')] 
    public function paymentCancel()
    {
        $this->addFlash("info","Votre commande n'a pu aboutir. Vous pouvez essayer avec une manière de paiement.");
        return $this->redirectToRoute("cart_detail");
    }




}
