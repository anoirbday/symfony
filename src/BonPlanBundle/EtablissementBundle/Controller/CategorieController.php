<?php

namespace EtablissementBundle\Controller;

use BonPlanBundle\Entity\Categorie;
use BonPlanBundle\Entity\CritereEvaluation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categorie controller.
 *
 * @Route("categorie")
 */
class CategorieController extends Controller
{
    /**
     * Lists all categorie entities.
     *
     * @Route("/", name="categorie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BonPlanBundle:Categorie')->findAll();
        return $this->render('EtablissementBundle:categorie:index.html.twig', array(
            'categories' => $categories,
        ));

    }


    /**
     * Lists all categorie entities.
     *
     * @Route("/", name="categorie_index")
     * @Method("GET")
     */
    public function listeDesCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BonPlanBundle:Categorie')->findAll();
        $critereEvaluations = $em->getRepository('BonPlanBundle:CritereEvaluation')->findAll();
        return $this->render('EtablissementBundle:categorie:listeDesCategories.html.twig', array(
            'categories' => $categories,
            'critereEvaluations' => $critereEvaluations,
        ));

    }
    /**
     * Creates a new categorie entity.
     *
     * @Route("/new", name="categorie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorie = new Categorie();
        $critereEvaluation1 = new Critereevaluation();
        $critereEvaluation2 = new Critereevaluation();
        $critereEvaluation3 = new Critereevaluation();
        $critereEvaluation4 = new Critereevaluation();
        $critereEvaluation5 = new Critereevaluation();

        if($request->isMethod('POST')){

            $categorie->setNomCategorie($request->get('nomcategorie'));
            $categorie->setEnabled(1);

            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $critereEvaluation1->setNomCritereEvaluation($request->get('crit1'));
            $critereEvaluation1->setIdCategorie($categorie);
            $critereEvaluation2->setNomCritereEvaluation($request->get('crit2'));
            $critereEvaluation2->setIdCategorie($categorie);
            $critereEvaluation3->setNomCritereEvaluation($request->get('crit3'));
            $critereEvaluation3->setIdCategorie($categorie);
            $critereEvaluation4->setNomCritereEvaluation($request->get('crit4'));
            $critereEvaluation4->setIdCategorie($categorie);
            $critereEvaluation5->setNomCritereEvaluation($request->get('crit5'));
            $critereEvaluation5->setIdCategorie($categorie);

            $em->persist($critereEvaluation1);
            $em->persist($critereEvaluation2);
            $em->persist($critereEvaluation3);
            $em->persist($critereEvaluation4);
            $em->persist($critereEvaluation5);
            $em->flush();
            return $this->redirectToRoute('bon_plan_categorie4', array('idCategorie' => $categorie->getIdcategorie(),'idCritere' => $critereEvaluation1->getIdcritere()));

        }

        return $this->render('EtablissementBundle:categorie:edit.html.twig', array(



        ));
    }





    /**
     * Finds and displays a categorie entity.
     *
     * @Route("/{idCategorie}", name="categorie_show")
     * @Method("GET")
     */
    public function showAction(Categorie $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);

        return $this->render('EtablissementBundle:categorie:index.html.twig', array(
            'categorie' => $categorie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorie entity.
     *
     * @Route("/{idCategorie}/edit", name="categorie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categorie $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);
        $editForm = $this->createForm('EtablissementBundle\Form\Categorie', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $em = $this->getDoctrine()->getManager();
            $categorie->setEnabled(1);
            $em->persist($categorie);
            $em->flush();

            $critereEvaluation1 = new Critereevaluation();
            $critereEvaluation2 = new Critereevaluation();
            $critereEvaluation3 = new Critereevaluation();
            $critereEvaluation4 = new Critereevaluation();
            $critereEvaluation5 = new Critereevaluation();

            if ($request->isMethod('POST')) {


                $critereEvaluation1->setNomCritereEvaluation($request->get('crit1'));
                $critereEvaluation1->setIdCategorie($categorie);
                $critereEvaluation2->setNomCritereEvaluation($request->get('crit2'));
                $critereEvaluation2->setIdCategorie($categorie);
                $critereEvaluation3->setNomCritereEvaluation($request->get('crit3'));
                $critereEvaluation3->setIdCategorie($categorie);
                $critereEvaluation4->setNomCritereEvaluation($request->get('crit4'));
                $critereEvaluation4->setIdCategorie($categorie);
                $critereEvaluation5->setNomCritereEvaluation($request->get('crit5'));
                $critereEvaluation5->setIdCategorie($categorie);

                $em->persist($critereEvaluation1);
                $em->persist($critereEvaluation2);
                $em->persist($critereEvaluation3);
                $em->persist($critereEvaluation4);
                $em->persist($critereEvaluation5);
                $em->flush();
                return $this->redirectToRoute('bon_plan_categorie4', array('idCategorie' => $categorie->getIdcategorie(), 'idCritere' => $critereEvaluation1->getIdcritere()));

                // return $this->redirectToRoute('bon_plan_categorie8', array('idCategorie' => $categorie->getIdcategorie()));
            }
        }
        return $this->render('EtablissementBundle:categorie:edit.html.twig', array(
            'categorie' => $categorie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
//    public function editAction(Request $request, Categorie $categorie)
//    {
//        $deleteForm = $this->createDeleteForm($categorie);
//        $editForm = $this->createForm('EtablissementBundle\Form\CategorieType', $categorie);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('categorie_edit', array('idCategorie' => $categorie->getIdcategorie()));
//        }
//
//        return $this->render('EtablissementBundle:categorie:edit.html.twig', array(
//            'categorie' => $categorie,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
    public function DeleteCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository("BonPlanBundle:Categorie")->find($id);
        $em->remove($categorie);
        $em->flush();


        return $this->redirectToRoute('bon_plan_categorie4');
    }
    public function DeleteCategorieCritereAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository("BonPlanBundle:Categorie")->find($id);
        $em->remove($categorie);
        $em->flush();


        return $this->redirectToRoute('bon_plan_categorie4');
    }
    /**
     * Deletes a categorie entity.
     *
     * @Route("/{idCategorie}", name="categorie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Categorie $categorie)
    {

        $form = $this->createDeleteForm($categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();

        }
        return $this->redirectToRoute('bon_plan_categorie4');


    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Categorie $categorie The categorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categorie $categorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorie_delete', array('idCategorie' => $categorie->getIdcategorie())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
