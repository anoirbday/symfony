<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27/03/2018
 * Time: 23:51
 */

namespace PubliciteBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

use PubliciteBundle\ImageUpload ;
use BonPlanBundle\Entity\Publicite;

class ImageUploadListener
{ private $uploader;

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
        if (!$entity instanceof Publicite) {
            return;
        }

        $file = $entity->getPhotoPublicite();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setPhotoPublicite($fileName);
    }

}