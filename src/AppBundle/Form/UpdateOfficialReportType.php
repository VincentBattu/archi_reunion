<?php

namespace AppBundle\Form;

use AppBundle\Entity\Point;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateOfficialReportType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('officialReport', TextareaType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->setMethod('POST')
        ->setAction($options['action']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Point::class,
            'action' => ''
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_update_official_report';
    }
}