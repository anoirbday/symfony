<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 03/05/2018
 * Time: 18:21
 */

namespace ExpEvalBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EvaluationRepository extends EntityRepository
{
    public function findEvalByIdExp ($idExp)
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery
        ("select eval from ExpEvalBundle:Evaluation eval JOIN eval.idExp ex WHERE ex.idExp like :tit")
            ->setParameter('tit','%'.$idExp.'%');
        return $query->getResult();
    }

}