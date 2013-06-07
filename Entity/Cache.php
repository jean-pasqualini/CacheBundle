<?php

namespace Adibox\Bundle\CacheBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adibox\Bundle\RenderBundle\Entity\Cache
 * 
 * Uniquement pour l'afficahge [LIST, SORT, SEARCH]
 * Set authorized for hydrate only
 * Get unauthorized , use HYDRATE_ARRAY for best performance
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Cache
{
	/**
	* @ORM\Column(name="id_cached", type="integer")
    * @ORM\Id
    */
    private $id_cached;

    /**
    * @ORM\Column(name="name", type="string")
    * @ORM\Id
    */
    private $name;

    /**
    * @ORM\Column(name="isupdate", type="boolean")
    */
    private $isupdate = false;

    /**
    * @ORM\Column(name="data", type="object")
    */
    private $data;

    /**
    * @ORM\Column(type="integer")
    * @ORM\Version
    */
    private $version;

    /**
    * @ORM\Column(type="string")
    */
    private $idHttp;

    public function __construct($id_cached, $name)
    {
    	$this->id_cached = $id_cached;

    	$this->name = $name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getIdHttp()
    {
        if($this->idHttp === null) $this->setGenerateIdHttp();
    
        return $this->idHttp;
    }

    public function setIdHttp($idHttp)
    {
        $this->idHttp = $idHttp;
    }

    public function generateIdHttp()
    {
        return $this->getIdCache().$this->getName().$this->getVersion();
    }

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function setGenerateIdHttp()
    {
        $this->setIdHttp($this->generateIdHttp());
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIdCache()
    {
        return $this->id_cached;
    }

    public function setData($data)
    {
        if(!is_object($data) && is_array($data)) $data = new \ArrayObject($data);

    	$this->data = $data;

        $this->updateNotRequired();

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    private function updateNotRequired()
    {
        $this->isupdate = false;
    }

    public function updateRequired()
    {
        $this->isupdate = true;
    }

    public function isUpdateRequired()
    {
        return $this->isupdate;
    }
}
