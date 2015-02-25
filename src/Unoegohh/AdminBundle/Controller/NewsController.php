<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\MainBannerForm;
use Unoegohh\AdminBundle\Form\NewsForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\MainBanner;
use Unoegohh\EntitiesBundle\Entity\News;
use Unoegohh\EntitiesBundle\Entity\NewsImage;

class NewsController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $bannerRepo = $em->getRepository('UnoegohhEntitiesBundle:News');

        $news = $bannerRepo->findAll();

        return $this->render('UnoegohhAdminBundle:News:index.html.twig', array('news'=>$news));
    }

    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $news = new News();

        $form = $this->createForm(new NewsForm(), $news);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $cat->setDate(new \DateTime('now'));
            $em->persist($cat);

            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Новость добавлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_news_edit', array("id" => $cat->getId())));
        }
        return $this->render('UnoegohhAdminBundle:News:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:News');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Новость не найдена");
        }

        $form = $this->createForm(new NewsForm(), $cat);

        $form->handleRequest($request);

        if($form->isValid()){
            $cat = $form->getData();
            $em->persist($cat);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Новость обновлена!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_news_edit', array("id" => $cat->getId())));

        }
        return $this->render('UnoegohhAdminBundle:News:edit.html.twig', array('form'=>$form->createView(), 'item' => $cat));
    }

    public function removeAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:News');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Новость не найдена");
        }
        return $this->render('UnoegohhAdminBundle:News:remove.html.twig', array('cat'=>$cat));
    }

    public function removeOkAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:News');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Новость не найдена");
        }

        $em->remove($cat);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Новотсь удаленна!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_news'));

    }
    public function imageUploadAction(Request $request, $id){

        $files = $request->files;
        $service = $this->get('unoegohh.admin_bundle.imgur_upload');
        foreach ($files as $uploadedFile) {
            $name = 'name';
            $item['msg'] = $service->upload($uploadedFile['file']);
        }
        $item['error'] ='';


        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:News');
        $food = $foodRepo->find($id);

        $photo = new NewsImage();
        $photo->setItemId($food);
        $photo->setUrl($item['msg']);
        $em->persist($photo);
        $em->flush();

        $item['id'] = $photo->getId();
        return new JsonResponse($item);
    }

    public function removeImageAction(Request $request, $id){

        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:NewsImage');
        $food = $foodRepo->find($id);
        $em->remove($food);
        $em->flush();

        return new JsonResponse(array("ok"=> true));
    }
}
