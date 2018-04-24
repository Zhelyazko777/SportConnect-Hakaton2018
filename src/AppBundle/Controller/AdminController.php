<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Place;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin")
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Event::class);
        $numOfEvents = $repo->getCountOfEvents();
        $repo = $this->getDoctrine()->getRepository(User::class);
        $numOfUsers = $repo->getCountOfUsers();
        $repo = $this->getDoctrine()->getRepository(Place::class);
        $numOfPlaces = $repo->getCountOfPlaces();
        return $this->render("admin/index.html.twig", ['numOfEvents' => $numOfEvents[0], 'numOfUsers' => $numOfUsers[0], "numOfPlaces" => $numOfPlaces[0]]);
    }
}
