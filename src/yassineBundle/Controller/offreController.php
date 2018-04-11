<?php

namespace yassineBundle\Controller;

use BonPlanBundle\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use BonPlanBundle\Entity\Offreproduit;
use BonPlanBundle\Entity\Produit;
use yassineBundle\Form\RecherchOffreForm;

/**
 * Offre controller.
 *
 * @Route("offre")
 */
class offreController extends Controller
{
    /**
     * Lists all offre entities.
     *
     * @Route("/indexProp", name="offre_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
         $conn = $this->container->get('doctrine')->getEntityManager()->getConnection();




        $offre = new Offre();
        $em = $this->getDoctrine()->getManager();

        $Form = $this->createForm(RecherchOffreForm::class, $offre);

        $Form->handleRequest($request);


        if ($Form->isValid())
        //if ($Form->isSubmitted() && false === $Form->isValid())
        {

            $offre = $em->getRepository("BonPlanBundle:Offre")->findBy(
                array('titreOffre' => $offre->getTitreOffre()));

        } else {
      //      $offre = $em->getRepository("BonPlanBundle:Offre")->findAll();
            $sqlall='SELECT p
                    FROM Offre
                    WHERE p.id_offre=:idetab
                    ';
            $sql = 'SELECT o.titre_offre, o.description_offre, o.date_debut, o.date_fin, o.photo_offre, p.nom_produit
                    FROM Offreproduit op
                    
                    JOIN Offre o
                    ON op.id_offre=o.id_offre
                    
                    JOIN Produit p
                    ON op.id_produit=p.id_produit
                    
                    ';

            $stmt = $conn->prepare($sqlall);
            $stmt->execute(['idetab' => $offre->getId]);


              return $this->render('offre/indexprop.html.twig', array(
                'form2' => $Form->createView(), 'offres' => $stmt->fetchAll(), 'off'=>$offre))  ;

        }
        return $this->render('offre/indexprop.html.twig', array(
            'form2' => $Form->createView(), 'offres' =>$stmt
        ));

    }


    /**
     * Lists all offre entities.
     *
     * @Route("/indexClient", name="offre_index_client")
     * @Method({"GET", "POST"})
     */
    public function indexclientAction(Request $request)
    {
        $conn = $this->container->get('doctrine')->getEntityManager()->getConnection();

        $offre = new Offre();
        $em = $this->getDoctrine()->getManager();

        $Form = $this->createForm(RecherchOffreForm::class, $offre);

        $Form->handleRequest($request);


        if ($Form->isValid())
            //if ($Form->isSubmitted() && false === $Form->isValid())
        {

            $offre = $em->getRepository("BonPlanBundle:Offre")->findBy(
                array('titreOffre' => $offre->getTitreOffre()));

        } else {
           // $offre = $em->getRepository("BonPlanBundle:Offre")->findAll();
            $sqlall='SELECT o
                    FROM BonPlanBundle:Offre o
                    WHERE o.id_offre LIKE :idetab
                    ';

            $stmt = $conn->prepare($sqlall);
            $stmt->execute(['idetab' => $offre->getIdEtablissement()]);


        }

        return $this->render('offre/indexclient.html.twig', array(
            'form2' => $Form->createView(), 'offres' => $stmt
        ));
    }


    /**
     * Creates a new offre entity.
     *
     * @Route("/new", name="offre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("BonPlanBundle:Produit")->findAll();
        $offre = new Offre();
        $offre2 = new Offre();
        $prdt=new Produit();

        $form = $this->createForm('yassineBundle\Form\OffreType', $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            $em2 = $this->getDoctrine()->getManager();
         //  $offre2->setIdOffre(5555);
        //    $prdt->setIdProduit(66666);
         //   $offreprod = new Offreproduit();
         //   $offreprod->setIdOffre(55555);
           // $offreprod->setIdProduit(666666);
          //  $em2->persist($offreprod);
           // $em2->flush();

            $conn = $this->container->get('doctrine')->getEntityManager()->getConnection();

            $cbs=$request->get('cb');

          //  $k=$_GET('cb');
            $n=count($cbs);
            for ($i=0;$i<$n;$i++){

            $sql = 'INSERT INTO offreproduit(id_offre, id_produit) VALUES (:ido,:idp)';
            $stmt = $conn->prepare($sql);
            $stmt->execute(['ido' => $offre->getIdOffre(), 'idp' => $i]);
            }
            return $this->redirectToRoute('offre_show', array('idOffre' => $offre->getIdoffre()));

          //  $prdt->getIdProduit()
        }

        return $this->render('offre/new.html.twig', array(
            'offre' => $offre,
            'form' => $form->createView(),
            'produits'=>$produit,
        ));
    }

    /**
     * Finds and displays a offre entity.
     *
     * @Route("/{idOffre}", name="offre_show")
     * @Method("GET")
     */
    public function showAction(Offre $offre)
    {
        $deleteForm = $this->createDeleteForm($offre);

        return $this->render('offre/show.html.twig', array(
            'offre' => $offre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing offre entity.
     *
     * @Route("/{idOffre}/edit", name="offre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Offre $offre)
    {
        $deleteForm = $this->createDeleteForm($offre);
        $editForm = $this->createForm('yassineBundle\Form\OffreType', $offre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offre_edit', array('idOffre' => $offre->getIdoffre()));
        }

        return $this->render('offre/edit.html.twig', array(
            'offre' => $offre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a offre entity.
     *
     * @Route("/{idOffre}", name="offre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Offre $offre)
    {
        $form = $this->createDeleteForm($offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($offre);
            $em->flush();
        }

        return $this->redirectToRoute('offre_index');
    }

    /**
     * Creates a form to delete a offre entity.
     *
     * @param Offre $offre The offre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Offre $offre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('offre_delete', array('idOffre' => $offre->getIdoffre())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
