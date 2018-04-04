<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 24/03/2018
 * Time: 18:35
 */

namespace BonPlanBundle\Controller;

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
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use BonPlanBundle\Repository\EvenementRepository;
use Symfony\Component\Security\Core;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
class EmailsController  extends Controller
{
    public function indexAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('abonnement evenement')
            ->setFrom('mohamedamine.limem@esprit.tn')
            ->setTo('ousshr@gmail.com')
            ->setBody(
                "bienvenu a notre evenement"
            )
        ;
        $this->get('mailer')->send($message);

        return $this->render('BonPlanBundle:Default:mail.html.twig');
    }
}