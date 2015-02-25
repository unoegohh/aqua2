<?php
namespace Unoegohh\EntitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\SitePref;

class AddPrefCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:addpref')
            ->setDescription('creates site prefs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:SitePref');

        $pref = $prefRepo->findBy(array(), array(), 1);

        if($pref){

            $output->writeln('Already exists!');
        }else{
            $pref = new SitePref();

            $em->persist($pref);
            $em->flush();

            $output->writeln('DONE!');
        }

    }
}