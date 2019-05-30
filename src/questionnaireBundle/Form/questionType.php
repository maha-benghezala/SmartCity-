<?php

namespace questionnaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class questionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('titre',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('description',TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('valider',SubmitType::class,array('attr' => array('class' => 'form-control btn btn-primary')))
        ->add('choix1',TextType::class, array('required'=>false,'attr' => array('class' => 'form-control')))
        ->add('choix2',TextType::class, array('required'=>false,'attr' => array('class' => 'form-control','style'=>'display : none')))
        ->add('choix3',TextType::class, array('required'=>false,'attr' => array('class' => 'form-control','style'=>'display : none')))
        ->add('choix4',TextType::class, array('required'=>false,'attr' => array('class' => 'form-control','style'=>'display : none')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'questionnaireBundle\Entity\question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'questionnairebundle_question';
    }


}
