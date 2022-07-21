<?php

namespace App\Controller\Admin;

use App\Entity\Hebergement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class HebergementCrudController extends AbstractCrudController
{

    public const HEBERGEMENTS_BASE_PATH= 'upload/images/hebergements';
    public const HEBERGEMENTS_UPLOAD_DIR ='public/upload/images/hebergements';

    public static function getEntityFqcn(): string
    {
        return Hebergement::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title' , 'Titre'),
            TextEditorField::new('description', 'Description'),
            TextField::new('lieux' , 'Lieu'),
            AssociationField::new('categories', 'Categorie.s')->setRequired(true),
            BooleanField::new('active', 'Active'),
            TextField::new('surface', 'Surface'),
            MoneyField::new('tarif', 'Prix')->setCurrency('EUR'),
            BooleanField::new('isPromotional', 'Promotion'),
            TextField::new('promotion', 'Montant de la promotion'),

            ImageField::new('image', 'Image de présentation')
                ->setBasePath(self::HEBERGEMENTS_BASE_PATH)
                ->setUploadDir(self::HEBERGEMENTS_UPLOAD_DIR)
                ->setSortable(false)
                ->setRequired(true),  

            DateTimeField::new('lastUpdateDate')->hideOnForm(),
            DateTimeField::new('publicationDate')->hideOnForm()
        ];     
    }

 
    
}
