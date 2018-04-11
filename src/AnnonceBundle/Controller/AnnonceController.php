<?php

namespace AnnonceBundle\Controller;

use AnnonceBundle\Entity\Annonce;
use AnnonceBundle\Form\RateType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Annonce controller.
 *
 */
class AnnonceController extends Controller
{






    public function indexbackAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('AnnonceBundle:Annonce')->findBy(array('valid' =>0));

        return $this->render('annonce/indexback.html.twig', array(
            'annonces' => $annonces,

        ));


    }
    public function validerAction(Request $request, Annonce $annonce)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce->setValid(1);
        $this->getDoctrine()->getManager()->flush();
        $publicites = $em->getRepository('AnnonceBundle:Annonce')->findBy(array('valid' =>0));


        return $this->redirectToRoute('annonce_indexback', array(
            'annonces' => $annonce,

        ));
    }

    public function refuserAction(Request $request, Annonce $annonce)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce->setValid(null);
        $this->getDoctrine()->getManager()->flush();
        $publicites = $em->getRepository('AnnonceBundle:Annonce')->findBy(array('valid' =>0));


        return $this->redirectToRoute('annonce_indexback', array(
            'annonces' => $annonce,

        ));
    }









    /**
     * Lists all annonce entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('AnnonceBundle:Annonce')->findBy(array('valid' =>1));
        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $annonces,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 1)



        );




        return $this->render('annonce/index.html.twig', array(
            'annonces' => $result,


        ));


    }
    public function chercherAction(Request $request)
    {

        if($request->isXmlHttpRequest() && $request->isMethod('post')){

            $nom =$request->get('nom');
            $em = $this->getDoctrine()->getEntityManager();
            $query =$em->getRepository('AnnonceBundle:Annonce')->createQueryBuilder('u');
            $annonce= $query->where($query->expr()->like('u.nom',':p'))
                ->setParameter('p','%'.$nom.'%')
                ->getQuery()->getResult();

            $response = $this->renderView('annonce/search.html.twig',array('all'=>$annonce));
            return  new JsonResponse($response) ;
        }
        return new JsonResponse(array("status"=>true));




    }
    /**
     * Creates a new annonce entity.
     *
     */
    public function newAction(Request $request)
    {
        $annonce = new Annonce();
        $form = $this->createForm('AnnonceBundle\Form\AnnonceType', $annonce);
        $form->handleRequest($request);
        //$user = $this->getUser();


        if ($form->isSubmitted() && $form->isValid()) {
            $file = $annonce->getPhoto();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
           // $annonce->setUtilisateur($user);

            // Move the file to the directory where brochures are stored
            $path = "C:/wamp64/www/bonplan3/web" ;
            $file->move(
                $path,
                $fileName
            );
            $annonce->setPhoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/new.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a annonce entity.
     *
     */
    public function showAction(Annonce $annonce , Request $request)
    {

        $m = $this->getDoctrine()->getManager();
        $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
        $deleteForm = $this->createDeleteForm($annonce);
        $annonce=$em->getRepository("AnnonceBundle:Annonce")->find($id);









        $mark = $em->getRepository('AnnonceBundle:Annonce')->find($id);
        $rating = $m->getRepository('AnnonceBundle:Rating')->AVGRating();
        $rating=new Rating();


        $form=$this->createFormBuilder($rating)
            ->add('rating', RatingType::class, [
                'label' => 'Rating'
            ])
            ->add('valider',SubmitType::class, array(
                'attr' => array(

                    'class'=>'btn btn-xs btn-primary'
                )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rating->setAnnonce($mark->getId());
            $em->persist($rating);
            $em->flush();
        }




        return $this->render('annonce/show.html.twig', array(
            'annonce' => $annonce,
            'delete_form' => $deleteForm->createView(),
            'mark' => $mark,'form'=> $form->createView(),'rating'=>$rating,


        ));
    }

    /**
     * Displays a form to edit an existing annonce entity.
     *
     */
    public function editAction(Request $request, Annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);
        $editForm = $this->createForm('AnnonceBundle\Form\AnnonceType', $annonce);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $annonce->getPhoto();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $path = "C:/wamp64/www/BonPlan3/web" ;
            $file->move(
                $path,
                $fileName
            );
            $annonce->setPhoto($fileName);


            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('annonce_index');
        }


        return $this->render('annonce/edit.html.twig', array(
            'annonce' => $annonce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonce entity.
     *
     */
    public function deleteAction($id)
    {



        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->find($id);

        $em->remove($annonce);
        $em->flush();

        return $this->redirectToRoute('annonce_index');


    }

    /**
     * Creates a form to delete a annonce entity.
     *
     * @param Annonce $annonce The annonce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Annonce $annonce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonce_delete', array('id' => $annonce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
