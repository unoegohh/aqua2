<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM;
use Unoegohh\AdminBundle\Form\ItemForm;
use Unoegohh\EntitiesBundle\Entity\Item;
use Unoegohh\EntitiesBundle\Entity\ItemImage;

class ItemController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:Item');

        $foods = $foodRepo->findAll();


        return $this->render('UnoegohhAdminBundle:Item:index.html.twig', array('result'=>$foods));
    }


    public function createAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $food = new Item();

        $form = $this->createForm(new ItemForm(), $food);

        $form->handleRequest($request);

        if($form->isValid()){
            $food = $form->getData();
            $em->persist($food);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Товар добавлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_food_item_edit', array("id" => $food->getId())));
        }
        return $this->render('UnoegohhAdminBundle:Item:create.html.twig', array('form'=>$form->createView()));
    }

    public function editAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:Item');
        $food = $foodRepo->find($id);

        if(!$food){
            throw new Exception("Товар не найден");
        }

        $form = $this->createForm(new ItemForm(), $food);

        $form->handleRequest($request);

        if($form->isValid()){
            $food = $form->getData();
            $em->persist($food);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Товар обновлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_food_item_edit', array("id" => $food->getId())));

        }
        return $this->render('UnoegohhAdminBundle:Item:edit.html.twig', array('form'=>$form->createView(), 'food' => $food));
    }

    public function removeAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:Item');
        $food = $foodRepo->find($id);

        if(!$food){
            throw new Exception("Товар не найден");
        }
        return $this->render('UnoegohhAdminBundle:Item:remove.html.twig', array('food'=>$food));
    }

    public function removeOkAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:Item');
        $food = $foodRepo->find($id);

        if(!$food){
            throw new Exception("Товар не найден");
        }

        $em->remove($food);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Товар удален!'
        );
        return $this->redirect($this->generateUrl('unoegohh_admin_food_item'));

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

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:Item');
        $food = $foodRepo->find($id);

        $photo = new ItemImage();
        $photo->setItemId($food);
        $photo->setUrl($item['msg']);
        $em->persist($photo);
        $em->flush();

        $item['id'] = $photo->getId();
        return new JsonResponse($item);
    }

    public function removeImageAction(Request $request, $id){

        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:ItemImage');
        $food = $foodRepo->find($id);
        $em->remove($food);
        $em->flush();

        return new JsonResponse(array("ok"=> true));
    }
}
