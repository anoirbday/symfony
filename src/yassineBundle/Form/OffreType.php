<?php

namespace yassineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class OffreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreOffre')
            ->add('descriptionOffre'
            )->add('dateDebut')
            ->add('dateFin')
            ->add('photoOffre', FileType::class, array('data_class'=>null,'label' => 'Image de votre Offre (JPG)'))
             ->add('idEtablissement');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BonPlanBundle\Entity\Offre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'yassinebundle_offre';
    }


}
