<?php 
namespace App\EventSubscriber;

use App\Entity\Hebergement;
use App\Repository\HebergementRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $repo;

    public function __construct(HebergementRepository $repo)
    {
        $this->repo = $repo;
        dd(0);
    }

    // public static function getSubscribedEvents()
    // {
    //     return array(
    //         'easy_admin.pre_persist' => array('setBlogPostSlug'),
    //     );
    // }

    public static function getSubscribedEvents()
    {
        dd(00);
        return [
            BeforeEntityPersistedEvent::class => ['setBlogPostSlug'],
        ];
    }

    public function setBlogPostSlug(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof Hebergement)) {
            // Voir pk je passe pas dans se code la 
            return;
        }
           
        $result = $this->repo->findById($entity->getId());      
         dd($result[0]);      
        $entity->setImage($result[0]->getImage());

        $event['entity'] = $entity;
    }
    
}
