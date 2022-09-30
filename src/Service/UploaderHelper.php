<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Asset\Context\RequestStackContext;

class UploaderHelper
{
    private $uploadsPath;
    
    const HEBERGEMENT_IMAGE = 'images/hebergements';

    public function __construct(string $uploadsPath, RequestStackContext $requestStackContext)
    {
        $this->uploadsPath = $uploadsPath;
        $this->requestStackContext = $requestStackContext;
    }

    public function uploadHebergementImage(UploadedFile $uploadedFile){
        $destination = $this->uploadsPath.'/'.self::HEBERGEMENT_IMAGE;
    }

    public function getPublicPath(string $path): string {
        // return 'upload/'.$path;
        // nécessaire si vous déployez sous un sous-répertoire
        return $this->requestStackContext
            ->getBasePath().'/upload/'.$path;
    } 
   
}
?>