<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Meeting;
use AppBundle\Form\MeetingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homepageAction(){

        $meeting = new Meeting();
        $meeting->setDate(new \DateTime());
        $form = $this->createForm(MeetingType::class, $meeting);

        return $this->render('@App/Home/homepage.html.twig', [
            'form' => $form->createView()
        ]);
    }
}