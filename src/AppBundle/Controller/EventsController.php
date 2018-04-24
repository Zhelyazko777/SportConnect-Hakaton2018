<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\EventCategory;
use AppBundle\Entity\Place;
use AppBundle\Entity\User;
use AppBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{
    /**
     * @Route("/event/add", name="event_add")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addEvent(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $repo = $this->getDoctrine()->getRepository(User::class);
            $user = $repo->findOneBy(['username' => $this->getUser()->getUsername()]);
            $event->setAuthor($user);
            $event->setPostDate( new \DateTime( date("Y-m-d H:i:s", strtotime('+1 hour'))) );
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('index');
        }
        $repo = $this->getDoctrine()->getRepository(EventCategory::class);
        $categories = $repo->findAll();
        $repo = $this->getDoctrine()->getRepository(Place::class);
        $places = $repo->findAll();

        return $this->render('event/add.html.twig', ['form' => $form->createView(),
            'categories' => $categories,
            'places' => $places]);
    }

    /**
     * @Route("/event/show/all", name="events_show")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showEvent()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Event::class);
        $eventsArr = $repo->findAll();
        $categories = $this->getDoctrine()->getRepository(EventCategory::class)->findAll();

        return $this->render('event/showAll.html.twig', ['eventsArr' => $eventsArr, 'categories' =>$categories]);
    }

    /**
     * @Route("/event/show/{id}", name="events_by_id")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showEventById(int $id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Event::class);
        $event = $repo->find($id);
        $categories = $this->getDoctrine()->getRepository(EventCategory::class)->findAll();

        return $this->render('event/showById.html.twig', ['event' => $event, 'categories' => $categories]);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/event/update/{id}", name="event_update")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public  function updateEvent(int $id, Request $request)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Event::class);
        $event = $repo->find($id);

        if ($event->getAuthor()->getUsername() == $this->getUser()->getUsername() ||
            in_array('ROLE_ADMIN' ,$this->getUser()->getRoles()))
        {
            $form = $this->createForm(EventType::class, $event);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){

                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return $this->redirectToRoute('index');
            }
            return $this->render('event/update.html.twig', ['form' => $form->createView(), 'event' => $event]);
        }
        return $this->redirectToRoute('index');
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/event/delete/{id}", name="event_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public  function  deleteEvent(int $id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Event::class);
        $event = $repo->find($id);
        if ($event->getAuthor()->getUsername() == $this->getUser()->getUsername() ||
            in_array('ROLE_ADMIN' ,$this->getUser()->getRoles())) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
            return $this->redirectToRoute("index");
        }
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/event/addParticipant/{id}", name="participant_add")
     * @param int $id
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addParticipant(int $id)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $this->getUser()->getUsername()]);
        $repo = $this->getDoctrine()->getRepository(Event::class);
        $event = $repo->find($id);
        $event->setParticipants($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/events/showByCategs/{id}", name="events_category")
     * @param int $id
     * @return null
     */
    public function ArticlesShowByCategories(int $id)
    {
        $category = $this->getDoctrine()->getRepository(EventCategory::class)->find($id);
        $events = $category->getEvents();
        $allCategories = $this->getDoctrine()->getRepository(EventCategory::class)->findAll();
        $category = $category->getName();
        if(count($events) == 0){
            return $this->render("event/cleanCategory.html.twig", ['categories' => $allCategories,
                'category' => $category]);
        }
        else{
            return $this->render("event/eventsByCategory.html.twig", ['events' => $events,
                'category' => $category,
                'categories' => $allCategories]);
        }
    }
}
