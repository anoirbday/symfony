<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28/03/2018
 * Time: 00:10
 */

namespace PubliciteBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PubliciteRipository extends EntityRepository
{
    public function findprop($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select pu from BonPlanBundle:Publicite pu, BonPlanBundle:Etablissement et
WHERE pu.idEtablissement = et.idEtablissement AND et.id = :nom AND pu.enabled=1")
            ->setParameter('nom', $nom);
        return $query->getResult();
    }
    public function findprop1($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select pu from BonPlanBundle:Publicite pu, BonPlanBundle:Etablissement et
WHERE pu.idEtablissement = et.idEtablissement AND et.id = :nom AND pu.enabled=1")
            ->setParameter('nom', $nom->getId());
        return $query->getResult();
    }
    public function findpub()
    {
        $query=$this->getEntityManager()
            ->createQuery("select pu from BonPlanBundle:Publicite pu, BonPlanBundle:Etablissement et
WHERE pu.idEtablissement = et.idEtablissement  AND pu.enabled=0");

        return $query->getResult();
    }
    public function findPhoto()
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT a FROM BonPlanBundle:Publicite a where a.enabled=1");

        return $query->getResult();
    }
    public function finddate()
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT a FROM BonPlanBundle:Publicite a where (a.datedebut> CURRENT_DATE()-7)  and a.enabled=1");

        return $query->getResult();
    }
    public function findStat()
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT  SUM(p.nbrClick) from BonPlanBundle:Publicite p  GROUP BY p.idPublicite");
        return $query->getResult();
    }
    public function findCount($id)
    {
        $query=$this->getEntityManager()
            ->createQuery("select p.nbrClick from BonPlanBundle:Publicite p WHERE p.idPublicite=:n  ")
        ->setParameter('n',$id);
        return $query->getSingleScalarResult();
    }


}