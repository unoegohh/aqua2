<?php

namespace Unoegohh\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RenderController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $menu = $em->getRepository("UnoegohhEntitiesBundle:MenuItem")->getMainMenu($this->getUser());
        return $this->render('UnoegohhShopBundle:Render:menu.html.twig', array('menu' => $menu));
    }
//    public function categoriesAction($name)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $menu = $em->getRepository("UnoegohhEntitiesBundle:ItemCategory")->getCategoriesMenu();
//        return $this->render('UnoegohhShopBundle:Render:categories.html.twig', array('menu' => $menu, 'categoryName' => $name));
//    }
//    public function footerMenuAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//        $menu = $em->getRepository("UnoegohhEntitiesBundle:MenuItem")->findBy(array(), array('orderNum' => 'ASC'));
//        return $this->render('UnoegohhShopBundle:Render:footerMenu.html.twig', array('menu' => $menu));
//    }
}
