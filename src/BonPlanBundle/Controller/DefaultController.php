<?php

namespace BonPlanBundle\Controller;

use BonPlanBundle\Entity\Commentraire;
use BonPlanBundle\Entity\Favoris;
use BonPlanBundle\Entity\Reservation;
use BonPlanBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
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
    public function register1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setNom($request->get('nom'));
        $user->setUsername($request->get('username'));
        $user->setPrenom($request->get('prenom'));
        $user->setEmail($request->get('email'));
        $hash = password_hash($request->get('password'), PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $user->setPhotoUser($request->get('photoUser'));
        $role=$request->get('role');

        if ($role=="client"){$user->addRole("ROLE_CLIENT");}
        else if ($role=="proprietaire"){
            $user->addRole("ROLE_PROPRIETAIRE");}




        $em->persist($user);
        $em->flush();
        $encoders = array( new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) { return $object->getId(); });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($user, 'json');
        $json=json_decode($jsonContent);



        return new JsonResponse($json);
    }
    public function allAction(){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('BonPlanBundle:Favoris')
            ->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function byidAction($id){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('BonPlanBundle:Favoris')
            ->findequi($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request){


        $em= $this->getDoctrine()->getManager();
        $favoris = new Favoris();

        $user=$em->getRepository('BonPlanBundle:User')->find($request->get('id'));
        $plan=$em->getRepository('BonPlanBundle:Etablissement')->find($request->get('idEtablissement'));


        $signal = $em->getRepository('BonPlanBundle:Favoris')->findBy(array('id' =>$user,'idEtablissement' =>$plan));

        var_dump($signal);
        if($signal==null ){

            $favoris->setIdEtablissement($plan);
            $favoris->setId($user);

            $em->persist($favoris);
            $em->flush();
            $serializer = new Serializer([ new ObjectNormalizer()]);
            $formatted = $serializer-> normalize($favoris);

        }

        else if($signal!=null){

            $favoris=$em->getRepository('BonPlanBundle:Favoris')->findOneBy(array('id' =>$user,'idEtablissement' =>$plan));

            $em->remove($favoris);
            $em->flush();
        }
        return new JsonResponse($formatted);


    }

    public function deleteAction(Favoris $favoris){
        $em=$this->getDoctrine()->getManager();
        //   $commentaire=$em->getRepository(Article::class)->find($id);

        $em->remove($favoris);
        $em->flush();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($favoris);
        return new JsonResponse($formatted);
    }

    public function all2Action(){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('BonPlanBundle:Commentraire')
            ->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function byid2Action($idExp){
        $tasks= $this->getDoctrine()->getManager();
        //$com=$tasks->getRepository('BonPlanBundle:Experience')->find($request->get('idExp'));
        $comm=$tasks->getRepository('BonPlanBundle:Commentraire')->findBy(array('idExp'=>$idExp)
        );
        // var_dump($comm);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($comm);
        return new JsonResponse($formatted);
    }

    public function new2Action(Request $request){
        $em= $this->getDoctrine()->getManager();
        $task= new Commentraire();
        $task->setCommentaire($request->get('commentaire'));
        $user=$em->getRepository('BonPlanBundle:User')->find($request->get('id'));
        $comm=$em->getRepository('BonPlanBundle:Experience')->find($request->get('idExp'));
        $task->setIdUcomm($user);
        //$task->setIdUcomm($request->get('idUcomm'));
        $task->setIdExp($comm);

        $em->persist($task);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($task);
        return new JsonResponse($formatted);
    }

    public function modifAction(Request $request, Commentraire $task){
        $em= $this->getDoctrine()->getManager();
        $task->setCommentaire($request->get('commentaire'));
        $user=$em->getRepository('BonPlanBundle:User')->find($request->get('iducomm'));
        $comm=$em->getRepository('BonPlanBundle:Experience')->find($request->get('idExp'));
        $task->setIdUcomm($user);
        //$task->setIdUcomm($request->get('idUcomm'));
        $task->setIdExp($comm);

        $em->persist($task);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($task);
        return new JsonResponse($formatted);
    }

    public function delete2Action(Commentraire $commentraire){
        $em=$this->getDoctrine()->getManager();
        //   $commentaire=$em->getRepository(Article::class)->find($id);

        $em->remove($commentraire);
        $em->flush();

        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($commentraire);
        return new JsonResponse($formatted);
    }

    public function byidEtabAction($id){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('BonPlanBundle:Etablissement')
            ->find($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function byidcommentaireAction($id){
        $tasks= $this->getDoctrine()->getManager()
            ->getRepository('BonPlanBundle:Commentraire')
            ->findequi($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

}
