<?php

namespace BonPlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use BonPlanBundle\Entity\FosUser;
use Symfony\Component\Validator\Constraints\DateTime;

class FosUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $roles = array(
            'Client'         => 'ROLE_CLIENT',
            'Proprietaire'          => 'ROLE_PROPRIETAIRE',

        );
        $builder->add('nom',TextType::class, array('required'=>true,'attr'   =>  array(
            'class'   => 'form-control')))
                ->add('prenom',TextType::class, array('required'=>true,'attr'   =>  array(
                    'class'   => 'form-control')))
            ->add('dateDeNaissance',DateType::class, array('required'=>false,'attr'   =>  array(
                'class'   => 'form-control')))
            ->add('region',TextType::class, array('required'=>true,'attr'   =>  array(
        'class'   => 'form-control')))
            ->add('ville',TextType::class, array('required'=>true,'attr'   =>  array(
        'class'   => 'form-control')))
            ->add('telephone',NumberType::class, array('required'=>true,'attr'   =>  array(
                'class'   => 'form-control')))
            ->add('genre', ChoiceType::class, array('attr'   =>  array(
                'class'   => 'form-control'),
                'choices'   => array('Femme'=>'Femme','Homme'=>'Homme'),
                'required'  => true,
                ))
            ->add('dateInscription',DateType::class, array('required'=>true,'attr'   =>  array(
                'class'   => 'form-control')))
            ->add('roles', ChoiceType::class, array(
                'choices'   => $roles,
                'required'  => true,
                'multiple' => true,
                'expanded'=>true
            ))
        ;


    }




    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getNom()
    {
        return $this->getBlockPrefix();
    }
    public function getPrenom()
    {
        return $this->getBlockPrefix();
    }  public function getDateDeNaissance()
{
    return $this->getBlockPrefix();
}
    public function getRegion()
    {
        return $this->getBlockPrefix();
    }  public function getVille()
{
    return $this->getBlockPrefix();
}  public function getPhotoUser()
{
    return $this->getBlockPrefix();
}  public function getTelephone()
{
    return $this->getBlockPrefix();
}  public function getGenre()
{
    return $this->getBlockPrefix();
}  public function getDateInscription()
{
    return $this->getBlockPrefix();
}
}