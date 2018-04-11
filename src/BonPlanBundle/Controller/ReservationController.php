<?php

namespace BonPlanBundle\Controller;

use BonPlanBundle\Entity\Etablissement;
use BonPlanBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reservation controller.
 *
 */
class ReservationController extends Controller
{




    public function ajoutAction(Request $request)
    {
        $user = $this->getUser();
        if($request->isXmlHttpRequest() && $request->isMethod('post')) {
            $reservation=new Reservation();


            $occasion=$request->get('occasion');
            $date=$request->get('date');
            $heure=$request->get('heure');
            $nb=$request->get('nb');
            $message=$request->get('message');
            $idEtablissement=$request->get('idE');


            $em=$this->getDoctrine()->getManager();
            $etab=$em->getRepository('BonPlanBundle:Etablissement')->find($idEtablissement);
//        $medicament=$em->getRepository( Medicament::class)->findAll();
            $reservation->setOccasion($occasion);
           // return new Response($date);
           $reservation->setDate((new \DateTime($date)));
           $reservation->setHeure(new \DateTime($heure));
            $reservation->setNbPersonne($nb);
            $reservation->setMessage($message);
           $reservation->setIdEtablissement($etab);

            $reservation->setId($user);
            $em->persist($reservation);
            $em->flush();

            $resaffiche = $em->getRepository('BonPlanBundle\Entity\Reservation')->findAll();
            $response = $this->renderView('reservation/indexres.html.twig',array('reservations'=>$resaffiche));
            return  new JsonResponse($response) ;
        }

        return new JsonResponse(array("status"=>true));

    }





    /**
     * Lists all reservation entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $form = $this->createForm('BonPlanBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);
        $reservations = $em->getRepository('BonPlanBundle:Reservation')->findAll();

        return $this->render('reservation/index.html.twig', array(
            'reservations' => $reservations,
            'form'=>$form->createView()
        ));
    }

    /**
     * Creates a new reservation entity.
     *
     */
    public function newAction(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm('BonPlanBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);
        $user=$this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setId($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush($reservation);

            return $this->redirectToRoute('reservation_show', array('id' => $reservation->getIdReservation()));
        }

        return $this->render('reservation/new.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reservation entity.
     *
     */
    public function showAction(Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);

        return $this->render('reservation/show.html.twig', array(
            'reservation' => $reservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     */
    public function editAction(Request $request, Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('BonPlanBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getIdReservation()));
        }

        return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reservation entity.
     *
     */
    public function deleteAction(Request $request, Reservation $reservation)
    {
        $form = $this->createDeleteForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush($reservation);
        }

        return $this->redirectToRoute('reservation_index');
    }

    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getIdReservation())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
