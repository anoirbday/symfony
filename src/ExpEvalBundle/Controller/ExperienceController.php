<?php

namespace ExpEvalBundle\Controller;


use ExpEvalBundle\Entity\Experience;
use ExpEvalBundle\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Experience controller.
 *
 * @Route("experience")
 */
class ExperienceController extends Controller
{
    /**
     * Lists all experience entities.
     *
     * @Route("/", name="experience_index")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $experiences = $em->getRepository('ExpEvalBundle:Experience')->findAllExpOrdDate();
        /**
         * @var $paginator\knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $experiences,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );


        return $this->render('@ExpEvalBundle/Resources/views/default/accueilProp.html.twig', array(
            'experiences'=>$result
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $experiences = $em->getRepository('ExpEvalBundle:Experience')->findAllExpOrdDate();
        /**
         * @var $paginator\knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $experiences,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );
        return $this->render('@ExpEvalBundle/Resources/views/default/filAdmin.html.twig', array(
            'experiences'=>$result
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filClientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $experiences = $em->getRepository('ExpEvalBundle:Experience')->findAllExpOrdDate();
//      $dql='SELECT exp FROM ExpEvalBundle:Experience exp';
//      $query=$em -> createQuery ($dql);

        /**
         * @var $paginator\knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $result=$paginator->paginate(
            $experiences,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );
        return $this->render('ExpEvalBundle:Default:filClient.html.twig', array(
            'experiences' =>$result

        ));
    }





    /**
     * Creates a new experience entity.
     * @Route("/new", name="experience_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $experience = new Experience();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $experience->setId($user);

        $form = $this->createForm('ExpEvalBundle\Form\ExperienceType', $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $img
             */
            $img=$experience->getPreuve();
            $nomimg=md5(uniqid()).'.'.$img->guessExtension();
            $img->move(
                $this->getParameter('brochures_directory'),$nomimg
            );

            $experience->setEnabled(0);
            $experience->setPreuve($nomimg);

            $em = $this->getDoctrine()->getManager();
            $em->persist($experience);
            $em->flush();
//            $iduser=$experience->getIdEtablissement()->getId();
//            $idcategorie=$experience->getIdEtablissement()->getIdCategorie()->getIdCategorie();
//            echo $idcategorie;
//            $idCrit = $em->getRepository('BonPlanBundle:CritereEvaluation')->findAll();
//
//            $manager = $this->get('mgilet.notification');
//            $notif = $manager->createNotification('Hello world !');
//            $notif->setMessage('This a notification.');
//            $notif->setLink('http://symfony.com/');
//            // or the one-line method :
//            // $manager->createNotification('Notification subject','Some random text','http://google.fr');
//
//            // you can add a notification to a list of entities
//            // the third parameter ``$flush`` allows you to directly flush the entities
//            $manager->addNotification(array($iduser), $notif, true);

