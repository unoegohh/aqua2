<?php
namespace Unoegohh\AdminBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;
use Unoegohh\AdminBundle\Service\PriceBoostService;

class PriceBoostTwigService extends \Twig_Extension
{
    protected $em;
    protected $priceBoost;

    public function __construct(EntityManager $em, PriceBoostService $priceBoost)
    {
        $this->em = $em;
        $this->priceBoost = $priceBoost;
    }
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('itemPriceBoost', array($this, 'itemPriceBoost')),
        );
    }

    public function itemPriceBoost($item)
    {
        $price = $this->priceBoost->calculate($item);
        return $price;
    }

    public function getName()
    {
        return 'itemPriceBoost';
    }
}