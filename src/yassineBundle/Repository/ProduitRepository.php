<?php
/**
 * Created by PhpStorm.
 * User: Yassine
 * Date: 12/03/2018
 * Time: 10:27
 */

namespace yassineBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProduitRepository extends EntityRepository
{

    public function findprodprops($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select pr from BonPlanBundle:Produit pr, BonPlanBundle:Etablissement et
WHERE pr.idEtablissement = et.idEtablissement AND et.id = :nom")
            ->setParameter('nom', $nom);
        return $query->getResult();
    }

    public function findidetabs($etab)
    {
        $query=$this->getEntityManager()
            ->createQuery("select pr from BonPlanBundle:Produit pr, BonPlanBundle:Etablissement et
WHERE pr.idEtablissement = $etab");
        return $query->getResult();
    }

}