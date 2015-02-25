<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\AdminBundle\Form\StaticPageForm;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\StaticPage;

class StaticPageController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $pagesRepo = $em->getRepository('UnoegohhEntitiesBundle:StaticPage');

        $pages = $pagesRepo->findAll();

        return $this->render('UnoegohhAdminBundle:StaticPage:index.html.twig', array('pages'=>$pages));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $page = new StaticPage();

        $form = $this->createForm(new StaticPageForm(), $page);

        $form->handleRequest($request);

        if($form->isValid()){
            $page = $form->getData();
            $em->persist($page);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Страница добавлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_static_page_edit', array("id" => $page->getId())));
        }
        return $this->render('UnoegohhAdminBundle:StaticPage:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request, StaticPage $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        if(!$id){
            throw new Exception("Статическая страница не найдена");
        }

        $form = $this->createForm(new StaticPageForm(), $id);

        $form->handleRequest($request);

        if($form->isValid()){
            $id = $form->getData();
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Страница обновлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_static_page_edit', array("id" => $id->getId())));

        }
        return $this->render('UnoegohhAdminBundle:StaticPage:edit.html.twig', array('form'=>$form->createView()));
    }

    public function removeAction(Request $request, StaticPage  $id)
    {
        return $this->render('UnoegohhAdminBundle:StaticPage:remove.html.twig', array('page'=>$id));
    }

    public function removeOkAction(Request $request, StaticPage $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();
        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Страница удалена!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_static_page'));

    }

    public function imageUploadAction(Request $request){

        $files = $request->files;
        $service = $this->get('unoegohh.admin_bundle.imgur_upload');
        foreach ($files as $uploadedFile) {
            $name = 'name';
            $item['msg'] = $service->upload($uploadedFile['file']);
        }
        $item['error'] ='';
        return new JsonResponse($item);
    }
}
