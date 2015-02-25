<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {


        return $this->render('UnoegohhAdminBundle:Default:index.html.twig',array(
        ));
    }
}