            return $this->redirectToRoute('bon_plan_filClient', array('idExp' => $experience->getIdexp()));
        }

        return $this->render('@ExpEvalBundle/Resources/views/default/ajoutExpClient.html.twig', array(
            'experience' => $experience,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a experience entity.
     *
     * @Route("/{idExp}", name="experience_show")
     * @Method("GET")
     */
    public function showAction(Experience $experience)
    {
        $deleteForm = $this->createDeleteForm($experience);

        return $this->render('@ExpEvalBundle/Resources/views/default/affichExp.html.twig', array(
            'experience' => $experience,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function showPropAction(Experience $experience)
    {
        $deleteForm = $this->createDeleteForm($experience);

        return $this->render('@ExpEvalBundle/Resources/views/default/affichExpProp.html.twig', array(
            'experience' => $experience,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function affichExpAdminAction(Experience $experience)
    {
        $deleteForm = $this->createDeleteForm($experience);

        return $this->render('@ExpEvalBundle/Resources/views/default/affichExpAdmin.html.twig', array(
            'experience' => $experience,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing experience entity.
     *
     * @Route("/{idExp}/edit", name="experience_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Experience $experience)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $deleteForm = $this->createDeleteForm($experience);
            $editForm = $this->createForm('ExpEvalBundle\Form\ExperienceType', $experience);
            $editForm->handleRequest($request);



            if ($editForm->isSubmitted() && $editForm->isValid()) {
                /**
                 * @var UploadedFile $file
                 */
                $file=$experience->getPreuve();
                $fileName= md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('brochures_directory'),$fileName
                );
                $experience->setPreuve($fileName);


                $em=$this->getDoctrine()->getManager();
                $em->persist($experience);
                $em->flush();
                return $this->redirectToRoute('bon_plan_filClient', array('idExp' => $experience->getIdexp()));
            }

            return $this->render('@ExpEvalBundle/Resources/views/default/modifExpClient.html.twig', array(
                'experience' => $experience,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'user'=>$user
            ));
        }


    public function modifExpAdminAction(Request $request, Experience $experience)
    {
        $deleteForm = $this->createDeleteForm($experience);
        $editForm = $this->createForm('ExpEvalBundle\Form\ExperienceType', $experience);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$experience->getPreuve();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),$fileName
            );
            $experience->setPreuve($fileName);


            $em=$this->getDoctrine()->getManager();
            $em->persist($experience);
            $em->flush();

        return $this->redirectToRoute('bon_plan_filAdmin', array('idExp' => $experience->getIdexp()));
        }

        return $this->render('@ExpEvalBundle/Resources/views/default/modifExpAdmin.html.twig', array(
            'experience' => $experience,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a experience entity.
     *
     * @Route("/{idExp}", name="experience_delete")
     * @Method("DELETE")
     */
    public function deleteExpAdminAction(Request $request, Experience $experience)
    {
        $form = $this->createDeleteForm($experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($experience);
            $em->flush();
        }


    }

    /**
     * Deletes a experience entity.
     *
     * @Route("/{idExp}", name="experience_delete")
     * @Method("DELETE")
     */
    public function deleteExpClientAction(Request $request, Experience $experience)
    {
        $form = $this->createDeleteForm($experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($experience);
            $em->flush();
        }

        return $this->redirectToRoute('bon_plan_filClient');
    }

    /**
     * Creates a form to delete a experience entity.
     *
     * @param Experience $experience The experience entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Experience $experience)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('experience_delete', array('idExp' => $experience->getIdexp())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }



    public function stockageAction($nomEtablissement){
        $em = $this->getDoctrine()->getManager();
        $exps = $em->getRepository("ExpEvalBundle:Experience")->FindByLetters($nomEtablissement);

        return $this->render('@ExpEval/Default/rechercheExp.html.twig',array(
            "experiences" => $exps,
        ));
    }


    public function rechercheAjaxAction(Request $request, $nomEtablissement){
        if($request->isXmlHttpRequest()){
            $temp = $this->forward('ExpEvalBundle:Experience:stockage',array(
                'nomEtablissement' => $nomEtablissement
            ))->getContent();
            return new JsonResponse($temp);
        }
        return new Response('Error!', 400);
    }
    public function allAction ()
    {
        $experiences = $this->getDoctrine()->getManager()->getRepository("ExpEvalBundle:Experience")->findAllExpOrdDate();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($experiences);
        return new JsonResponse($formatted);
    }

    public function AffichExpAction($id)
    {
        $experiences = $this->getDoctrine()->getManager()->getRepository("ExpEvalBundle:Experience")->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($experiences);
        return new JsonResponse($formatted);
    }

    public function AjoutExpAction(Request $request, $idU, $idE)
    {

        $em= $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getManager()->getRepository("BonPlanBundle:User")->find($idU);
        $etab = $this->getDoctrine()->getManager()->getRepository("BonPlanBundle:Etablissement")->find($idE);


        $experience = new Experience();
        $experience->setPreuve($request->get('preuve'));
        $experience->setEnabled(0);
        $experience->setDateExp(new \DateTime($request->get('dateExp')));
        $experience->setDescriptionExperience($request->get('descriptionExperience'));
        $experience->setNoteExp($request->get('noteExp'));
        $experience->setIdEtablissement($etab);
        $experience->setId($user);
        $em->persist($experience);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($experience);
        return new JsonResponse($formatted);

    }

    public function ModifExpAction(Request $request,$idExp)
    {
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository("ExpEvalBundle:Experience")->find($idExp);
        $experience->setDescriptionExperience($request->get('descriptionExperience'));
        $experience->setPreuve($request->get('preuve'));
        $em->persist($experience);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($experience);
        return new JsonResponse($formatted);

    }

    public function ModifNoteExpAction(Request $request,$idExp)
    {
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository("ExpEvalBundle:Experience")->find($idExp);
        $experience->setNoteExp($request->get('noteExp'));
        $em->persist($experience);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($experience);
        return new JsonResponse($formatted);

    }


    public function MoyExpAction($id)
    {
        $experiences = $this->getDoctrine()->getManager()->getRepository("ExpEvalBundle:Experience")->moyExp($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($experiences);
        return new JsonResponse($formatted);
    }

    public function upimgAction(){
        return new JsonResponse(uniqid().".jpg");
    }

    public function SuppExpAction($idExp)
    {
        $em = $this->getDoctrine()->getManager();

        $evals = $em->getRepository("ExpEvalBundle:Evaluation")->findBy(array('idExp' => $idExp));
        if ($evals) {
            foreach ($evals as $c) {
                $em->remove($c);
                $em->flush();
            }
        }

        $experience = $em->getRepository("ExpEvalBundle:Experience")->find($idExp);
        $em->remove($experience);
        $em->flush();
        return new JsonResponse("Experience supprimée");
    }

}
