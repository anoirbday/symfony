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

    public function findPaysQB(){

        $query=$this->createQueryBuilder('p');
        $query->where("s.nomProduit=:nomProduits")
            ->setParameter('nomProduits','Produit 1');
        return $query->getQuery()->getResult();

    }

    public function findPaysDQL(){

        $query=$this->getEntityManager()
            ->createQuery("
            select p from yassineBundle:Produit p WHERE p.nom_produit='Allemagne'
            ");

        return $query->getResult();

    }

}