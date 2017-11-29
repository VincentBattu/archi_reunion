<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Meeting;
use AppBundle\Form\AddMeetingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function homepageAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $meeting = new Meeting();
        $meeting->setDate(new \DateTime());
        $form = $this->createForm(AddMeetingType::class, $meeting);

        $query = $em->getRepository('AppBundle:Meeting')
            ->createQueryBuilder('m')
            ->orderBy('m.date', 'DESC')
            ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('@App/Home/homepage.html.twig', [
            'form'       => $form->createView(),
            'pagination' => $pagination
        ]);
    }
}