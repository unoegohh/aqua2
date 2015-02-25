<?php
namespace Unoegohh\AdminBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;
use Unoegohh\AdminBundle\Service\PriceBoostService;
use Symfony\Component\DependencyInjection\Container;

class RequestInjector{

    protected $container;

    public function __construct(Container $container){

        $this->container = $container;
    }

    public function getRequest(){

        return $this->container->get('request');
    }
}