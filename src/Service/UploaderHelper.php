<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Asset\Context\RequestStackContext;

class UploaderHelper
{
    private $uploadsPath;
    
    const HEBERGEMENT_IMAGE = 'images/hebergements';
    const DEPARTEMENT_IMAGE = 'images/hebergements';
    const MEDIA_IMAGE = 'images/hebergements';
    const EQUIPEMENT_IMAGE = "images/hebergements";
    const REGION_IMAGE = "images/regions";

    public function __construct(string $uploadsPath, RequestStackContext $requestStackContext)
    {
        $this->uploadsPath = $uploadsPath;
        $this->requestStackContext = $requestStackContext;
    }

    // Hebergement image path
    public function uploadHebergementImage(UploadedFile $uploadedFile){
        $destination = $this->uploadsPath.'/'.self::HEBERGEMENT_IMAGE;
    }

    //Departement image path
    public function uploadDepartementImage(UploadedFile $uploadedFile){
        $destination = $this->uploadsPath.'/'.self::DEPARTEMENT_IMAGE;
    }

    //Media image path
    public function uploadMediaImage(UploadedFile $uploadedFile){
        $destination = $this->uploadsPath.'/'.self::MEDIA_IMAGE;
    }
    

    //Equipement image path
    public function uploadEquipementImage(UploadedFile $uploadedFile){
        $destination =$this->uploadsPath.'/'.self::EQUIPEMENT_IMAGE;
    }

    //Région image path
    public function uploadCountryImage(UploadedFile $uploadedFile){
        $destination =$this->uploadsPath.'/'.self::REGION_IMAGE;
    }

    public function getPublicPath(string $path): string {
        // return 'upload/'.$path;
        // nécessaire si vous déployez sous un sous-répertoire
        return $this->requestStackContext
            ->getBasePath().'/upload/'.$path;
    } 
   
}
?>