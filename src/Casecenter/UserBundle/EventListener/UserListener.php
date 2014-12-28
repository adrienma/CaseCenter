<?php

namespace Casecenter\UserBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\SecurityContext;

class UserListener
{
    protected $context;

    public function __construct(SecurityContext $context)
    {
    	$this->context = $context;
    }

    public function setLocaleUser(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {return;}

        if ($this->context->getToken() && $this->context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
        	$user = $this->context->getToken()->getUser();
        	if ($user->getLocale()) {$event->getRequest()->setLocale($user->getLocale());}
        }
    }
}