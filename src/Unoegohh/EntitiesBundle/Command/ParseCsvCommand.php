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

class ParseCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:parse_cats')
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
        $gg = $i->findAll();
        foreach($gg as $item){
            $em->remove($item);
        }
        $em->flush();
        $gg = $prefRepo->findAll();
        foreach($gg as $item){
            $em->remove($item);
        }

        $row = 0;
        $maincats = array();
        $output->writeln($this->getContainer()->get('kernel')->getRootDir());

        if (($handle = fopen($this->getContainer()->get('kernel')->getRootDir() . "/../web/4.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1300, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row!= 1){
                        $blackpowder = $data;
                        $dynamit = implode("|", $blackpowder);
                        $pieces = explode("|", $dynamit);
                        $category = new ItemCategory();
                        $category->setName(mb_convert_encoding($pieces[0], 'UTF-8'));
                        $em->persist($category);
                        $countNum = array('item' => $category, 'number' => intval($pieces[1]));
                        $maincats[intval($pieces[1])] = $countNum;
                }
            }
        }
        $subcats = array();
        $row = 0;
        if (($handle = fopen($this->getContainer()->get('kernel')->getRootDir() . "/../web/22.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1300, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row!= 1){
                        $blackpowder = $data;
                        $dynamit = implode("|", $blackpowder);
                        $pieces = explode("|", $dynamit);
                        $category = new ItemCategory();
                        $category->setName($pieces[1]);
                        //$category->setChildId($maincats[$pieces[1]]['item']);
                        $em->persist($category);
                        $countNum = array('item' => $category, 'number' => intval($pieces[1]));
                        $subcats[intval($pieces[1])] = $countNum;
                }
            }
        }
        $row = 0;
        if (($handle = fopen($this->getContainer()->get('kernel')->getRootDir() . "/../web/one.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1500, "|")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row > 1 && $row < 1175){
                        $blackpowder = $data;
                        $dynamit = implode("|", $blackpowder);
                        $pieces = explode("|", $dynamit);
                        $category = new Item();
                        $category->setArticle($pieces[0]);
                        $category->setName($pieces[1]);
                        $category->setDescription($pieces[2]);
                        $category->setActive(true);
                        $category->setPriceEUR(intval($pieces[3]));
                        $category->setCategoryId($subcats[$pieces[5]]['item']);

                        if($subcats[$pieces[5]]['item'] == null){
                            echo(1);
                        }
                        $subcats[$pieces[5]]['item']->setChildId($maincats[$pieces[4]]['item']);


                        $em->persist($category);
                }
            }
        }
        $em->flush();
    }
}