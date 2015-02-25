<?php
namespace Unoegohh\EntitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\Contact;
use Unoegohh\EntitiesBundle\Entity\SitePref;

class AddContactPrefCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:add_contact_pref')
            ->setDescription('creates contact prefs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:Contact');

        $pref = $prefRepo->findBy(array(), array(), 1);

        if($pref){

            $output->writeln('Already exists!');
        }else{
            $pref = new Contact();
            $pref->setPhone("Change Me!!!");
            $pref->setEmail("Change Me!!!");
            $pref->setAddress("Change Me!!!");
            $pref->setDescr("Change Me!!!");
            $pref->setMapX("Change Me!!!");
            $pref->setMapY("Change Me!!!");
            $pref->setWorkHours("Change Me!!!");

            $em->persist($pref);
            $em->flush();

            $output->writeln('DONE!');
        }

    }
}