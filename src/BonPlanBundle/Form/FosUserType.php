<?php

namespace BonPlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use BonPlanBundle\Entity\FosUser;

class FosUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $roles = array(
            'Client'         => 'ROLE_CLIENT',
            'Proprietaire'          => 'ROLE_PROPRIETAIRE',
            'Admin'        => 'ROLE_ADMIN',
        );
        $builder->add('nom')
                ->add('prenom')
            ->add('dateDeNaissance')
            ->add('region')
            ->add('ville')
            ->add('telephone')
            ->add('genre')
            ->add('photoUser')
            ->add('dateInscription')
            ->add('roles', ChoiceType::class, array(
                'choices'   => $roles,
                'required'  => true,
                'multiple' => true
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