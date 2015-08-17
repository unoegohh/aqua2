<?php
namespace Unoegohh\EntitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\Contact;
use Unoegohh\EntitiesBundle\Entity\Item;
use Unoegohh\EntitiesBundle\Entity\ItemImage;
use Unoegohh\EntitiesBundle\Entity\SitePref;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;
use Unoegohh\EntitiesBundle\Repository\ItemCategoryRepository;

class ReturnCometCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:return_commet')
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
        $itemCategory->setName("Comet");
        $itemCategory->setEngName("comet");
        $em->persist($itemCategory);

        if (($handle = file_get_contents($this->getContainer()->get('kernel')->getRootDir() . "/../web/js/item.json", "r")) !== FALSE) {
             $ii = json_decode($handle);
            foreach($ii as $subCategory){
                $newCat = new ItemCategory();
                if(isset($subCategory->name)){

                    $newCat->setName($subCategory->name);
                    $newCat->setChildId($itemCategory);
                    foreach($subCategory->items as $item){
                        $items = new Item();
                        $items->setName($item->name);
                        $items->setArticle($item->article);
                        $items->setPrice($item->price);
                        $items->setImport(1224);
                        $items->setCategoryId($newCat);
                        if(isset($item->img)){

                            $photo = new ItemImage();
                            $photo->setUrl($item->img);
                            $photo->setItemId($items);
                            $em->persist($photo);
                        }else{
                            $r =666;
                        }

                        $em->persist($items);

                    }
                    $em->persist($newCat);
                }else{
                    $ff =1;
                }

            }
        }
        $em->flush();
    }
}