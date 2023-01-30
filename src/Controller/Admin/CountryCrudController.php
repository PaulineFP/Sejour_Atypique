<?php

namespace App\Controller\Admin;


use App\Entity\Countries;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CountryCrudController extends AbstractCrudController
{
    public const COUNTRY_BASE_PATH = 'upload/images/regions';
    public const COUNTRY_UPLOAD_DIR ='public/upload/images/regions';

    public static function getEntityFqcn(): string
    {
        return Countries::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Région'),
            ImageField::new('img', 'image de la région')
            ->setBasePath(self::COUNTRY_BASE_PATH)
            ->setUploadDir(self::COUNTRY_UPLOAD_DIR)

            ->setSortable(false)
            ->setRequired(false), 
        ];
    }


}
