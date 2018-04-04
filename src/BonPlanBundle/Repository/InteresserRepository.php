<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 28/03/2018
 * Time: 22:05
 */

namespace BonPlanBundle\Repository;
use BonPlanBundle\Entity\Evenement;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Security\Core;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlay\Marker;
use BonPlanBundle\Entity\Interesser;


class InteresserRepository extends EntityRepository
{
    public function findInteresser($nom,$even)
    {

        $query=$this->getEntityManager()
            ->createQuery("delete from BonPlanBundle:Interesser ev 
WHERE ev.idEvenement= :even AND ev.id = :nom ")
        ->setParameter('nom', $nom->getId())
        ->setParameter('even', $even->getIdEvenement());
        return $query->getResult();
    }
    public function isinteresser($nom,$even){

        $query=$this->getEntityManager()
            ->createQuery("select ev from BonPlanBundle:Interesser ev 
WHERE ev.idEvenement= :even AND ev.id = :nom ")
            ->setParameter('nom', $nom->getId())
            ->setParameter('even', $even->getIdEvenement());
        return $query->getResult();

    }
    public function ajouter($nom,$even){

        $query=$this->getEntityManager()
            ->createQueryBuilder("INSERT INTO BonPlanBundle:Interesser ev 
VALUES (:even,:nom) ")
            ->setParameter('nom', $nom->getId())
            ->setParameter('even', $even->getIdEvenement());
            return $query->getDQL();
    }
    public function nbinteresser(){

        $query=$this->getEntityManager()
            ->createQuery("select COUNT from BonPlanBundle:Interesser ev");

        return $query->getResult();

    }
    public function getNb($id) {

        $query=$this->getEntityManager()->createQuery('Select Count (d) as nbr From BonPlanBundle:Interesser d WHERE d.idEvenement=:id ')->setParameter('id',$id);

    }

}