<?php

namespace PubliciteBundle\Controller;

use BonPlanBundle\Entity\Publicite;

use BonPlanBundle\Repository\EtablissementRepository;


use PubliciteBundle\Form\PubliciteForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PubliciteBundle:Default:index.html.twig');
    }
    public function publiciteAction()
    {
        return $this->render('PubliciteBundle:Default:publicite.html.twig');
    }
    public function ajoutAction(Request $request)
    {

        $Publicite = new Publicite();

        $form = $this->createFormBuilder($Publicite)
            ->add('titre')
            ->add('datedebut', DateType::class)
            ->add('descriptionPublicite')


            ->add('idEtablissement',EntityType::class,array(

                'class'=>'BonPlanBundle:Etablissement',

                'query_builder' =>function (EtablissementRepository $t)
                {  $user = $this->container->get('security.token_storage')->getToken()->getUser();


                    return $t->createQueryBuilder('u')
                        ->select('et')
                        ->from('BonPlanBundle:Etablissement','et',null)
                        ->where('et.id = :nom')
                        ->setParameter('nom',$user->getId()  );
                },
                'choice_label'=>'nomEtablissement',
                'multiple'=>false,
            ))
            ->add('photoPublicite', FileType::class, array( 'required' => false,'label'=>false))
            ->add('ajouter', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Publicite->setEnabled(0);
            $em->persist($Publicite);
            $em->flush();


        }

        return $this->render('@Publicite/Default/ajout.html.twig',array('form' => $form->createView()));
    }
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("BonPlanBundle:Publicite")->findprop($this->getUser());
        return $this->render('PubliciteBundle:Default:publicite.html.twig', array("Publicites" => $Publicite));

    }
   
    /**
     * @Route(
     *     "/checkout",
     *     name="order_checkout",
     *     methods="POST"
     * )
     */
    public function checkoutAction(Request $request)
    {
        \Stripe\Stripe::setApiKey("sk_test_710GBYxzG4bxy6ZYwyaxv9Uj");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 10000, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe"
            ));
            $this->addFlash("success","Bravo ça marche !");
            return $this->redirectToRoute("ajouterpublicite");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Snif ça marche pas :(");
            return $this->redirectToRoute("ajouterpublicite");
            // The card has been declined
        }
    }
    public function deletAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("BonPlanBundle:Publicite")->find($id);
        $em->remove($Publicite);
        $em->flush();
        return $this->redirectToRoute('affiche_publicite');
    }
    public function UpdateAction(Request $request,$id)
    { $Publicite = new Publicite();
        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("BonPlanBundle:Publicite")->find($id);
        $form = $this->createForm(PubliciteForm::class, $Publicite);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Publicite->setEnabled(0);
            $em->persist($Publicite);
            $em->flush();
            return $this->redirectToRoute('affiche_publicite');

        }
        return $this->render('@Publicite/Default/update.html.twig', array('form' => $form->createView(),'Publicites'=>$Publicite));

    }
    public function validAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("BonPlanBundle:Publicite")->findpub();
        return $this->render('PubliciteBundle:Default:validerPub.html.twig', array("Publicites" => $Publicite));

    }
 public function Update1Action(Request $request,$id)
{ $Publicite = new Publicite();
    $em = $this->getDoctrine()->getManager();
    $Publicite = $em->getRepository("BonPlanBundle:Publicite")->find($id);

        $em = $this->getDoctrine()->getManager();
        $Publicite->setEnabled(1);
        $em->persist($Publicite);
        $em->flush();
        return $this->redirectToRoute('valider_Pub');
}

/*public function facebookAction()
{
    $fb = new Facebook(array(
        'app_id' => {2052658948344519},
	'app_secret' => {"56c993af4e515113fb10481edcf2843e"},
	'default_graph_version' => 'v2.12'
));
$page_id = {805340789502579};

$access_token = {La je ne sais pas comment faire...};
$linkData = array(
    'message' => $titre,
    'link' => $lien
);
try {
    $response = $fb->post($page_id, $linkData, $access_token);
} catch(FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
}*/
public function facebookAction()
    {
        $this->get('app_core.facebook')->poster("Mon premier post depuis Symfony sur cette page");

        return new Response("Post Envoyé");
    }
    public function list1Action(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM BonPlanBundle:Publicite a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('PubliciteBundle:Default:list1.html.twig', array(

            'pagination' => $pagination));
    }






}
