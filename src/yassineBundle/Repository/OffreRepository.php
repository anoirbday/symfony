<?php
/**
 * Created by PhpStorm.
 * User: Yassine
 * Date: 05/05/2018
 * Time: 13:52
 */

namespace yassineBundle\Repository;


use Doctrine\ORM\EntityRepository;

class OffreRepository extends EntityRepository
{


    public function findoffprops($nom)
    {
        $query = $this->getEntityManager()
            ->createQuery("select off from BonPlanBundle:Offre off, BonPlanBundle:Etablissement et
WHERE off.idEtablissement = et.idEtablissement AND et.id = :nom")
            ->setParameter('nom', $nom);
        return $query->getResult();

    }
        public function findidoffetabs($etab)
    {
        $query=$this->getEntityManager()
            ->createQuery("select off from BonPlanBundle:Offre off, BonPlanBundle:Etablissement et
WHERE off.idEtablissement = $etab");
        return $query->getResult();
    }





}