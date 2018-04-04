<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 24/03/2018
 * Time: 12:26
 */

namespace BonPlanBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;

class PDFForm extends  AbstractType
{public function buildForm(FormBuilderInterface $builder, array $options)
{

    $builder
        ->add('nomEvenement')
        ->add('dateEvenement',DateType::class)
        ->add('descriptionEvenement')
        ->add('photoEvenement', FileType::class)

        ->add('save', SubmitType::class)
        ->getForm();


}
    public function configureOptions(OptionsResolver $resolver)
    {

    }
    public function getName(){
        return'bonplan_bundle_pdf_form';

    }


}