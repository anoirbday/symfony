<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 19/03/2018
 * Time: 14:54
 */

namespace BonPlanBundle\Form;
use BonPlanBundle\Entity\Evenement;
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

class evenementForm extends AbstractType
{public function buildForm(FormBuilderInterface $builder, array $options)
{

    $builder
        ->add('nomEvenement')
        ->add('dateEvenement',DateType::class)
        ->add('descriptionEvenement')
        ->add('photoEvenement', FileType::class, array('data_class' => null,'label'=>false ))

        ->add('save', SubmitType::class)
        ->getForm();


}
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Evenement::class,
        ));
    }
    public function getName(){
        return'bonplan_bundle_evenement_form';

    }


}