<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Category;
use App\Entity\Ingredient;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\String\Slugger\SluggerInterface;

final class SlugSubscriber implements EventSubscriberInterface
{
    private $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['slugify', EventPriorities::PRE_WRITE]
        ];
    }

    public function slugify(ViewEvent $event): void
    {
       
        $entity = $event->getControllerResult();
        $method = $event ->getRequest()->getMethod();
       
        if (!($entity instanceof Category || $entity instanceof Ingredient) || $method !== "POST" ) {
            return;
        }
        
       
        $slug = $this->slugger->slug(strtolower($entity->getName()));
        $entity->setSlug($slug);
    }

   
}