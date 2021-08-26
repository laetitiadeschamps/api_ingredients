<?php

namespace App\EventListener;

use App\Entity\Category;
use App\Entity\Ingredient;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class SlugSubscriber implements EventSubscriber
{
    private $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Category | !$entity instanceof Ingredient ) {
            return;
        }

       
        $slug = $this->slugger->slug(strtolower($entity->getName()));
        $entity->setSlug($slug);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Category | !$entity instanceof Ingredient) {
            return;
        }

        // Maj du slug à chaque mise à jour d'un TvShow
        $slug = $this->slugger->slug(strtolower($entity->getName()));
        $entity->setSlug($slug);
    }
}