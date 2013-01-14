<?php

namespace ISG\ProjectSubmissionAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ISGProjectSubmissionAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
