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
    public function findetab($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select ev from  BonPlanBundle:Etablissement ev
WHERE  ev.id = :nom")
            ->setParameter('nom', $nom);
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
    public function FindByLetters($string)
    {
        $query = $this->getEntityManager()->createQuery("SELECT e FROM BonPlanBundle:Etablissement e WHERE e.nomEtablissement like :tit")
            ->setParameter('tit','%'.$string.'%');
        return $query->getResult();
    }
    public function CountNbFavoris($id)
    {
        $query = $this->getEntityManager()->createQuery("select count (f.idFavoris) as nb from BonPlanBundle:Favoris f  WHERE  f.idEtablissement=:n  ")
            ->setParameter('n',$id);
        return $query->getSingleScalarResult();
    }
    public function CalculRating($id)
    {
        $query = $this->getEntityManager()->createQuery("select AVG(ev.note) from BonPlanBundle:Evaluation ev, BonPlanBundle:Etablissement et, BonPlanBundle:Experience ex, BonPlanBundle:CritereEvaluation cv where et.idEtablissement = ex.idEtablissement and ev.idExp=ex.idExp and cv.idCritere=ev.idCritere and et.idEtablissement=:n GROUP BY ev.idCritere  ")
            ->setParameter('n',$id);
        return $query->getResult();
    }
    public function CountNbEtabParCategorie($id)
    {
        $query = $this->getEntityManager()->createQuery("select count (e.idEtablissement) as nb from BonPlanBundle:Etablissement e WHERE e.enabled=1 AND e.idCategorie=:n  ")
            ->setParameter('n',$id);
        return $query->getSingleScalarResult();;
    }
    public function findTopEtab ()
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery("SELECT et.idEtablissement, et.nomEtablissement,et.descriptionEtablissement, et.adresseEtablissement, et.telephoneEtablissement,  AVG(ex.noteExp) as moy, COUNT (ex.idExp) as nbexp, et.photoEtablissement FROM BonPlanBundle:Etablissement et, ExpEvalBundle:Experience ex WHERE et.idEtablissement=ex.idEtablissement GROUP BY et.idEtablissement ORDER BY moy DESC 
");

        return $query->getResult();
    }

    public function findEtabByCat ($nomCat)
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery
        ("select etab from BonPlanBundle:Etablissement etab, BonPlanBundle:Categorie cat WHERE etab.idCategorie=cat.idCategorie and cat.nomCategorie LIKE :tit")
            ->setParameter('tit','%'.$nomCat.'%');
        return $query->getResult();
    }

    public function findEtabByNom ($nomEtab)
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery
        ("select etab from BonPlanBundle:Etablissement etab WHERE etab.nomEtablissement LIKE :tit")
            ->setParameter('tit','%'.$nomEtab.'%');
        return $query->getResult();
    }


}