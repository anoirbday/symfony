<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 06/04/2018
 * Time: 20:14
 */

namespace ExpEvalBundle\Form;


use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('idExp',TextType::class,['label'=> 'Exp'])
            ->add('idCritere',TextType::class,['label'=> 'Crit'])
            ->add('note',RatingType::class,['label'=> 'Note'])
            ->add('Ajouter',SubmitType::class,
                array('label'=>'Evaluer','attr' =>array('class'=>'button button-border button-border-thin button-amber')));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evaluationbundle_evaluation';
    }





}