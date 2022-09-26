<?php 
namespace App\EventSubscriber;

use App\Entity\Hebergement;
use App\Repository\HebergementRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;

class HebergementUpdateEvent implements EventSubscriberInterface
{
    private $repo;

    public function __construct(HebergementRepository $repo)
    {
        $this->repo = $repo;
       
    }

    // public static function getSubscribedEvents()
    // {
    //     return array(
    //         'easy_admin.pre_persist' => array('setBlogPostSlug'),
    //     );
    // }

    public static function getSubscribedEvents()
    {        
        return [
            BeforeEntityUpdatedEvent::class => ['setBlogPostSlug'],
        ];
    }

    public function setBlogPostSlug(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();
        
        // if (!($entity instanceof Hebergement)) {
        //     return;
        // }
           
        // $result = $this->repo->findById($entity->getId());      
        //   dd($result[0]);      
        // $entity->setImage($result[0]->getImage());

        // $event['entity'] = $entity;






    }
    
}
