<?php

namespace Unoegohh\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StaticPageController extends Controller
{
    public function showAction($url)
    {
        $em = $this->getDoctrine()->getManager();
        $pageRepo = $em->getRepository("UnoegohhEntitiesBundle:StaticPage");
        $page  = $pageRepo->findOneBy(array('url' => $url, 'active' => true));

        if(!$page){
            throw new NotFoundHttpException("Cтраница не найдена.");
        }
        if($page->getShowToUser() && !$this->getUser()){

            throw new NotFoundHttpException("Cтраница не найдена.");
        }

        return $this->render('UnoegohhShopBundle:StaticPage:index.html.twig', array('page' => $page));
    }
}
