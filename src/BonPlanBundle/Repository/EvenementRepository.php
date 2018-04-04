<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 23/03/2018
 * Time: 11:39
 */

namespace BonPlanBundle\Repository;
use Doctrine\ORM\EntityRepository;
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

class EvenementRepository extends EntityRepository
{
    public function findSerieDQL($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from BonPlanBundle:Evenement v
WHERE v.nomEvenement LIKE :nom
ORDER BY v.nomEvenement ASC")
            ->setParameter('nom','%'.$nom.'%');
        return $query->getResult();
    }
    public function findprop($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select ev from BonPlanBundle:Evenement ev, BonPlanBundle:Etablissement et
WHERE ev.idEtablissement = et.idEtablissement AND et.id = :nom")
            ->setParameter('nom', $nom->getId());
        return $query->getResult();
    }



}
