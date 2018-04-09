<?php

namespace EtablissementBundle\Controller;

use BonPlanBundle\Entity\Categorie;
use BonPlanBundle\Entity\CritereEvaluation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Critereevaluation controller.
 *
 * @Route("critereevaluation")
 */
class CritereEvaluationController extends Controller
{
    /**
     * Lists all critereEvaluation entities.
     *
     * @Route("/", name="critereevaluation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $critereEvaluations = $em->getRepository('BonPlanBundle:CritereEvaluation')->findAll();
        return $this->render('EtablissementBundle:critereevaluation:index.html.twig', array(
            'critereEvaluations' => $critereEvaluations,
        ));
    }

    /**
     * Creates a new critereEvaluation entity.
     *
     * @Route("/new", name="critereevaluation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $critereEvaluation = new Critereevaluation();
        $form = $this->createForm('EtablissementBundle\Form\CritereEvaluationType', $critereEvaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($critereEvaluation);
            $em->flush();

            return $this->redirectToRoute('critereevaluation_show', array('idCritere' => $critereEvaluation->getIdcritere()));
        }

        return $this->render('EtablissementBundle:critereevaluation:new.html.twig', array(
            'critereEvaluation' => $critereEvaluation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a critereEvaluation entity.
     *
     * @Route("/{idCritere}", name="critereevaluation_show")
     * @Method("GET")
     */
    public function showAction(CritereEvaluation $critereEvaluation)
    {
        $deleteForm = $this->createDeleteForm($critereEvaluation);

        return $this->render('EtablissementBundle:critereevaluation:show.html.twig', array(
            'critereEvaluation' => $critereEvaluation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing critereEvaluation entity.
     *
     * @Route("/{idCritere}/edit", name="critereevaluation_edit")
     * @Method({"GET", "POST"})
     */
    public function editCategCritAction(Request $request, CritereEvaluation $critereEvaluation)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BonPlanBundle:Categorie')->findAll();
        $critereEvaluations = $em->getRepository('BonPlanBundle:CritereEvaluation')->findAll();
        $editForm2 = $this->createForm('EtablissementBundle\Form\CritereEvaluation', $critereEvaluation);
        $editForm2->handleRequest($request);
        if ( $editForm2->isSubmitted() && $editForm2->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('critereevaluation_edit', array('idCritere' => $critereEvaluation->getIdcritere()));

        }
        return $this->render('EtablissementBundle:categorie:modifierCategorieCritere.html.twig', array(
            'critereEvaluation' => $critereEvaluation,
            'categories' => $categories,
            'critereEvaluations' => $critereEvaluations,
            'form' => $editForm2->createView(),

        ));
    }
    /**
     * Deletes a critereEvaluation entity.
     *
     * @Route("/{idCritere}", name="critereevaluation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CritereEvaluation $critereEvaluation)
    {
        $form = $this->createDeleteForm($critereEvaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($critereEvaluation);
            $em->flush();
        }

        return $this->redirectToRoute('critereevaluation_index');
    }

    /**
     * Creates a form to delete a critereEvaluation entity.
     *
     * @param CritereEvaluation $critereEvaluation The critereEvaluation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CritereEvaluation $critereEvaluation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('critereevaluation_delete', array('idCritere' => $critereEvaluation->getIdcritere())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
