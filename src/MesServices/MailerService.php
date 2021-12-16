<?php 

namespace App\MesServices;

use DateTime;
use App\Entity\User;
use App\Entity\Orderbuy;
use App\Entity\Orderdetails;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactMail(array $data)
    {
        $email = (new TemplatedEmail())
                ->from('contact@symfonyecommerce.com')
                ->to('contact@symfonyecommerce.com')
                ->subject($data['content'])

                // path of the Twig template to render
                ->htmlTemplate('emails/email_contact.html.twig')

                // pass variables (name => value) to the template
                ->context([
                   
                    'content' => $data['content'],
                    
                    'mail' => $data['mail']
                    
                ])
            ;

        $this->mailer->send($email);
    }

    public function sendCommandMail(User $user,Orderbuy $orderbuy, Orderdetails $orderdetails)
    {
        $liste=[];
        foreach ($orderdetails as $items){
            $liste[]=$items;
        }
        $email = (new TemplatedEmail())
        ->from('support@symfonyecommerce.com')
        ->to($user->getEmail())
        ->subject('Atmosph\'air | Commande :' . $orderbuy->getId())

        // path of the Twig template to render
        ->htmlTemplate('emails/email_command_customer.html.twig')

        
        // pass variables (name => value) to the template
        ->context([
            
            'contents' => $liste,
            'user' => $user,
            'address' => $user->getAdress(),
            'total' => $orderbuy->getTotal(),
            'totalTTC' => $orderbuy->getTotalTTC(),
            'id' => $orderbuy->getId(),
            'createdAt' => $orderbuy->getDate()
        ])
    ;

$this->mailer->send($email);
    }
}