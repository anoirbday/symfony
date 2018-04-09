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

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $etablissements = $em->getRepository('BonPlanBundle:Etablissement')->findAll();

        return $this->render('EtablissementBundle:etablissement:DemandeEtab.html.twig', array(
            'etablissements' => $etablissements,'user'=>$user
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
                return $this->redirectToRoute('bon_plan_etablissement10', array('idEtablissement' => $etablissement->getIdetablissement()));
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


        return $this->render('EtablissementBundle:etablissement:UnEtabClient.html.twig', array(
            'etablissement' => $etablissement,
            'critereEvaluations' => $critereEvaluations,
            'nb'=>$n,
            'Evaluations' => $evaluations,
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
                $etablissement->setPhotoPatente($etablissement->getPhotoPatente());


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
        $pieChart=new PieChart();
        $em = $this->getDoctrine()->getManager();
     //  $classes=$em->getRepository("BonPlanBundle:Etablissement")->CountNbEtabParCategorie();
      $classes = $em->getRepository("BonPlanBundle:Categorie")->findBy(array('enabled' =>1));
        $totalCat=0;
        foreach ($classes as $classe){

            $totalCat=$totalCat+$classe->getIdCategorie();
        }
        $data=array();
        $stat=['classe','idCategorie'];
        $nb=0;
        array_push($data,$stat);
        foreach ($classes as $classe){
            $stat=array();
            $classes2=$em->getRepository("BonPlanBundle:Etablissement")->CountNbEtabParCategorie($classe->getIdCategorie());
            array_push($stat,$classe->getNomCategorie(),(($classes2*100)/$totalCat));
            $nb=($classes2*100)/100;
            $stat=[$classe->getNomCategorie(),$nb];
            array_push($data,$stat);
      }
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->getChartArea()->setHeight(350);
        $pieChart->getOptions()->getChartArea()->setWidth(600);

        return $this->render('EtablissementBundle:etablissement:test.html.twig',array(
            'piechart' => $pieChart));

    }

}
