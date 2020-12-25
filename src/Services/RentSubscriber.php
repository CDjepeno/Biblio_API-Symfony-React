<?php
namespace App\Services;

use App\Entity\BookRent;
use Doctrine\ORM\Events;
use Doctrine\DBAL\Schema\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RentSubscriber implements EventSubscriberInterface
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_WRITE]
        ];
    }

    public function getAuthenticatedUser(ViewEvent $event)
    {
        $entity = $event->getControllerResult(); // récupère l'entité qui a déclenché l'évènement
        $method = $event->getRequest()->getMethod(); // récupère la méthode invoquée dans la request
        $member = $this->token->getToken()->getUser(); // récupère le membre actuellement connecté
        
        if ($entity instanceof BookRent) {
            if ($method == Request::METHOD_POST) {
                $entity->setMember($member); // on écrit le membre dans la propriété member de l'entity BookRent
            } elseif ($method == Request::METHOD_PUT) {
                if ($entity->getDateRealReturn() == null) {
                    $entity->getBook()->setAvailable(false);
                } else {
                    $entity->getBook()->setAvailable(true);
                }
            } elseif ($method == Request::METHOD_PUT) {
                $entity->getBook()->setAvailable(true);
            }
        }
        return;
    }
}