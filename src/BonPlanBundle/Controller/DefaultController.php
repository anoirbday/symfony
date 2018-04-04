<?php

namespace BonPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BonPlanBundle:Default:index.html.twig');
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
    public function accueilPropAction()
    {
        return $this->render('BonPlanBundle:Default:accueilProp.html.twig');
    }
    public function accueilAdminAction()
    {
        return $this->render('BonPlanBundle:Default:backadmin.html.twig');
    }
    public function accueilClientAction()
    {$em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("BonPlanBundle:Publicite")->findPhoto();
        return $this->render('BonPlanBundle:Default:accueilClient.html.twig',array("Publicites" => $Publicite));
    }
    public function profileAction()
    {
        return $this->render('BonPlanBundle:Default:profil.html.twig');
    }
    public function EvenementAdminAction()
    {
        return $this->render('BonPlanBundle:Default:evenementAdmin.html.twig');
    }
    public function publiciteAction()
    {
        return $this->render('PubliciteBundle:Default:publicite.html.twig');
    }
}
