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
use BonPlanBundle\Entity\User;
use BonPlanBundle\Form\evenementForm;
use BonPlanBundle\Form\rechercheEvenementForm;
use BonPlanBundle\Repository\EtablissementRepository;
use Doctrine\ORM\Query\Expr\Select;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
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
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    public function ListinteresserJsonAction($id)
    {$tasks = $this->getDoctrine()->getManager()
        ->getRepository("BonPlanBundle:Interesser")->listinteresser($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function isAboAction(Request $request){
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('idUser'));
        $str1 = $request->get('idEvent');
        $event = $this->getDoctrine()->getRepository(Evenement::class)->find($str1);

        $abonnement = $this->getDoctrine()->getRepository(Interesser::class)->findAll();
        foreach ($abonnement as $abo) {
            $a = ($abo->getId() == $user) && ($abo->getIdEvenement() == $event);
            if ($a) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize(array("statu"=>$a));
                return new JsonResponse($formatted);
            }
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize(array("statu"=>$a));
        return new JsonResponse($formatted);
    }

    public function desaboAction(Request $request)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('idUser'));
        $str1 = $request->get('idEvent');
        $event = $this->getDoctrine()->getRepository(Evenement::class)->find($str1);

        $abonnement = $this->getDoctrine()->getRepository(Interesser::class)
            ->findOneBy(array("id"=>$user,"idEvenement"=>$event));
        if($abonnement != null){
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonnement);
            $em->flush();
            return new JsonResponse(array("statu"=>"ok"));
        }
        return new JsonResponse(array("statu"=>"Notok"));
    }



    public function addAboAction(Request $request){
        $str = $request->get('idEvent');
        $abon = new Interesser();
        $user1 = $this->getDoctrine()->getRepository(Evenement::class)->find($str);
        $abon->setIdEvenement($user1);
        $str1=$request->get('idUser');
        $user2 = $this->getDoctrine()->getRepository(User::class)->find($str1);
        $abon->setId($user2);
        $em = $this->getDoctrine()->getManager();
        $em->persist($abon);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($abon);
        return new JsonResponse($formatted);
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
    $marker = new Marker(
        new Coordinate($Evenement->getIdEtablissement()->getLatitude(), $Evenement->getIdEtablissement()->getLongitude()),
        Animation::BOUNCE,
        new Icon(),
        new Symbol(SymbolPath::CIRCLE),
        new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
        ['clickable' => false]
    );

    $map->setMapOption('zoom', 8);
    $map->getOverlayManager()->addMarker($marker);
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
        $test = true;
       $s="interesser vous!!";
    }




    else if ($Ev != null ){
    $test = false;
$s="vous ete deja interesser";
    }

    return $this->render('BonPlanBundle:Default:blog1.html.twig', array("Evenement" => $Evenement,"s"=>$s,"Evenements"=>$Evenements,'map'=>$map,"tests"=>$test,"Listinteresser"=>$listinteresser,"show"=>$show,"x"=>$x,'form'=>$form->createView()));




}
    public function isinteresserAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $Evenements = $em->getRepository("BonPlanBundle:Interesser")->isinteresser($user,$Evenement);

        return $this->redirectToRoute($Evenements);


    }
    public function isinteresserjSONAction($id,$user){

        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository("BonPlanBundle:User")->find($user);
        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $Evenements = $em->getRepository("BonPlanBundle:Interesser")->isinteresser($user,$Evenement);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Evenements);
        return new JsonResponse($formatted);


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