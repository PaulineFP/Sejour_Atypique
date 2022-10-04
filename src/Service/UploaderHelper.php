<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Asset\Context\RequestStackContext;

class UploaderHelper
{
    private $uploadsPath;
    
    const HEBERGEMENT_IMAGE = 'images/hebergements';
    const DEPARTEMENT_IMAGE = 'images/departements';

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

    public function getPublicPath(string $path): string {
        // return 'upload/'.$path;
        // nécessaire si vous déployez sous un sous-répertoire
        return $this->requestStackContext
            ->getBasePath().'/upload/'.$path;
    } 
   
}
?>