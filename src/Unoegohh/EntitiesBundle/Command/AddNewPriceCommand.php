<?php
namespace Unoegohh\EntitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\Contact;
use Unoegohh\EntitiesBundle\Entity\Item;
use Unoegohh\EntitiesBundle\Entity\SitePref;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;
use Unoegohh\EntitiesBundle\Repository\ItemCategoryRepository;

class AddNewPriceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:add_price')
            ->setDescription('parses prods form csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /*
         * @var $prefRepo ItemCategoryRepository
         */
        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:ItemCategory');
        $i = $em->getRepository('UnoegohhEntitiesBundle:Item');


        $row = 0;
        $maincats = array();
        $output->writeln($this->getContainer()->get('kernel')->getRootDir());

        $itemCategory = new ItemCategory();
        $itemCategory->setName("Автосервисное оборудование AE&T");
        $itemCategory->setEngName("aet");
        $em->persist($itemCategory);

        $category = new ItemCategory();
        if (($handle = fopen($this->getContainer()->get('kernel')->getRootDir() . "/../web/323.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1300, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                $items = explode(",", $data[0]);
                if($items[1] == "" && $items[2] == "" && $items[3] == ""){
                    $category = new ItemCategory();
                    $category->setName($items[0]);
                    $category->setChildId($itemCategory);
                    $em->persist($category);
                }else{
                    $item = new Item();
                    $item->setActive(true);
                    $item->setCategoryId($category);
                    $item->setArticle($items[0]);
                    $itemPrice = $items[count($items)-2];
                    $item->setPriceUSD($itemPrice);
                    $splicedArray =array_slice($items, 1);
                    $itemName = implode(array_slice($splicedArray,0,count($splicedArray)-2), ",");
                    $item->setName($itemName);
                    $em->persist($item);
                }
            }
        }
        $em->flush();
    }
}