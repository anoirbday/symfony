<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 03/04/2018
 * Time: 19:27
 */

namespace BonPlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MailType extends AbstractType



{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('valider', SubmitType::class)
            ->getForm();
    }
    public function configureOptions(OptionsResolver $resolver)
    {

    }
    public function getName()
    {
        return 'Mail';
    }

}