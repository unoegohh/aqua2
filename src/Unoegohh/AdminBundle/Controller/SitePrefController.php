<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;

class SitePrefController extends Controller
{
    public function indexAction(Request $request)
    {

        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

        $pref = $prefRepo->findOneBy(array(), array(), 1);

        if(!$pref){
            throw new Exception("Ask admin to add pref!");
        }

        $form = $this->createForm(new SitePrefForm(), $pref);

        $form->handleRequest($request);

        if($form->isValid()){
            $pref = $form->getData();
            $em->persist($pref);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Сохранено!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_site_pref'));
        }

        return $this->render('UnoegohhAdminBundle:SitePref:index.html.twig', array('form'=>$form->createView()));
    }
}
