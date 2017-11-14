<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MeetingType extends AbstractType
{


    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {

        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->urlGenerator->generate('add_meeting'))
            ->add("date", DateType::class, [
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