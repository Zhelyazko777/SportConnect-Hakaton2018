<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use AppBundle\Entity\User;
use AppBundle\Form\PlaceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlaceController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/place/add", name="place_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            return $this->redirectToRoute("index");
        }

        return $this->render("place/place.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/place/show", name="places_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ShowPlaces()
    {
        $places = $this
            ->getDoctrine()
            ->getRepository(Place::class)
            ->findAll();
        return $this->render("place/showAll.html.twig" ,['places' => $places]);
    }
}
