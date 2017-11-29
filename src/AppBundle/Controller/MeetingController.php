<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Meeting;
use AppBundle\Form\AddMeetingType;
use AppBundle\Form\MeetingType;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MeetingController extends Controller
{

    /**
     * Liste les points d'ordre du jour de la réunion.
     * @return Response
     */
    public function managePointsAction(Meeting $meeting): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting, [
            'url' => $this->get('router')->generate('update_point_ajax', ['id' => $meeting->getId()])
        ]);

        return $this->render('@App/Meeting/manage-points.html.twig', [
            'meeting' => $meeting,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * Ajoute une réunion à la base de données.
     * Méthode peut être appelée uniquement en AJAX et en POST (redirection vers la page d'accueil si
     * la requête n'est pas faite à travers un objet XMLHttpRequest en POST)
     *
     * @param Request $request
     * @return Response
     */
    public function addMeetingAction(Request $request): Response
    {
        if (!$request->isXmlHttpRequest() || $request->getMethod() !== 'POST') {
            return $this->redirectToRoute('homepage');
        }

        $meeting = new Meeting();
        $form = $this->createForm(AddMeetingType::class, $meeting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meeting);
            $em->flush();

            $router = $this->get('router');
            $intlDateFormatter = IntlDateFormatter::create('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            return $this->json([
                'success'       => true,
                'errors'        => [],
                'date_formated' => $intlDateFormatter->format($meeting->getDate()),
                'url'           => $router->generate('manage_points', ['id' => $meeting->getId()])
            ]);
        }

        return $this->json([
            'success' => false, 'errors' => $this->getErrorsAsArray($form)]);
    }


    /**
     *
     */
    public function updatePointsAction(Request $request, Meeting $meeting): Response
    {
        if (!$request->isXmlHttpRequest() || $request->getMethod() !== 'POST') {
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MeetingType::class, $meeting);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            $em->flush();
            return $this->json([
                'success' => true,
            ]);
        }
        return $this->json([
            'success' => false
        ]);

    }


    public function listMeetingReportAction(Request $request): Response{
        $em = $this->getDoctrine()->getManager();
        $points = $em->getRepository('AppBundle:Point')->findAll();

        return $this->render('@App/Meeting/list-meeting-reports.html.twig', ['points' => $points]);
    }

    /**
     * Formate les erreurs d'une formulaire sous forme de tableau
     * dont les indexes sont les noms des champs erronnés et les
     * valeurs les erreurs renvoyées.
     * @param FormInterface $form
     * @return array
     */
    private function getErrorsAsArray(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error)
            $errors[] = $error->getMessage();

        foreach ($form->all() as $key => $child) {
            if ($err = $this->getErrorsAsArray($child))
                $errors[$key] = $err;
        }
        return $errors;
    }


}