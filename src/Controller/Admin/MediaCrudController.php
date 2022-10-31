<?php 
namespace App\Controller\Admin;

use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;


class MediaCrudController extends AbstractCrudController{

    public const MEDIA_BASE_PATH = 'upload/images/hebergements';
    public const MEDIA_UPLOAD_DIR ='public/upload/images/hebergements';

    public static function getEntityFqcn (): string {
        return Media::class;
    } 

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('media_relation', 'hébergement associé')
                ->setRequired(true)
                ->setFormTypeOption('choice_label', 'title')
                ->formatValue(function($id, $entite){
                    if($entite->getMediaRelation() == null){
                        return '';
                    }
                    return $entite -> getMediaRelation()->getTitle();
                }),
            TextField::new('media_alt', 'alt'),
            ImageField::new('media', 'média du logement')
                ->setBasePath(self::MEDIA_BASE_PATH)
                ->setUploadDir(self::MEDIA_UPLOAD_DIR)
            
                ->setSortable(false)
                ->setRequired(false),
            BooleanField::new('active', 'Active')
        ];    
    }
}




?>