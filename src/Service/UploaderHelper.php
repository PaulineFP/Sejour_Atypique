<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class UploaderHelper
{
    const HEBERGEMENT_IMAGE = 'images/hebergements';

    public function uploadHebergementImage(UploadedFile $uploadedFile){
        $destination = $this->uploadsPath.'/'.self::HEBERGEMENT_IMAGE;
    }

    public function getPublicPath(string $path): string {
        return 'upload/'.$path;
    }
}
?>