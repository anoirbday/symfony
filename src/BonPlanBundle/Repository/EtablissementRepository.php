<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 23/03/2018
 * Time: 16:01
 */

namespace BonPlanBundle\Repository;
use Doctrine\ORM\EntityRepository;

class EtablissementRepository extends EntityRepository
{
    public function findnometab($id)
    {
        $query=$this->getEntityManager()
            ->createQuery("select et from BonPlanBundle:Etablissement et
WHERE  et.id = :'id'")
            ->setParameter('id', $id->getId());
        return $query->getResult();
    }
    public function latitude($id){
        $query=$this->getEntityManager()
            ->createQuery("select et.latitude from BonPlanBundle:Etablissement et, BonPlanBundle:Evenement ev
WHERE ev.idEtablissement = et.idEtablissement AND  ev.idEvenement = :id ")
        ->setParameter('id', $id);
        return $query->getResult();
    }
    public function longitude($id){
        $query=$this->getEntityManager()
            ->createQuery("select et.longitude from BonPlanBundle:Etablissement et, BonPlanBundle:Evenement ev
WHERE ev.idEtablissement = et.idEtablissement AND   ev.idEvenement = :id ")
        ->setParameter('id', $id);
        return $query->getResult();
    }

}