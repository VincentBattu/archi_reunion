<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Meeting;
use AppBundle\Form\MeetingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeetingController extends Controller
{
    public function addMeetingAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            echo "pas ajax";
        }

        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

        }

    }
}