<?php
namespace Unoegohh\EntitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\MainCategories;
use Unoegohh\EntitiesBundle\Entity\SitePref;

class AddMainCategoriesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:add_mainCat')
            ->setDescription('creates main categores');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:MainCategories');

        $pref = $prefRepo->findBy(array(), array(), 1);

        if($pref){

            $output->writeln('Already exists!');
        }else{
            $pref = new MainCategories();

            $em->persist($pref);
            $em->flush();

            $output->writeln('DONE!');
        }

    }
}