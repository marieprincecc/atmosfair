<?php
namespace App\Listener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelListener
{
    private $defaultLocale;

    public function __construct( string $defaultLocale = 'fr')
    {
        $this->defaultLocale = $defaultLocale;
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $language = $request->getPreferredLanguage();
    
            if(!$language){
                $request->setLocale($this->defaultLocale);
            }else{
               
                $language = explode("_",$language);
                $language = $language[0];
                if ($language != "en" && $language !="fr") {
                    $request->setLocale($this->defaultLocale);
                }else {
                    $request->setLocale($language);
                }
            }
        
        
    }
}