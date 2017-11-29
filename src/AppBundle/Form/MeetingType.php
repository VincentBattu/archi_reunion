<?php

namespace AppBundle\Form;


use AppBundle\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('points', CollectionType::class, [
            'label'              => false,
            'entry_type'         => PointType::class,
            'entry_options'      => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'by_reference'       => false
        ])
            ->setMethod('POST')
            ->setAction($options['url']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
            'url'        => '',
            'allow_extra_fields' => true
        ]);
    }
}