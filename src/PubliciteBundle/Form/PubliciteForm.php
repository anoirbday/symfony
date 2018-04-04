<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29/03/2018
 * Time: 13:15
 */

namespace PubliciteBundle\Form;


use BonPlanBundle\Entity\Publicite;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PubliciteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('titre')

            ->add('descriptionPublicite')
            ->add('photoPublicite', FileType::class, array('data_class' => null,'label'=>false ))

            ->add('save', SubmitType::class)
            ->getForm();


    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Publicite::class,
        ));
    }
    public function getName(){
        return'PubliciteBundle_Publicite';

    }


}