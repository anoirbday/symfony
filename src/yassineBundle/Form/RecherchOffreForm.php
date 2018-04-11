<?php
/**
 * Created by PhpStorm.
 * User: Yassine
 * Date: 09/04/2018
 * Time: 09:26
 */
namespace yassineBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecherchOffreForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('titre_offre')
            ->add('Valider',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver); // TODO: Change the autogenerated stub
    }

    public function getName(){
        return 'yassine_bundle_recherche_offre_form';
    }
}

