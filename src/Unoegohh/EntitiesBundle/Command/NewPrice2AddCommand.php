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

class NewPrice2AddCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:newPriceAdd2')
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
        //$row = 0;
        $category1= $prefRepo->findOneBy(array("name" => "Ramex"));
        if($category1 == null){
            $category1 = new ItemCategory();
            $category1->setName("Ramex");
            $em->persist($category1);
        }
        foreach($category1->getChild() as $item){
            $em->remove($item);
        }

        $items = $i->findBy(array("import" => "35"));
        foreach($items as $item){
            $em->remove($item);

        }
        $em->flush();
        $output->writeln($this->getContainer()->get('kernel')->getRootDir());
        $category = null;
        if (($handle = fopen($this->getContainer()->get('kernel')->getRootDir() . "/../web/454.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1300, ",")) !== FALSE) {
                //$items = explode(",", $data[0]);
                if(($data[1] == "" && $data[2] == "" && $data[3] == "" && $data[0] != "" )||
                    $data[0] == "" && $data[2] == "" && $data[3] == "" && $data[1] != "" ){
                    $category = new ItemCategory();
                    if($data[0]){

                        $category->setName($data[0]);
                    }else{
                        $category->setName($data[1]);

                    }
                    //$category->setName(str_replace("Комета", "Comet",$category->getName()));
                    $category->setChildId($category1);
                    $em->persist($category);
                }else{
                    $item = new Item();
                    $item->setActive(true);
                    $item->setCategoryId($category);
                    $item->setArticle($data[0]);
                    $itemPrice = ceil(floatval(str_replace(".",",",$data[3])));
                    $item->setPriceEUR($itemPrice);
                    $item->setImport(35);

                    $item->setName($data[1]);
                    $item->setDescription($data[2]);
                    $em->persist($item);
                }

            }
        }
        $em->flush();
    }
}