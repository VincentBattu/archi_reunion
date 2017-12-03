<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Point;
use AppBundle\Form\UpdateOfficialReportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PointController extends Controller
{

    public function updateOfficialReportAction(Request $request, Point $point): Response
    {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UpdateOfficialReportType::class, $point, ['action' => $this->generateUrl('update_official_report', ['id' => $point->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $request->getMethod() === 'POST' && $request->isXmlHttpRequest()) {
            $em->flush();
            return $this->json(['msg' => 'success']);
        }

        return $this->render('@App/Point/update-official-report.html.twig', [
            'form'  => $form->createView(),
            'point' => $point
        ]);
    }

}