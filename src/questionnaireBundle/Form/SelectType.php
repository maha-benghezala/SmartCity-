<?php
/**
 * Created by PhpStorm.
 * User: Jasser
 * Date: 11/06/2018
 * Time: 17:33
 */

namespace questionnaireBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Desc',RadioType::class,array('required'=>false,'attr' =>array('class' => 'form-control')))
            ->add('ASC',RadioType::class,array('required'=>false,'attr' =>array('class' => 'form-control')))
        ->add('Municipalite', EntityType::class, array(
        'class' => 'testBundle\Entity\User',
        'query_builder' => function(EntityRepository $er) {
            $role = "ROLE_MUNICIPALITE";
            return $er->createQueryBuilder('u')
                ->where('u.enabled = true ')
                ->andWhere('u.roles LIKE :role')
                ->setParameter('role', '%' . $role . '%')
                ;
        },'attr' =>array('class' => 'form-control')))
            ->add('Chercher',SubmitType::class,array('attr' =>array('class' => 'form-control btn btn-primary')));
    }
}