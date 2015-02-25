<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\MainBannerForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\MainBanner;

class MainBannerController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $bannerRepo = $em->getRepository('UnoegohhEntitiesBundle:MainBanner');

        $banners = $bannerRepo->findAll();

        return $this->render('UnoegohhAdminBundle:MainBanner:index.html.twig', array('banners'=>$banners));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $banner = new MainBanner();

        $form = $this->createForm(new MainBannerForm(), $banner);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $em->persist($cat);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Баннер добавлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_banners_edit', array("id" => $cat->getId())));
        }
        return $this->render('UnoegohhAdminBundle:MainBanner:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:MainBanner');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Баннер не найден");
        }

        $form = $this->createForm(new MainBannerForm(), $cat);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $em->persist($cat);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Баннер обновлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_banners_edit', array("id" => $cat->getId())));

        }
        return $this->render('UnoegohhAdminBundle:MainBanner:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:MainBanner');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Баннер не найден");
        }
        return $this->render('UnoegohhAdminBundle:MainBanner:remove.html.twig', array('cat'=>$cat));
    }

    public function removeOkAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:MainBanner');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Баннер не найден");
        }

        $em->remove($cat);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Баннер удален!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_banners'));

    }
}
