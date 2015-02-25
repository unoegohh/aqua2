<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\CustomerRequestForm;
use Unoegohh\AdminBundle\Form\FoodCategoryForm;
use Unoegohh\AdminBundle\Form\ItemCategoryForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\CustomerRequest;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;
use Unoegohh\UserBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;

class CustomerRequestController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $categoryRepo = $em->getRepository('UnoegohhEntitiesBundle:CustomerRequest');

        $categories = $categoryRepo->findAll();

        return $this->render('UnoegohhAdminBundle:CustomerRequest:index.html.twig', array('data'=>$categories));
    }

    public function editAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $catRepo = $em->getRepository('UnoegohhEntitiesBundle:CustomerRequest');
        $cat = $catRepo->find($id);

        if(!$cat){
            throw new Exception("Заявка не найдена");
        }

        $form = $this->createForm(new CustomerRequestForm(), $cat);

        $form->handleRequest($request);

        if($form->isValid()){

            /* @var $user User */
            $userRepo = $em->getRepository('UnoegohhUserBundle:User');
            $oldUser = $userRepo->findOneBy(array('username'=>$cat->getUsername()));
            $oldUser2 = $userRepo->findOneBy(array('email'=>$cat->getEmail()));
            if($oldUser){
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Пользователь c таким логином существует'
                );
            }
            if($oldUser2){
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Пользователь c такой почтой существует'
                );
            }
            if(!$oldUser && !$oldUser2){

                $cat = $form->getData();
                $cat->setDone(true);
                $em->flush();
                /* @var $userManager UserManager */
                $userManager = $this->container->get('fos_user.user_manager');

                $user = $userManager->createUser();
                $user->setUsername($cat->getUserName());
                $user->setEmail($cat->getEmail());
                $user->setPlainPassword($cat->getPassword());
                $user->setEnabled(true);
                $user->setCreated(true);
                $userManager->updateUser($user);
                $userManager->updatePassword($user);
                $userManager->updateUser($user);
                $em->persist($cat);
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Пользователь добавлен'
                );
            }

//            return $this->redirect($this->generateUrl('unoegohh_admin_food_category_edit', array("id" => $cat->getId())));
        }
        return $this->render('UnoegohhAdminBundle:CustomerRequest:edit.html.twig', array('form'=>$form->createView(), 'item' => $cat));
    }

    public function removeAction(CustomerRequest $id)
    {
        return $this->render('UnoegohhAdminBundle:CustomerRequest:remove.html.twig', array('item'=>$id));
    }

    public function removeOkAction( CustomerRequest $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        if($id->getDone()){
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Заявка не может быть удаленa!'
            );
        }else{

            $em->remove($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Заявка удален!'
            );
        }
        return $this->redirect($this->generateUrl('unoegohh_admin_customer_request'));
    }
}
