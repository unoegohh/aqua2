<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;

class AppKernel extends Kernel
{
    public function init()
    {
        date_default_timezone_set( 'Europe/Paris' );
        parent::init();
    }
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new FOS\UserBundle\FOSUserBundle(),

            new Unoegohh\UserBundle\UnoegohhUserBundle(),
            new Unoegohh\AdminBundle\UnoegohhAdminBundle(),
            new Unoegohh\EntitiesBundle\UnoegohhEntitiesBundle(),
            new Unoegohh\ShopBundle\UnoegohhShopBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new \Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
    protected function initializeContainer()
    {
        parent::initializeContainer();
        if (PHP_SAPI == 'cli') {
            $request = new Request();
            $request->create('/');
            $this->getContainer()->enterScope('request');
            $this->getContainer()->set('request', $request, 'request');
        }
    }
}
