<?php

namespace ExpEvalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ExpEvalBundle:Default:index.html.twig');
    }

    public function topEtabAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etabs = $em->getRepository('BonPlanBundle:Etablissement')->findTopEtab();

        return $this->render('@ExpEvalBundle/Resources/views/default/topEtab.html.twig', array(
            'etabs' => $etabs,

        ));
    }


}
