<?php

namespace yassineBundle\Controller;

use Symfony\Component\Form\Form;
use yassineBundle\Form\RecherchProduitForm;
use BonPlanBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produit controller.
 *
 * @Route("produit")
 */
class produitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/indexProp", name="produit_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();

        $Form = $this->createForm(RecherchProduitForm::class, $produit);

        $Form->handleRequest($request);


        //if ($Form->isValid())
        if ($Form->isSubmitted() && false === $Form->isValid())
        {

            $produit = $em->getRepository("BonPlanBundle:Produit")->findBy(
                array('nomProduit' => $produit->getNomProduit()));

        } else {
            $produit = $em->getRepository("BonPlanBundle:Produit")->findAll();

            }

            return $this->render('produit/index.html.twig', array(
                'form1' => $Form->createView(), 'produits' => $produit
            ));
        }

    /**
     * Lists all produit entities.
     *
     * @Route("/indexClient", name="produit_index_client")
     * @Method("GET")
     */
    public function indexclientAction(Request $request)
    {
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();

        $Form = $this->createForm(RecherchProduitForm::class, $produit);

        $Form->handleRequest($request);


        //if ($Form->isValid())
        if ($Form->isSubmitted() && false === $Form->isValid())
        {

            $produit = $em->getRepository("BonPlanBundle:Produit")->findBy(
                array('nomProduit' => $produit->getNomProduit()));

        } else {
            $produit = $em->getRepository("BonPlanBundle:Produit")->findAll();

        }

        return $this->render('produit/indexclient.html.twig', array(
            'form1' => $Form->createView(), 'produits' => $produit
        ));
    }



    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="produit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('yassineBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{idProduit}", name="produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/edit/{idProduit}", name="produit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('yassineBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_edit', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("/{idProduit}", name="produit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('idProduit' => $produit->getIdproduit())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

public function exportAction(){
    $em = $this->getDoctrine()->getManager();
    $produits = $em->getRepository("BonPlanBundle:Produit")->findAll();

    $writer = $this->container->get('egyg33k.csv.writer');
    $csv = $writer::createFromFileObject(new \SplTempFileObject());
    $csv->insertOne(['Nom Produit', 'Prix']);
    foreach ($produits as $produit){
        $csv->insertOne([$produit->getNomProduit(), $produit->getPrixProduit()]);

    }
    $csv->output('ListeProduits.csv');
    exit;
}
}
