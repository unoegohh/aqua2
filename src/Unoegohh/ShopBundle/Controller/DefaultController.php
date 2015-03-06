<?php

namespace Unoegohh\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Unoegohh\EntitiesBundle\Entity\CustomerRequest;
use Unoegohh\ShopBundle\Form\CustomerRequestForm;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $pageRepo = $em->getRepository("UnoegohhEntitiesBundle:StaticPage");
        $page  = $pageRepo->findOneBy(array('url' => 'about_us', 'active' => true));

        if(!$page){
            throw new NotFoundHttpException("Cтраница не найдена.");
        }
        if($page->getShowToUser() && !$this->getUser()){

            throw new NotFoundHttpException("Cтраница не найдена.");
        }

        return $this->render('UnoegohhShopBundle:StaticPage:index.html.twig', array('page' => $page));
    }
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository("UnoegohhEntitiesBundle:Contact")->findOneBy(array());

        $form = $this->createForm(new CustomerRequestForm(), new CustomerRequest());
        $form->handleRequest($request);

        if($form->isValid()){
            $order = $form->getData();
            $ch = curl_init("http://sms.ru/sms/send");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(

                "api_id"		=>	$this->container->getParameter("phone_api"),
                "to"			=>	$this->container->getParameter("phone"),
                "text"		=>"Поступила новая заявка!"

            ));
            $body = curl_exec($ch);
            curl_close($ch);

            $message = $this->get('mailer')->createMessage()
                ->setSubject("Сообщение с сайта")
                ->setFrom(array($this->container->getParameter('mail_from') => $this->container->getParameter('mail_name')))
                ->setBody($this->renderView('UnoegohhShopBundle:Contact:mail.html.twig', array('data' => $order)), 'text/html')
                ->addTo($this->container->getParameter('mail_to'));

            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('unoegohh_shop_contact_sent'));
        }
        return $this->render('UnoegohhShopBundle:Default:contact.html.twig', array(
            'data' => $data,
            "form" => $form->createView(),
        ));
    }
    public function contactSentAction(Request $request)
    {
        return $this->render('UnoegohhShopBundle:Default:contactSent.html.twig');
    }


}
