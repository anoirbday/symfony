<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 03/04/2018
 * Time: 20:04
 */
namespace BonPlanBundle\Controller;


use BonPlanBundle\Form\MailType;
use Doctrine\ORM\EntityRepository;
use BonPlanBundle\Entity\Mail;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class MailController extends Controller
{
    public function indexAction(Request $request)
    {    $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $mail = new Mail();
        $form= $this->createForm(MailType::class, $mail);
        $form->handleRequest($request) ;
        if ($form->isValid()) {
            $message = Swift_Message::newInstance()
                ->setSubject('Accuse de réception')
                ->setFrom('espritplus2017@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'BonPlanBundle:Default:email.html.twig',
                        array('nom' => $user->getNom(), 'prenom'=>$user->getPrenom())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('my_app_mail_accuse'));
        }
        return $this->render('BonPlanBundle:Default:mail.html.twig',
            array('form'=>$form->createView()));
    }
    public function successAction(){
        return new Response("email envoyé avec succès, Merci de vérifier votre boite
mail.");
    }
}