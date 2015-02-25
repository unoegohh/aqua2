<?php

namespace Unoegohh\AdminBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\SecurityContext;

class ImgurUploadService
{
    /**
     *
     * @var EntityManager
     * @var $container ContainerInterface
     */
    protected $em;
    protected $container;


    function __construct($em,$container,$imgurKey)
    {
        $this->em = $em;
        $this->container = $container;
        $this->imgurKey = $imgurKey;
    }

    public function upload(UploadedFile $file)
    {
        $filename = $file->getPathname();

        $handle = fopen($filename, "r");
        $data = fread($handle, filesize($filename));
        return $this->curlData(base64_encode($data));
    }

    public function uploadEncoded($file)
    {
        return $this->curlData($file);
    }

    public function curlData($image)
    {
        $client_id=$this->imgurKey;
        $pvars   = array('image' => $image);
        $timeout = 30;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
        $out = curl_exec($curl);
        curl_close ($curl);
        $pms = json_decode($out,true);
        $url=$pms['data']['link'];
        return $url;
    }



}