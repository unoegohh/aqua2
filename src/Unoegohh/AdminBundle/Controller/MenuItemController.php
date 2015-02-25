<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\MenuItemForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\MenuItem;

class MenuItemController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $menuRepo = $em->getRepository('UnoegohhEntitiesBundle:MenuItem');

        $menu = $menuRepo->findAll();

        return $this->render('UnoegohhAdminBundle:Menu:index.html.twig', array('menu'=>$menu));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $menu = new MenuItem();

        $form = $this->createForm(new MenuItemForm(), $menu);

        $form->handleRequest($request);

        if($form->isValid()){
            $menu = $form->getData();
            $em->persist($menu);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Элемент добавлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_menu_edit', array("id" => $menu->getId())));
        }
        return $this->render('UnoegohhAdminBundle:Menu:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request,MenuItem $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $form = $this->createForm(new MenuItemForm(), $id);

        $form->handleRequest($request);

        if($form->isValid()){
            $id = $form->getData();
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Элемент обновлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_menu_edit', array("id" => $id->getId())));

        }
        return $this->render('UnoegohhAdminBundle:Menu:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, MenuItem $id)
    {

        return $this->render('UnoegohhAdminBundle:Menu:remove.html.twig', array('menu'=>$id));
    }

    public function removeOkAction(Request $request, MenuItem $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();


        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Элемент удален!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_menu'));

    }
}
