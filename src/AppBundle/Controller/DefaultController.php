<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Landmark;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Services\RestClient;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * Lists all landmark entities.
     * @Route("/landmark/", name="landmark_index")
     * @Method("GET")
     */
    public function landmarkIndexAction()
    {
        $landmarks = $this->getDoctrine()->getRepository(Landmark::class)->findAll();

        return $this->render('landmark/index.html.twig', array(
            'landmarks' => $landmarks
        ));
    }

    /**
     * Finds and displays a landmark entity.
     * @Route("/landmark/{id}", name="landmark_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Landmark $landmark)
    {
        return $this->render('landmark/show.html.twig', array(
            'landmark' => $landmark
        ));
    }

    /**
     * Searches for a landmark by name in the DB
     * @Route("/landmark/search", name="landmark_search")
     * @Method("POST")
     */
    public function searchAction(Request $request)
    {
        if (!empty($request->get('name'))) {
            $name = urlencode(strtolower($request->get('name')));

            $landmark = $this->getDoctrine()->getRepository(Landmark::class)->findOneBy(['name' => $name]);

            $place_id = $landmark ? $landmark->getPlaceId(): null;
        }
        else {
            $place_id = null;
        }
        return new Response($place_id, Response::HTTP_OK);
    }

    /**
     * Queries the Google Maps API for new landmarks.
     * @Route("/landmark/searchnew", name="landmark_searchnew")
     * @Method("POST")
     */
    public function searchNewAction(Request $request, RestClient $restClient)
    {
        if (!empty($request->get('name'))) {
            $name = urlencode(strtolower($request->get('name')));

            $place_id = $restClient->get($name);
        }
        else {
            $place_id = null;
        }
        return new Response($place_id, Response::HTTP_OK);
    }
}
