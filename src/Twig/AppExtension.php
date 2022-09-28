<?php

use App\Service\UploaderHelper;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    public function getFunction(): array
    {
        return [
            new TwigFunction('uploaded_asset', [$this, 'getUploadedAssetPath'])
        ];
    }

    public static function getSubscribedServices()
    {
        return [
            UploaderHelper::class,
        ];
    }

    public function getUploadedAssetPath(string $path): string
    {
        return $this->container
            ->get(UploaderHelper::class)
            ->getPublicPath($path);
    }
}
?>