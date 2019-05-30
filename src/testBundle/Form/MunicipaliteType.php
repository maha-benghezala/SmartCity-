<?php
/**
 * Created by PhpStorm.
 * User: Jasser
 * Date: 20/04/2018
 * Time: 20:46
 */

namespace testBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MunicipaliteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('telephone',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('email', EmailType::class, array('attr' => array('class' => 'form-control')))
            ->add('username',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Mot de passe', 'attr' => array('class' => 'form-control')),
                'second_options' => array('label' => 'Répéter Mot de passe', 'attr' => array('class' => 'form-control')),
            ))
            ->add('adresse',TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('description',TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('latitude',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('longitude',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('president',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('image', FileType::class, array('required'=>false,'attr' => array('class' => 'form-control file'),'data_class' => null))
            ->add('Enregistrer', SubmitType::class, array('attr' => array('class' => 'form-control')))
        ;
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'testBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'testBundle_user';
    }
}