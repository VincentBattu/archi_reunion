<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class MeetingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("date", DateType::class, [
            'label' => 'Date',
            'widget' => 'single_text'
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Ajouter une réunion',
            'attr' => ['class' => 'btn btn-primary']
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_meeting';
    }
}