<?php

namespace EtablissementBundle\Controller;

use BonPlanBundle\Entity\Categorie;
use BonPlanBundle\Entity\Etablissement;
use BonPlanBundle\Entity\User;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use EtablissementBundle\Form\CritereEvaluation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * Etablissement controller.
 *
 * @Route("etablissement")
 */
class EtablissementController extends Controller
{
    /**
     * Lists all etablissement entities.
     *
     * @Route("/", name="etablissement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('BonPlanBundle:Etablissement')->findAll();

        return $this->render('EtablissementBundle:etablissement:ListeDesEtabClients.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }

    public function ListeDesDemandesAction()
    {
        $securityContext = $this->container->get('security.authorization_checker'); //ensmble des info d sess cornt
        $token = $this->get('security.token_storage')->getToken(); // ajouté pour tester le role
        $user = $token->getUser();
        if ($securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            $etablissements = $em->getRepository('BonPlanBundle:Etablissement')->findAll();}

        return $this->render('EtablissementBundle:etablissement:DemandeEtab.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }

    public function MonEtabAction()
    {

        $securityContext = $this->container->get('security.authorization_checker'); //ensmble des info d sess cornt
        $token = $this->get('security.token_storage')->getToken(); // ajouté pour tester le role
        $user = $token->getUser();
        if ($securityContext->isGranted('ROLE_PROPRIETAIRE')) {
            $em = $this->getDoctrine()->getManager();
            $etablissements = $em->getRepository('BonPlanBundle:Etablissement')->findBy(array('id' => $user->getId()));

        }
        return $this->render('EtablissementBundle:etablissement:mesEtabs.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }
    /**
     * Creates a new etablissement entity.
     *
     * @Route("/new", name="etablissement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorie = new Categorie();
        $formCat = $this->createForm('EtablissementBundle\Form\Categorie', $categorie);
        $formCat->handleRequest($request);
        if ($formCat->isSubmitted() && $formCat->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $categorie->setEnabled(0);
            $em->persist($categorie);
            $em->flush();
        }


        $securityContext = $this->container->get('security.authorization_checker'); //ensmble des info d sess cornt
        $token = $this->get('security.token_storage')->getToken(); // ajouté pour tester le role
        $user = $token->getUser();


        $etablissement = new Etablissement();
        $form = $this->createForm('EtablissementBundle\Form\EtablissementType', $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($securityContext->isGranted('ROLE_PROPRIETAIRE')) {

                $file = $etablissement->getPhotoEtablissement();
                $file2 = $etablissement->getPhotoPatente();

                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                $fileName2 = $this->generateUniqueFileName() . '.' . $file2->guessExtension();

                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
                $file2->move(
                    $this->getParameter('brochures_directory'),
                    $fileName2
                );

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents
                $em = $this->getDoctrine()->getManager();
                $etablissement->setPhotoEtablissement($fileName);
                $etablissement->setPhotoPatente($fileName2);
                $etablissement->setId($user);
                $etablissement->setEnabled(0);
                $em->persist($etablissement);
                $em->flush();
                return $this->redirectToRoute('bon_plan_accueilProp');
            }
        }

        return $this->render('EtablissementBundle:etablissement:new.html.twig', array(
            'etablissement' => $etablissement,
            'form' => $form->createView(),
            'formCat' =>$formCat->createView(),


        ));
    }
    public function RedirectionAction(Etablissement $etablissement){
        $em=$this->getDoctrine()->getManager();
        $critereEvaluations = $em->getRepository('BonPlanBundle:CritereEvaluation')->findBy(array('idCategorie' => $etablissement->getIdCategorie()));


        return $this->render('EtablissementBundle:etablissement:AfterAjout.html.twig', array(

        ));
    }
    public function GMAction($type)

    {

        return $this->render('EtablissementBundle:etablissement:GM.html.twig',array('type'=>$type));

    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

//    /**
//     * Finds and displays a etablissement entity.
//     *
//     * @Route("/{idEtablissement}", name="etablissement_show")
//     * @Method("GET")
//     */
//    public function showAction(Etablissement $etablissement)
//    {
//        $deleteForm = $this->createDeleteForm($etablissement);
//
//        return $this->render('EtablissementBundle:etablissement:show.html.twig', array(
//            'etablissement' => $etablissement,
//            'adresse'=>$etablissement->getAdresseEtablissement(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
    /**
     * Finds and displays a etablissement entity.
     *
     * @Route("/{idEtablissement}", name="etablissement_test")
     * @Method("GET")
     */
    public function unEtabClientAction(Etablissement $etablissement)
    {   $em=$this->getDoctrine()->getManager();
        $critereEvaluations = $em->getRepository('BonPlanBundle:CritereEvaluation')->findBy(array('idCategorie' => $etablissement->getIdCategorie()));
        $idetab=$etablissement->getIdEtablissement();
        $evaluations =$em->getRepository("BonPlanBundle:Etablissement")->CalculRating($idetab);

//      foreach ( $critereEvaluations as $cr)
//      {
//          $id =$em->getRepository("BonPlanBundle:Etablissement")->CalculRating($idetab);
//            $z = $id;
//          //$id = $em->getRepository("BonPlanBundle:Evaluation")->findOneBy(array('idCritere' => $criterEval->getIdCritere()));
//          $evaluations = $evaluations + $z;
//      }
        $n = $em->getRepository("BonPlanBundle:Etablissement")->CountNbFavoris($idetab);

  $produits= $em->getRepository('BonPlanBundle:Produit')->findBy(array('idEtablissement' => $idetab));
        return $this->render('EtablissementBundle:etablissement:UnEtabClient.html.twig', array(
            'etablissement' => $etablissement,
            'critereEvaluations' => $critereEvaluations,
            'nb'=>$n,
            'Evaluations' => $evaluations,
            'produits' => $produits,
            'adresse'=>$etablissement->getAdresseEtablissement(),
        ));
    }
    public function EtabAction(Etablissement $etablissement)
    {

        return $this->render('EtablissementBundle:etablissement:MonEtablissement.html.twig', array(
            'etablissement' => $etablissement,
            'adresse'=>$etablissement->getAdresseEtablissement(),
        ));
    }

