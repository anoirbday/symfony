<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 19/03/2018
 * Time: 15:39
 */

namespace BonPlanBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use BonPlanBundle\Entity\Evenement;
use BonPlanBundle\ImageUpload;
class ImageUploadListener
{
    private $uploader;

    public function __construct(ImageUpload $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Evenement)
 {
            return;
        }

        $file = $entity->getPhotoEvenement();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setPhotoEvenement($fileName);
    }

}