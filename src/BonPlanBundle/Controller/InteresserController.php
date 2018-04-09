<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 28/03/2018
 * Time: 11:43
 */

namespace BonPlanBundle\Controller;

use BonPlanBundle\BonPlanBundle;
use BonPlanBundle\Entity\Etablissement;
use BonPlanBundle\Entity\Evenement;
use BonPlanBundle\Entity\Interesser;
use BonPlanBundle\Form\evenementForm;
use BonPlanBundle\Form\rechercheEvenementForm;
use BonPlanBundle\Repository\EtablissementRepository;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlay\Marker;
class InteresserController extends Controller
{


        public function DeleteInteresserAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $Evenements = $em->getRepository("BonPlanBundle:Interesser")->findInteresser($user,$Evenement);
        $em->flush();
        return $this->redirectToRoute('List_Client');
    }
public function interesserAction($id,Request $request){

    $em = $this->getDoctrine()->getManager();
    $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
    $listinteresser = $em->getRepository("BonPlanBundle:Interesser")->listinteresser($Evenement);
    $Evenements = $em->getRepository("BonPlanBundle:Evenement")->findAll();
    $etablissement=$em->getRepository("BonPlanBundle:Etablissement")->latitude($id);
    $etablissements=$em->getRepository("BonPlanBundle:Etablissement")->longitude($id);
    $show = $em->getRepository("BonPlanBundle:Evenement")->findeven($Evenement->getIdEtablissement());

    $x=floatval($etablissement);
    $y=floatval($etablissements);
    $map = new Map();
    $map->setVariable('map');
    $map->setHtmlId('map_canvas');
    $map->setAutoZoom(false);
    $map->setCenter(new Coordinate($Evenement->getIdEtablissement()->getLatitude(), $Evenement->getIdEtablissement()->getLongitude()));
    $map->setMapOption('zoom', 2);
    $map->getOverlayManager()->addMarker(new Marker(new Coordinate($Evenement->getIdEtablissement()->getLatitude(), $Evenement->getIdEtablissement()->getLongitude())));
    $map->addLibrary('drawing');
    $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
    $map->setStaticOption('maptype', MapTypeId::ROADMAP);
    $map->setStaticOption('styles', [
        [
            'feature' => 'road.highway', // Optional
            'element' => 'geometry',     // Optional
            'rules'   => [               // Mandatory (at least one rule)
                'color'      => '0xc280e9',
                'visibility' => 'simplified',
            ],
        ],
        [
            'feature' => 'transit.line',
            'rules'   => [
                'visibility' => 'simplified',
                'color'      => '0xbababa',
            ]
        ],
    ]);
    $p = new Evenement();
    $em=$this->getDoctrine()->getManager();
    $x=$em->getRepository('BonPlanBundle:Evenement')->findAll();
    $form=$this->createForm(rechercheEvenementForm::class,$p);
    $form->handleRequest($request);
    if ($request->isXmlHttpRequest())
    {
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $x=$em->getRepository('BonPlanBundle:Evenement')->findSerieDQL($request->get('nomEvenement'));
        $data=$serializer->normalize($x);
        return new JsonResponse($data);
    }
    $user = $this->container->get('security.token_storage')->getToken()->getUser();

    $em = $this->getDoctrine()->getManager();

    $em = $this->getDoctrine()->getManager();

    $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
    $user = $this->container->get('security.token_storage')->getToken()->getUser();

    $Ev = $em->getRepository("BonPlanBundle:Interesser")->isinteresser($user,$Evenement);
    $interesser = new Interesser();

    if ($Ev == null){

       $s="interesser vous!!";
    }




    else if ($Ev != null ){

$s="vous ete deja interesser";
    }

    return $this->render('BonPlanBundle:Default:blog1.html.twig', array("Evenement" => $Evenement,"s"=>$s,"Evenements"=>$Evenements,'map'=>$map,"Listinteresser"=>$listinteresser,"show"=>$show,"x"=>$x,'form'=>$form->createView()));




}
    public function isinteresserAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $Evenements = $em->getRepository("BonPlanBundle:Interesser")->isinteresser($user,$Evenement);

        return $this->redirectToRoute($Evenements);


    }
    public function buttonAction($id){
        $em = $this->getDoctrine()->getManager();

        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $Ev = $em->getRepository("BonPlanBundle:Interesser")->isinteresser($user,$Evenement);
        $interesser = new Interesser();

        if ($Ev == null){

                $es = $this->getDoctrine()->getManager();
                $interesser->setId($user);
                $interesser->setIdEvenement($Evenement);
                $es->persist($interesser);
                $es->flush();
            }




        else if ($Ev != null ){

            $this->DeleteInteresserAction($id);

        }
        return $this->redirectToRoute('List_Client');


}

public function  nbAction($id){

    $em = $this->getDoctrine()->getManager();
    $Evenements = $em->getRepository("BonPlanBundle:Evenement")->find($id);

    $nb = $em->getRepository("BonPlanBundle:Interesser")->getNb($Evenements->getIdEvenement());
return $this->render('BonPlanBundle:Default:EvenementClient.html.twig',array("nb"=>$nb));
        }
}