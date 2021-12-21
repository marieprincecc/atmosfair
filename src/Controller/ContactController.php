<?php 

namespace App\Controller;

use App\Form\ContactType;
use App\MesServices\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    #[Route('/utility/sendmail', name: 'send_mail_contact')]
public function contact(Request $request,MailerService $mailerService)
{ 
    
    $parameters = $request->request;
    if (count($parameters) >0 ) {
        $data=[];
        
        $data['content']=$parameters->get('content');
        $data['mail']=$parameters->get('mail');
        $data['nom']=$parameters->get('nom');
        $data['prenom']=$parameters->get('prenom');
       
       $mailerService->sendContactMail($data);
    }
    $referer = $request->headers->get('referer'); 
    return new RedirectResponse($referer); 

}
}

