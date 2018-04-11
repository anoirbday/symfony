<?php

namespace EtablissementBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\FloatNode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class EtablissementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomEtablissement', TextType::class, array('required'=>true,'attr'   =>  array(
            'class'   => 'form-control','placeholder'=>'Nom de vote établissement' )))->add('idCategorie')->add('adresseEtablissement' ,TextType::class, array('required'=>true,'attr'   =>  array(
        'class'   => 'form-control','placeholder'=>'Veuillez saisir une adresse complète(Avenue,Rue;Ville' )))->add('telephoneEtablissement', NumberType::class, array('required'=>false,'attr'   =>  array(
        'class'   => 'form-control','placeholder'=>'Numéro doit être composé de 8 chiffres' )))->add('ouverture', TimeType::class, array('required'=>true,'attr'   =>  array(
            'class'   => 'form-control' )))->add('fermeture', TimeType::class, array('required'=>true,'attr'   =>  array(
            'class'   => 'form-control' )))->add('descriptionEtablissement',TextareaType::class, array('attr'   =>  array(
            'class'   => 'form-control','placeholder'=>'Veuillez saisir une description détaillée' )))
            ->add('photoEtablissement', FileType::class, array('required'=>true,'label' => 'Photo de votre établissement','data_class'=>null,'attr'   =>  array(
                'class'   => 'form-control')))->add('photoPatente', FileType::class, array('required'=>false,'data_class'=>null,'attr'   =>  array(
                'class'   => 'form-control')))->add('codePostal', NumberType::class, array('required'=>false,'attr'   =>  array(
                'class'   => 'form-control','id' => 'code','placeholder'=>'votre code postal' )))->add('budget', ChoiceType::class, array('choices' => array('Faible' => 'Faible', 'Moyen' => 'Moyen', 'Cher' => 'Cher'),
                'required' => true,
                'multiple' => false,'attr'   =>  array(
                    'class'   => 'form-control','placeholder'=>'Veuillez saisir le budget de vote établissement' )))->add('siteWeb' ,TextType::class, array('required'=>true,'attr'   =>  array(
        'class'   => 'form-control','placeholder'=>'www.exemple.tn' )))->add('longitude',TextType::class, array('required'=>false,'attr'   =>  array(
                'class'   => 'form-control','placeholder'=>'Votre Longitude' )))->add('latitude',TextType::class, array('required'=>false,'attr'   =>  array(
                'class'   => 'form-control','placeholder'=>'Votre Latitude' )));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BonPlanBundle\Entity\Etablissement'

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bonplanbundle_etablissement';
    }


}
