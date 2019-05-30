<?php

namespace questionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class actualiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,array( 'attr' => array('class' => 'form-control')))
            ->add('theme',ChoiceType::class,array( 'attr' => array('class' => 'form-control'),
                'choices' => array(
                    'A la une' => 'A la une',
                    'Quoi de neuf' => 'Quoi de neuf',
                    'Service' => 'Service',
                    'Evenement'=>'Evenement',
                    )))
            ->add('description',TextareaType::class,array( 'attr' => array('class' => 'form-control')))
            ->add('Valider', SubmitType::class, array('attr' => array('class' => 'form-control btn btn-primary')));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'questionnaireBundle\Entity\actualite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'questionnairebundle_actualite';
    }


}
