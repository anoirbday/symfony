<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 19/03/2018
 * Time: 10:54
 */

namespace BonPlanBundle\Controller;
use BonPlanBundle\BonPlanBundle;
use BonPlanBundle\Entity\Etablissement;
use BonPlanBundle\Entity\Evenement;
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
use Skies\QRcodeBundle\Generator\Generator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use BonPlanBundle\Repository\EvenementRepository;
use Symfony\Component\Security\Core;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlay\Marker;
use BonPlanBundle\Entity\Interesser;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Hackzilla\BarcodeBundle\Utility\Barcode;


class EvenementController extends Controller
{

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest())
        {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $evenements=$em->getRepository('BonPlanBundle:Evenement')
                ->findSerieDQL($request->get('nomEvenement'));
            $data=$serializer->normalize($evenements);
            return new JsonResponse($data);
        }
        $Evenements = $em->getRepository("BonPlanBundle:Evenement")->findprop($this->getUser());

        return $this->render('BonPlanBundle:Default:blog.html.twig', array("Evenements" => $Evenements));

    }
    public function listclientAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Evenements = $em->getRepository("BonPlanBundle:Evenement")->findAll();
        $em1 = $this->getDoctrine()->getManager();
        $interessers= $em1->getRepository("BonPlanBundle:Interesser")->findAll();
        return $this->render('BonPlanBundle:Default:EvenementClient.html.twig', array("Evenements" => $Evenements, "Interessers"=>$interessers));

    }
    public function listadminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Evenements = $em->getRepository("BonPlanBundle:Evenement")->findAll();
        $evenement = new Evenement();
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(rechercheEvenementForm::class,$evenement);
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest())
        {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $evenements=$em->getRepository('BonPlanBundle:Evenement')->findSerieDQL($request->get('nomEvenement'));
            $data=$serializer->normalize($evenements);
            return new JsonResponse($data);
        }
        return $this->render('default/EvenAdmin.html.twig', array("Evenements" => $Evenements,'form'=>$form->createView()));

    }

    public function ajoutAction(Request $request)
    {$session = new Session();

        $Evenement = new Evenement();


        $form = $this->createFormBuilder($Evenement)
            ->add('nomEvenement',null,array("attr"=>array('class'=>'form-control')))
            ->add('dateEvenement', DateType::class)
            ->add('descriptionEvenement',TextareaType::class,array('attr'=>array('cols'=>'30','rows'=>'5')))


            ->add('idEtablissement',EntityType::class,array(

                'class'=>'BonPlanBundle:Etablissement',

                'query_builder' =>function (EtablissementRepository $t)
                {  $user = $this->container->get('security.token_storage')->getToken()->getUser();


                    return $t->createQueryBuilder('u')
                ->select('et')
                    ->from('BonPlanBundle:Etablissement','et',null)
                        ->where('et.id = :nom')
                        ->setParameter('nom', $user->getId() );
                },
                'choice_label'=>'nomEtablissement',
                'multiple'=>false,
            ))
                ->add('photoEvenement', FileType::class, array( 'required' => false,'label'=>false))
            ->add('ajouter', SubmitType::class ,array(
                'attr' => array(
                    'id' => 'khra'
                )
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Evenement);
            $em->flush();


        }

        return $this->render('BonPlanBundle:Default:ajouter.html.twig',array('form' => $form->createView()));
    }

    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $em->remove($Evenement);
        $em->flush();
        return $this->redirectToRoute('bon_plan_blog');
    }
public function blog2Action ($id,Request $request){
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
    $map->setMapOption('zoom', 8);
    $marker = new Marker(
        new Coordinate($Evenement->getIdEtablissement()->getLatitude(), $Evenement->getIdEtablissement()->getLongitude()),
        Animation::BOUNCE,
        new Icon(),
        new Symbol(SymbolPath::CIRCLE),
        new MarkerShape(MarkerShapeType::RECTANGLE, [1.1, 2.1, 1.4]),
        ['clickable' => false]
    );
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

        $s="interesser vous!!";
    }




    else if ($Ev != null ){

        $s="vous ete deja interesser";
    }

    return $this->render('BonPlanBundle:Default:Evenementprop2.html.twig', array("Evenement" => $Evenement,"Evenements"=>$Evenements,'map'=>$map,"Listinteresser"=>$listinteresser,"show"=>$show,"x"=>$x,'form'=>$form->createView()));




}




public function UpdateAction(Request $request,$id)
    { $Evenement = new Evenement();
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $form = $this->createForm(evenementForm::class, $Evenement);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Evenement);
            $em->flush();

        }
        return $this->render('BonPlanBundle:Default:update.html.twig', array('form' => $form->createView(),'Evenement'=>$Evenement));

    }

    public function returnPDFResponseFromHTML($html){
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Our Code World');
        $pdf->SetTitle(('Our Code World Title'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->AddPage();

        $filename = 'ourcodeworld_pdf_demo';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

    public function indexAction($id){
        // You can send the html as you want


        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BonPlanBundle:Evenement")->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $options = array(
            'code'   => 'string to encode',
            'type'   => 'qrcode',
            'format' => 'html',
        );

        $generator = new Generator();
        $barcode = $generator->generate($options);


        $html= $this->renderView("@BonPlan/Default/PDF.html.twig",array("Evenement"=>$Evenement,"user"=>$user,"barcode"=>$barcode));
        $this->returnPDFResponseFromHTML($html);



    }


    public function stockageAction($nomEvenement){
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository("BonPlanBundle:Evenement")->FindByLetters($nomEvenement);
        return $this->render('BonPlanBundle:Default:recherche.html.twig',array(
            "Evenements" => $events,
        ));
    }
    public function rechercheAjaxAction(Request $request, $nomEvenement){
        if($request->isXmlHttpRequest()){
            $temp = $this->forward('BonPlanBundle:Evenement:stockage',array(
                'nomEvenement' => $nomEvenement
            ))->getContent();
            return new JsonResponse($temp);
        }
        return new Response('Error!', 400);
    }
    public function accAction()
    {$tasks = $this->getDoctrine()->getManager()
        ->getRepository('BonPlanBundle:Evenement')
        ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function GetEtabAction(){
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository("BonPlanBundle:Etablissement")->findAll();
        $normalizer = new ObjectNormalizer();
        $encoder = new JsonResponse();
        $normalizer->setCircularReferenceHandler(function ($object){
            return $object->getId();
        });
        $serializer = new Serializer(array($normalizer, $encoder));
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }



}