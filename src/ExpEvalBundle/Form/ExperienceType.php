<?php

namespace ExpEvalBundle\Form;


use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperienceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descriptionExperience', TextareaType::class, array('label' => 'Description', 'attr' => array(
            'class' => 'form-control')))
                ->add('preuve', FileType::class, array('label' => 'Preuve','data_class'=>null, 'attr' => array(
                'class' => 'form-control')))

            ->add('dateExp', DateType::class, array('label' => 'Date', 'attr' => array(
                'class' => 'form-control')))
        ->add ('idEtablissement')
            ->add('noteExp',RatingType::class,['label'=> 'Note'])

            ->add('save',SubmitType::class, array('label' => 'Enregistrer','attr' => array(
                'class' => 'hm_btn'
            )));

    }
        /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ExpEvalBundle\Entity\Experience'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'expevalbundle_experience';
    }



}
