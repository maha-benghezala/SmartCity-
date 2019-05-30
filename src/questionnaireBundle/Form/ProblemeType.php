<?php

namespace questionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProblemeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('description',TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('image', FileType::class, array('required'=>false,'attr' => array('class' => 'form-control file'),'data_class' => null))
            ->add('video', FileType::class, array('required'=>false,'attr' => array('class' => 'form-control file'),'data_class' => null))
            ->add('Latitude',TextType::class, array('attr' => array('class' => 'form-control'),'required'=>false))
            ->add('Longitude',TextType::class, array('attr' => array('class' => 'form-control'),'required'=>false))
            ->add('Valider', SubmitType::class, array('attr' => array('class' => 'form-control btn btn-primary')));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'questionnaireBundle\Entity\Probleme'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'questionnairebundle_probleme';
    }


}
