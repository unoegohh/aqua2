<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\ItemCategoryForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;

class ItemCategoryController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $categoryRepo = $em->getRepository('UnoegohhEntitiesBundle:ItemCategory');

        $categories = $categoryRepo->findAll();

        return $this->render('UnoegohhAdminBundle:ItemCategory:index.html.twig', array('categories'=>$categories));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $cat = new ItemCategory();

        $form = $this->createForm(new ItemCategoryForm(), $cat);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $em->persist($cat);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Категория добавлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_food_category_edit', array("id" => $cat->getId())));
        }
        return $this->render('UnoegohhAdminBundle:ItemCategory:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:ItemCategory');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Категория не найдена");
        }

        $form = $this->createForm(new ItemCategoryForm(), $cat);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $em->persist($cat);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Категория обновлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_food_category_edit', array("id" => $cat->getId())));

        }
        return $this->render('UnoegohhAdminBundle:ItemCategory:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:ItemCategory');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Категория не найдена");
        }
        return $this->render('UnoegohhAdminBundle:ItemCategory:remove.html.twig', array('cat'=>$cat));
    }

    public function removeOkAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:ItemCategory');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Категория не найдена");
        }

        $em->remove($cat);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Категория удалена!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_food_category'));

    }
}
