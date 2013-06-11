<?php
namespace Adibox\Bundle\CacheBundle\Iterator;

class iterateCacheUnserialize implements \Iterator,\Countable {

	private $caches = array();
    private $cacheManager;
    private $isUpdateRequired;

    public function __construct($caches, $cacheManager)
    {
        $this->caches = $caches;
        $this->cacheManager = $cacheManager;
    }

    public function rewind()
    {
        reset($this->caches);

        return $this;
    }

    public function count()
    {
        return count($this->caches);
    }

    public function isUpdateRequireInIterator()
    {
        if(!empty($this->isUpdateRequired)) return $this->isUpdateRequired;

        $this->isUpdateRequired = false;

        foreach($this->caches as $cache)
        {
            if($this->isUpdateRequireForElement($cache)) $this->isUpdateRequired = true;
        }

        return $this->isUpdateRequired;
    }

    public function computeETag()
    {
        $id = "";

        foreach($this->caches as $cache)
        {
            if(is_array($cache))
            {
                $id .= $cache["idHttp"];
            }
        }

        $this->cacheManager->getContainer()->get("logger")->info("[CACHEMANAGER] ".$id);

        return md5($id);
    }

    public function getArrayWithoutIterator()
    {
        return $this->caches;
    }

    private function isUpdateRequireForElement($cache)
    {
        if(!is_array($cache)) return true;

        if($cache["id_cached"] == null || $cache["isupdate"])
        {
            return true;
        }


        return false;
    }

    public function appendTop($item)
    {
        array_unshift($this->caches, $item);
    }

    public function appendBottom($item)
    {
        array_push($this->caches, $item);
    }

    public function current()
    {
        $cur = current($this->caches);

        if(is_object($cur))
        {
            $cur->setContainer($this->cacheManager->getContainer());
            
            $cur->postWakeUp();

            return $cur;
        }

        if($this->isUpdateRequireForElement($cur) === true)
        {
            $cache = $this->cacheManager->onCacheRequireUpdateFromIterate($cur);

            if($cache != null)
            {
                $this->caches[$this->key()] = $cache;
                return $this->current();
            }

            throw new \Exception("Error for update cache on iterate call");
        }

        $this->caches[$this->key()] = unserialize($cur["data"]);

        return $this->current();
    }

    public function key()
    {
        return key($this->caches);
    }

    public function next()
    {
        return next($this->caches);
    }

    public function valid()
    {
        $key = key($this->caches);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }
}
?>