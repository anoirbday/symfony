<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 03/05/2018
 * Time: 18:13
 */

namespace BonPlanBundle\EtablissementBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CritereEvaluationRepository extends EntityRepository
{
    public function findCritByCat ($nomCat)
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery
        ("select etab from BonPlanBundle:CritereEvaluation etab, BonPlanBundle:Categorie cat WHERE etab.idCategorie=cat.idCategorie and cat.nomCategorie LIKE :tit")
            ->setParameter('tit','%'.$nomCat.'%');
        return $query->getResult();
    }
}