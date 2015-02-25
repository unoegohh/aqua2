<?php

namespace Unoegohh\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\Item;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;
use Unoegohh\EntitiesBundle\Entity\News;
use Unoegohh\EntitiesBundle\Entity\Order;
use Unoegohh\ShopBundle\Form\CashForm;

class NewsController extends Controller
{
    public function indexAction(Request $request, $categoryName = null)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository("UnoegohhEntitiesBundle:News")->findAll();
        return $this->render('UnoegohhShopBundle:News:list.html.twig', array(
            'data' => $items,
        ));
    }

    public function itemAction(News $id)
    {
        return $this->render('UnoegohhShopBundle:News:item.html.twig', array('item' => $id));
    }

}
