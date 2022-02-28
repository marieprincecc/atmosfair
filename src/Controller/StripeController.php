<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use Stripe\LoginLink;
use App\Entity\Adress;
use App\Entity\Orderbuy;
use App\Entity\Orderdetails;
use Stripe\Checkout\Session;
use App\MesServices\MailerService;
use App\Repository\UserRepository;
use App\MesServices\OrderbuyService;
use App\Repository\OrderbuyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\CartService\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

/**
* @Route("/{_locale<%app.supported_locales%>}")
*/
class StripeController extends AbstractController
{
    #[Route('/create-checkout-session', name: 'create_checkout_session')]  
    public function createSession(CartService $cartService, OrderbuyService $orderbuyService)
    {
        Stripe::setApiKey('sk_test_51IBjOmJxItuCvN48kVDdR9Tg52Npf4IJydX0TFxyioJFxo5vdlObzoYYTmiVZ2BD2XqGQkvsWaj8UNNzEz3ekgMo00jPcW004c');

        $domain = 'https://localhost:8000';
        
        /** @var User $user */
        $user = $this->getUser();
        $orderbuyService->create($user);
        $id = $user->getId();
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
              'success_url' => $domain . '/redirectionPaiementReussi/' . $user->getId(), 
              'cancel_url' => $domain . '/paiementechoue',
          ]);

          return $this->redirect($checkout_session->url);
    }

        /**
        * @Route("/redirectionPaiementReussi/{id}", name="redirection_paiement_reussi")
        */
        public function redirectionPaiementReussi(int $id ,LoginLinkHandlerInterface $loginLinkHandler, UserRepository $userRepository, Request $request)
        { 
        $user = $userRepository->find($id);
        $loginLinkDetails = $loginLinkHandler->createLoginLink($user);
        $loginLink = $loginLinkDetails->getUrl();
        return $this->redirect($loginLink);
        } 

    #[Route('/paiementreussi', name: 'payment_success')] 
    public function paymentSuccess(UserRepository $userRepository, CartService $cartService,EntityManagerInterface $em,
                                MailerService $mailerService, OrderbuyRepository $orderbuyRepository)
    {   
        
        /** @var User $user */
        $user = $this->getUser();
        $adressUser = $user->getAdress();
        $orderbuy = $orderbuyRepository->findOneBy([
            'user' => $user
            ],[
            'date' => 'DESC'
            ]);
            
            $orderbuy->setIsPayed(1); 
         $em->flush();
         $mailerService->sendCommandMail($user, $orderbuy);

         $this->addFlash("isSuccessful","Votre commande a bien été pris en compte.");
         $cartService->emptyCart();
         return $this->redirectToRoute("thanks");
    } 

    #[Route('/paiementechoue', name: 'payment_cancel')] 
    public function paymentCancel()
    {
        $this->addFlash("notSucced","Votre commande n'a pu aboutir. Vous pouvez essayer avec une manière de paiement.");
        return $this->redirectToRoute("cart_detail");
    }




}
