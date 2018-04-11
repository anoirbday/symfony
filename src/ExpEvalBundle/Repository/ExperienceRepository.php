<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 08/04/2018
 * Time: 10:45
 */

namespace ExpEvalBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ExperienceRepository extends EntityRepository
{


    public function findAllExpOrdDate ()
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery("SELECT e FROM ExpEvalBundle:Experience e order BY e.dateExp DESC");
        return $query->getResult();
    }

    public function findTopEtab ()
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery("SELECT et.nomEtablissement,et.descriptionEtablissement, et.adresseEtablissement, et.telephoneEtablissement,  AVG(ev.note) as moy, COUNT (ex.idExp) as nbexp, et.photoEtablissement FROM BonPlanBundle:Etablissement et, ExpEvalBundle:Evaluation ev, ExpEvalBundle:Experience ex WHERE et.idEtablissement=ex.idEtablissement and ev.idExp=ex.idExp GROUP BY et.idEtablissement ORDER BY moy DESC 
");
        return $query->getResult();
    }


    public function FindByLetters($string)
    {
        $query = $this->getEntityManager()->createQuery("SELECT e FROM ExpEvalBundle:Experience e WHERE e.idEtablissement IN (SELECT et.idEtablissement FROM BonPlanBundle:Etablissement et WHERE et.nomEtablissement LIKE :tit)")
            ->setParameter('tit','%'.$string.'%');
        return $query->getResult();
    }







}