<?php

namespace Unoegohh\EntitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UnoegohhEntitiesBundle:Default:index.html.twig', array('name' => $name));
    }
}
