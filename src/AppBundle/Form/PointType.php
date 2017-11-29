<?php

namespace AppBundle\Form;

use AppBundle\Entity\Point;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'label'    => false,
            'required' => true
        ])
            ->add('report', TextareaType::class, [
                'label'    => false,
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Point::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_point';
    }
}