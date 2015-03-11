<?php

namespace Unoegohh\AdminBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\SecurityContext;
use Unoegohh\EntitiesBundle\Entity\Item;

class PriceBoostService
{
    /**
     *
     * @var $em EntityManager
     * @var $container ContainerInterface
     */
    protected $em;
    protected $container;
    protected $requestInjector;
    protected $session;



    function __construct($em,$container,RequestInjector $requestInjector)
    {
        $this->em = $em;
        $this->container = $container;
        $this->requestInjector = $requestInjector;
        $this->session = $this->requestInjector->getRequest()->getSession();
    }

    protected $price;

    public function updatePrefBoost(){
        $settRepo = $this->em->getRepository("UnoegohhEntitiesBundle:SitePref");
        $pref = $settRepo->findOneBy(array());
        $this->session->set("prefBoost", $pref->getPriceBoost());
        return $pref->getPriceBoost();
    }

    public function calculate(Item $item)
    {

        if($this->price === null){
            $settRepo = $this->em->getRepository("UnoegohhEntitiesBundle:SitePref");
            $this->price = $settRepo->findOneBy(array());
        }
        $rawResult = 0;
        // sale - price - usd
        if($item->getPriceEUR()){
            $rawResult = $item->getPriceEUR() * $this->price->getPriceEUR();
        }elseif($item->getPriceUSD()){
            $rawResult = $item->getPriceUSD() * $this->price->getPriceUSD();
        }else{
            $rawResult = $item->getPrice();
        }

        $result = ceil($rawResult/10)*10;
        return $result;
    }



}