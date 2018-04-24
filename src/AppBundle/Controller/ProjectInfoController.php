<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectInfoController extends Controller
{
    /**
     * @Route("/project/info", name="project_info")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectInfo()
    {
        return $this->render("projectInfo/projectInfo.html.twig");
    }
}
