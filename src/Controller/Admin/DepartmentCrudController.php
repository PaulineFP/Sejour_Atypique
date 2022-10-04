<?php

namespace App\Controller\Admin;


use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DepartmentCrudController extends AbstractCrudController
{
    public const DEPARTEMENT_BASE_PATH = 'upload\images\hebergements';
    public const DEPARTEMENT_UPLOAD_DIR ='public/upload\images\hebergements';

    public static function getEntityFqcn(): string
    {
        return Department::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name' , 'Département'),
            // BooleanField::new('active', 'Active'),

            ImageField::new('img', 'Image de du département')
                ->setBasePath(self::DEPARTEMENT_BASE_PATH)
                ->setUploadDir(self::DEPARTEMENT_UPLOAD_DIR)
               

                ->setSortable(false)
                ->setRequired(false),  
        ];     
    }

}
