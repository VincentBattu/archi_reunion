<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Meeting;
use AppBundle\Entity\Point;
use AppBundle\Form\MeetingType;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

        $form = $this->createFormBuilder([])
            ->setMethod('POST')
            ->setAction($this->get('router')->generate('add_point_ajax', ['id' => $meeting->getId()]))
            ->add('submit', SubmitType::class, [
                'label' => 'Nouveau point',
                'attr'  => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();

        $pointsForm = [];
        /**
         * @var $point Point
         */
        foreach ($meeting->getPoints() as $point) {
            $pointsForm[$point->getId()] = $this->createUpdateTitleForm($point)->createView();
        }

        return $this->render('@App/Meeting/manage-points.html.twig', [
            'meeting'    => $meeting,
            'form'       => $form->createView(),
            'pointsForm' => $pointsForm
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
        $form = $this->createForm(MeetingType::class, $meeting);

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
     * Ajoute un point à l'objet meeting passé en paramètre.
     *  Méthode peut être appelée uniquement en AJAX et en POST (redirection vers la page d'accueil si
     * la requête n'est pas faite à travers un objet XMLHttpRequest en POST)
     * @return Response
     */
    public function addPointAction(Request $request, Meeting $meeting): Response
    {

        if (!$request->isXmlHttpRequest() || $request->getMethod() !== 'POST') {
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $point = new Point();
        $point->setTitle('Nouveau point.');
        $meeting->addPoint($point);
        $em->flush();

        return $this->json([
            'success' => true,
            'title'   => $point->getTitle(),
            'date'    => $point->getDate()->format(\DateTime::ISO8601)
        ]);
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
        $errors = array();
        foreach ($form->getErrors() as $error)
            $errors[] = $error->getMessage();

        foreach ($form->all() as $key => $child) {
            if ($err = $this->getErrorsAsArray($child))
                $errors[$key] = $err;
        }
        return $errors;
    }

    /**
     * Crée le formulaire correspondant à la modification du titre d'un point
     * @param Meeting $meeting
     * @return FormInterface
     */
    private function createUpdateTitleForm(Point $point): FormInterface
    {
        return $this->createFormBuilder($point)
            ->setAction($this->get('router')->generate('update_title_point_ajax', ['id' => $point->getId()]))
            ->setMethod('POST')
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->getForm();
    }
}