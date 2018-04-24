<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $name
     */
    public function game()
    {
        return $this->render("game/game.html.twig");
    }
}
