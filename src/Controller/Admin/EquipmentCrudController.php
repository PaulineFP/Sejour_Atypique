<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EquipmentCrudController extends AbstractCrudController
{
    public const EQUIPEMENT_BASE_PATH = 'upload/images/hebergements';
    public const EQUIPEMENT_UPLOAD_DIR = 'public/upload/images/hebergements';

    public static function getEntityFqcn(): string
    {
        return Equipment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name' , 'Equipement'),
            ImageField::new('image', 'Image de l\'équipement')
                ->setBasePath(self::EQUIPEMENT_BASE_PATH)
                ->setUploadDir(self::EQUIPEMENT_UPLOAD_DIR)

                ->setSortable(false)
                ->setRequired(false),  
        ];
    }

}
