<?php
/**
 * Created by PhpStorm.
 * User: Maha
 * Date: 04/06/2018
 * Time: 16:23
 */

namespace questionnaireBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class solutionType extends AbstractType {
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,array('attr' => array('class' => 'form-control')))
            ->add('description',TextareaType::class,array('attr' => array('class' => 'form-control')))
            ->add('image', FileType::class, array('required'=>false,'attr' => array('class' => 'form-control'),'data_class' => null))
            ->add('rapport', FileType::class, array('required'=>false,'attr' => array('class' => 'form-control'),'data_class' => null))
            ->add('dateFin',DateType::class,array('widget' => "single_text",'attr' => array('class' => 'form-control')))
            ->add('Valider', SubmitType::class, array('attr' => array('class' => 'form-control btn btn-primary')));

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'questionnaireBundle\Entity\Suggestion'
        ));
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getBlockPrefix()
    {
        return 'questionnairebundle_suggestion';
    }


}