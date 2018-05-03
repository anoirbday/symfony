<?php

namespace BonPlanBundle\Controller;

use BonPlanBundle\Entity\Reservation;
use BonPlanBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {$em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("BonPlanBundle:Publicite")->findPhoto();
        return $this->render('BonPlanBundle:Default:index.html.twig',array("Publ" => $Publicite));
    }
    public function aboutAction()
    {
        return $this->render('BonPlanBundle:Default:about.html.twig');
    }
    public function serviceAction()
    {
        return $this->render('BonPlanBundle:Default:service.html.twig');
    }
    public function galleryAction()
    {
        return $this->render('BonPlanBundle:Default:gallery.html.twig');
    }
    public function blogAction()
    {
        return $this->render('BonPlanBundle:Default:blog.html.twig');
    }
    public function blog1Action()
    {
        return $this->render('BonPlanBundle:Default:blog1.html.twig');
    }
    public function shopAction()
    {
        return $this->render('BonPlanBundle:Default:shop.html.twig');
    }
    public function shop1Action()
    {
        return $this->render('BonPlanBundle:Default:shop1.html.twig');
    }
    public function contactAction()
    {
        return $this->render('BonPlanBundle:Default:contact.html.twig');
    }
    public function registerAction()
    {
        return $this->render('BonPlanBundle:Default:register.html.twig');
    }
    public function loginAction()
    {
        return $this->render('BonPlanBundle:Default:login.html.twig');
    }
    public function accueilPropAction(Request $request)
    {   $em = $this->getDoctrine()->getManager();
       $Publicite = $em->getRepository("BonPlanBundle:Publicite")->findPhoto();
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

        return $this->render('BonPlanBundle:Default:accueilProp.html.twig',array("Pub" => $Publicite,'experiences'=>$result));
    }
    public function accueilAdminAction()
    {
        return $this->render('BonPlanBundle:Default:backadmin.html.twig');
    }
    public function accueilClientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()){

            $serializer = new Serializer(array(new ObjectNormalizer()));
            $pub = $em->getRepository('BonPlanBundle:Publicite')->find($request->get('serie'));
            $nbclick = $pub->getNbrClick();
            $pub->setNbrClick($nbclick+1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($pub);
            $em->flush();
            $data = $serializer->normalize($pub);
            return new JsonResponse($data);
        }
        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("BonPlanBundle:Publicite")->finddate();
        return $this->render('BonPlanBundle:Default:accueilClient.html.twig',array("Publicites" => $Publicite));
    }
    public function profileAction(Request $request)
    {


        $em=$this->getDoctrine()->getManager();
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $username = $user->getId();
        }

        if($request->isXmlHttpRequest()){
            if($request->get('btnval')!=null)
            {

                $serializer = new Serializer(array(new ObjectNormalizer()));
                $testprop=$em->getRepository('BonPlanBundle:Reservation')->find($request->get('test'));
                $testprop->setChecked(true);
                $testprop->setValid(true);
                $em->flush();
                $voitures=$em->getRepository(Reservation::class)
                    ->findBy(array('checked'=>false));
                $data = $serializer->normalize($voitures);
                return new JsonResponse($data);
            }

            if($request->get('noval')!=null)
            {
                $serializer = new Serializer(array(new ObjectNormalizer()));
                $testprop=$em->getRepository('BonPlanBundle:Reservation')->find($request->get('test'));
                $testprop->setChecked(true);
                $testprop->setValid(false);
                $em->flush();
                $voitures=$em->getRepository(Reservation::class)
                    ->findBy(array('checked'=>false));
                $data = $serializer->normalize($voitures);
                return new JsonResponse($data);
            }
        }

        $testprop=$em->getRepository('BonPlanBundle:Reservation')->findequi($username);
        return $this->render('BonPlanBundle:Default:profil.html.twig', array(
            'res' => $testprop,

        ));
    }
    public function EvenementAdminAction()
    {
        return $this->render('BonPlanBundle:Default:evenementAdmin.html.twig');
    }
    public function publiciteAction()
    {
        return $this->render('PubliciteBundle:Default:publicite.html.twig');
    }
    public function accEtabAction()
    {
        return $this->render('EtablissementBundle:etablissement:mesEtabs.html.twig');
    }
    public function EventListAction()
    {
        $em=$this->getDoctrine()->getManager();

        $testprop=$em->getRepository('BonPlanBundle:Reservation')->findAll();
        return $this->render('BonPlanBundle:Default:accueilProp.html.twig', array(
            'res' => $testprop,

        ));
    }

    public function loadDataAction()
    {
        $em=$this->getDoctrine()->getManager();
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $username = $user->getId();
        }
        $times=$em->getRepository('BonPlanBundle:Reservation')->cal($username);
        $dd=new Reservation();
        $dd->getDate();

        //$x=array();
        /* $it=new Item();
         $it->setTitle("tt");
         $it->setStart("2018-01-02");*/
        //$x=array("title"=>"haw test","start"=>"2018-01-02");
        // array_push($x, $it);
        $x=array();
        foreach ($times  as $i) {
            $it=new Item();
            $it->setTitle($i->getOccasion());
            $it->setStart($i->getDate()->format('Y-m-d'));
            $it->setTextColor("white");
            if($i->getOccasion()=="Birthday")
            {
                $it->setColor("blue");
            }else{
                $it->setColor("red");
            }


            array_push($x, $it);

        }

        //str_replace(array('[', ']'), '', htmlspecialchars(json_encode($result), ENT_NOQUOTES));
        $response = new JsonResponse($x);
        return $response->setData(($x));
        // return $response;
    }
    public function login1Action (Request $request) {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->findOneBy(['username' =>$request->get('username')]);
        if($user){
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $salt = $user->getSalt();

            if($encoder->isPasswordValid($user->getPassword(),$request->get('password'), $salt)){
                $serializer=new Serializer([new ObjectNormalizer()]);
                $formatted=$serializer->normalize($user);
                return new JsonResponse($formatted);
            }
        }
        return new JsonResponse("Failed");
    }
    public function GetUserbyIdAction(Request $request){
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function allCatAction ()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository("BonPlanBundle:Categorie")->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categories);
        return new JsonResponse($formatted);
    }

    public function allEtabCatAction ($nomCat)
    {
        $etabs = $this->getDoctrine()->getManager()->getRepository("BonPlanBundle:Etablissement")->findEtabByCat($nomCat);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($etabs);
        return new JsonResponse($formatted);
    }

    public function oneEtabNomAction ($nomEtab)
    {
        $etabs = $this->getDoctrine()->getManager()->getRepository("BonPlanBundle:Etablissement")->findEtabByNom($nomEtab);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($etabs);
        return new JsonResponse($formatted);
    }

    public function allCritCatAction ($nomCat)
    {
        $etabs = $this->getDoctrine()->getManager()->getRepository("BonPlanBundle:CritereEvaluation")->findCritByCat($nomCat);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($etabs);
        return new JsonResponse($formatted);
    }

}