    public function TraiterDemandeAction()
  {
      $id=$_GET['idEtablissement'];
      $em=$this->getDoctrine()->getManager();
      $etablissement=$em->getRepository("BonPlanBundle:Etablissement")->find($id);
      $securityContext = $this->container->get('security.authorization_checker'); //ensmble des info d sess cornt
      $token = $this->get('security.token_storage')->getToken(); // ajouté pour tester le role
      $user = $token->getUser();
      if ($securityContext->isGranted('ROLE_SUPER_ADMIN')) {
          $deleteForm = $this->createDeleteForm($etablissement);
      }
        return $this->render('EtablissementBundle:etablissement:TraiterDemande.html.twig', array(
            'etablissement' => $etablissement,
            'adresse'=>$etablissement->getAdresseEtablissement(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


//    /**
//     * Displays a form to edit an existing etablissement entity.
//     *
//     * @Route("/{idEtablissement}/edit", name="etablissement_edit")
//     * @Method({"GET", "POST"})
//     */
//    public function editAction(Request $request, Etablissement $etablissement)
//    {
//        $deleteForm = $this->createDeleteForm($etablissement);
//        $editForm = $this->createForm('EtablissementBundle\Form\EtablissementType', $etablissement);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('etablissement_edit', array('idEtablissement' => $etablissement->getIdetablissement()));
//        }
//
//        return $this->render('EtablissementBundle:etablissement:edit.html.twig', array(
//            'etablissement' => $etablissement,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
    /**
     *
     * @Route("/{idEtablissement}/MonEtablissement/edit", name="Monetablissement_edit")
     */
    public function modifierMonEtabAction(Request $request, Etablissement $etablissement)
    {      $securityContext = $this->container->get('security.authorization_checker'); //ensmble des info d sess cornt
        $token = $this->get('security.token_storage')->getToken(); // ajouté pour tester le role
        $user = $token->getUser();

        if ($securityContext->isGranted('ROLE_PROPRIETAIRE')) {

            $deleteForm = $this->createDeleteForm($etablissement);
            $editForm = $this->createForm('EtablissementBundle\Form\EtablissementType', $etablissement);
            $editForm->handleRequest($request);


            if ($editForm->isSubmitted() && $editForm->isValid()) {
                /**
                 * @var UploadedFile $file
                 */
                $file=$etablissement->getPhotoEtablissement();
                echo $file;
                $fileName=md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('brochures_directory'),$fileName
                );
                $etablissement->setPhotoEtablissement($fileName);
                $file2=$etablissement->getPhotoPatente();
                echo $file2;
                $fileName2=md5(uniqid()).'.'.$file2->guessExtension();

                $file2->move(
                    $this->getParameter('brochures_directory'),$fileName2
                );
                $etablissement->setPhotoPatente($fileName2);


                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('bon_plan_etablissement2');
            }
        }
        return $this->render('EtablissementBundle:etablissement:ModifierMonEtab.html.twig', array(
            'etablissement' => $etablissement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function RejeterDemandeAction()
    {    $id=$_GET['idEtablissement'];
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("BonPlanBundle:Etablissement")->find($id);
        $securityContext = $this->container->get('security.authorization_checker'); //ensmble des info d sess cornt
        $token = $this->get('security.token_storage')->getToken(); // ajouté pour tester le role
        $user = $token->getUser();
        if ($securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('bon_plan_etablissement6');
    }
    public function ValiderDemandeAction()
    {
        $id=$_GET['idEtablissement'];
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("BonPlanBundle:Etablissement")->find($id);
        $securityContext = $this->container->get('security.authorization_checker'); //ensmble des info d sess cornt
        $token = $this->get('security.token_storage')->getToken(); // ajouté pour tester le role
        $user = $token->getUser();
        if ($securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            $etablissement->setEnabled(1);
            $em->persist($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('bon_plan_etablissement6');
    }
    /**
     * Deletes a etablissement entity.
     *
     * @Route("/{idEtablissement}", name="etablissement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etablissement $etablissement)
    {
        $form = $this->createDeleteForm($etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('bon_plan_etablissement2');
    }

    /**
     * Creates a form to delete a etablissement entity.
     *
     * @param Etablissement $etablissement The etablissement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etablissement $etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etablissement_delete', array('idEtablissement' => $etablissement->getIdetablissement())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
 public function stockageAction($nomEtablissement){
     $em = $this->getDoctrine()->getManager();
     $etab = $em->getRepository("BonPlanBundle:Etablissement")->FindByLetters($nomEtablissement);
     return $this->render('EtablissementBundle:etablissement:RechercheEtab.html.twig',array(
         "etablissements" => $etab,
     ));
 }
    public function rechercheAjaxAction(Request $request, $nomEtablissement){
        if($request->isXmlHttpRequest()){
        $temp = $this->forward('EtablissementBundle:Etablissement:stockage',array(
            'nomEtablissement' => $nomEtablissement
        ))->getContent();
        return new JsonResponse($temp);
        }
        return new Response('Error!', 400);
    }
    public function statAction(){
        $pieChart1=new PieChart();
        $em = $this->getDoctrine()->getManager();
     //  $classes=$em->getRepository("BonPlanBundle:Etablissement")->CountNbEtabParCategorie();
      $classes1 = $em->getRepository("BonPlanBundle:Categorie")->findBy(array('enabled' =>1));
        $totalCat=0;
        foreach ($classes1 as $classe){

            $totalCat=$totalCat+$classe->getIdCategorie();
        }
        $data1=array();
        $stat=['classe','idCategorie'];
        $nb=0;
        array_push($data1,$stat);
        foreach ($classes1 as $classe){
            $stat=array();
            $classes3=$em->getRepository("BonPlanBundle:Etablissement")->CountNbEtabParCategorie($classe->getIdCategorie());
            array_push($stat,$classe->getNomCategorie(),(($classes3*100)/$totalCat));
            $nb=($classes3*100)/100;
            $stat=[$classe->getNomCategorie(),$nb];
            array_push($data1,$stat);
      }
        $pieChart1->getData()->setArrayToDataTable(
            $data1
        );
        $pieChart1->getOptions()->setTitle('Statistique sur le Nombre des établissements par catégorie');
        $pieChart1->getOptions()->setHeight(500);
        $pieChart1->getOptions()->setWidth(900);
        $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setColor('#990033');
        $pieChart1->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('EtablissementBundle:etablissement:test.html.twig',array(
            'piechart1' => $pieChart1));

    }
    public function deleteMobileAction($id) {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("BonPlanBundle:Etablissement")->find($id);
        $em->remove($etablissement);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($etablissement);
        return new JsonResponse($formatted);
    }
    public function nbEtabMobileAction($id){
        $em = $this->getDoctrine()->getManager();
        $work = $em->getRepository("BonPlanBundle:Etablissement")->CountNbEtabParCategorie($id);
        if($work){
            $zz=new Serializer(array(new ObjectNormalizer()));
            $a=$zz->normalize($work,'json');
            $response=new JsonResponse($a);}
        return $response;
    }
    public function unEtabClientMobileAction(Etablissement $etablissement)
    {   $em=$this->getDoctrine()->getManager();
        $critereEvaluations = $em->getRepository('BonPlanBundle:CritereEvaluation')->findBy(array('idCategorie' => $etablissement->getIdCategorie()));
        $idetab=$etablissement->getIdEtablissement();
        $evaluations =$em->getRepository("BonPlanBundle:Etablissement")->CalculRating($idetab);

//      foreach ( $critereEvaluations as $cr)
//      {
//          $id =$em->getRepository("BonPlanBundle:Etablissement")->CalculRating($idetab);
//            $z = $id;
//          //$id = $em->getRepository("BonPlanBundle:Evaluation")->findOneBy(array('idCritere' => $criterEval->getIdCritere()));
//          $evaluations = $evaluations + $z;
//      }
        $n = $em->getRepository("BonPlanBundle:Etablissement")->CountNbFavoris($idetab);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($critereEvaluations);
        $formatted1=$serializer->normalize($evaluations);
        $formatted2=$serializer->normalize($n);
        //return new JsonResponse($formattedd);
        return new JsonResponse(array($formatted,$formatted1,$formatted2));
    }
    public function ajouterEtabMobileAction(Request $request,$id,$idCat)
    {
        $em = $this->getDoctrine()->getManager();
        $etablissement = new Etablissement();
        $etablissement->setNomEtablissement($request->get('nomEtablissement'));
        $etablissement->setAdresseEtablissement($request->get('adresseEtablissement'));
        $etablissement->setDescriptionEtablissement($request->get('descriptionEtablissement'));
        $etablissement->setCodePostal($request->get('codePostal'));
        $etablissement->setBudget($request->get('budget'));
        $etablissement->setPhotoEtablissement($request->get('photoEtablissement'));
        $etablissement->setPhotoPatente($request->get('photoPatente'));
        $etablissement->setSiteWeb($request->get('siteWeb'));
        $etablissement->setLatitude($request->get('latitude'));
        $etablissement->setLongitude($request->get('longitude'));
        $etablissement->setTelephoneEtablissement($request->get('telephoneEtablissement'));
        $etablissement->setFermeture(new \DateTime($request->get('fermeture')));
        $etablissement->setOuverture(new \DateTime($request->get('ouverture')));
        $user = $em->getRepository('BonPlanBundle:User')->find($id);
        $etablissement->setId($user);
        $categorie=$em->getRepository('BonPlanBundle:Categorie')->find($idCat);
        $etablissement->setIdCategorie($categorie);
        $etablissement->setEnabled(1);
        $em->persist($etablissement);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($etablissement);
        return new JsonResponse($formatted);
    }
    public function UpdateEtabMobileAction(Request $request,$idEtab,$id,$idCat,$adr,$lat,$long,$photopat)
    {
        $em = $this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("BonPlanBundle:Etablissement")->find($idEtab);
        $etablissement->setNomEtablissement($request->get('nomEtablissement'));
        $etablissement->setAdresseEtablissement($adr);
        $etablissement->setDescriptionEtablissement($request->get('descriptionEtablissement'));
        $etablissement->setCodePostal($request->get('codePostal'));
        $etablissement->setBudget($request->get('budget'));
        // $etablissement->setPhotoEtablissement($request->get('photoEtablissement'));
        $etablissement->setPhotoPatente($photopat);
        $etablissement->setSiteWeb($request->get('siteWeb'));
        $etablissement->setLatitude($lat);
        $etablissement->setLongitude($long);
        $etablissement->setTelephoneEtablissement($request->get('telephoneEtablissement'));
        $etablissement->setFermeture(new \DateTime($request->get('fermeture')));
        $etablissement->setOuverture(new \DateTime($request->get('ouverture')));
        $user = $em->getRepository('BonPlanBundle:User')->find($id);
        $etablissement->setId($user);
        $categorie=$em->getRepository('BonPlanBundle:Categorie')->find($idCat);
        $etablissement->setIdCategorie($categorie);
        $etablissement->setEnabled(1);
        $em->persist($etablissement);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($etablissement);
        return new JsonResponse($formatted);
    }
    public function MonEtabsMobileAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $etablissements = $em->getRepository('BonPlanBundle:Etablissement')->findBy(array('id' =>$id ));
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($etablissements);
        return new JsonResponse($formatted);

    }
    public function RechercheEtabParNomMobileAction($nom)
    {

        $em = $this->getDoctrine()->getManager();
        $etablissements = $em->getRepository('BonPlanBundle:Etablissement')->findBy(array('nomEtablissement' =>$nom ));
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($etablissements);
        return new JsonResponse($formatted);

    }
    public function ListeDesEtabClientMobileAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etablissements = $em->getRepository('BonPlanBundle:Etablissement')->findAll();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($etablissements);
        return new JsonResponse($formatted);

    }




}
