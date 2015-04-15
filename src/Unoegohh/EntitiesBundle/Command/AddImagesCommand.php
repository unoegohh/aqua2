<?php
namespace Unoegohh\EntitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\Contact;
use Unoegohh\EntitiesBundle\Entity\ItemImage;
use Unoegohh\EntitiesBundle\Entity\SitePref;

class AddImagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:add_images')
            ->setDescription('creates contact prefs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:Item');

        $pref = $prefRepo->getImagesProducts();
        foreach($pref as $item){
            $prefPhoto = new ItemImage();
            $prefPhoto->setUrl("http://i.imgur.com/r1oaOcJ.jpg");
            $prefPhoto->setItemId($item);
            $em->persist($prefPhoto);
            $em->flush();
        }


    }
}