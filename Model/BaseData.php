<?php

namespace Adibox\Bundle\CacheBundle\Model;

use Symfony\Component\DependencyInjection\ContainerAware;

use Adibox\Bundle\CacheBundle\Interfaces\interfaceData;

abstract class BaseData extends ContainerAware implements interfaceData
{
	public function getUser()
	{
		return $this->container->get('security.context')->getToken()->getUser();
	}

	public function getEntityManager()
	{
		
	}

	public function transIn($phrase)
	{
		return $this->container->get("help.twig.extension")->transIn($phrase);
	}

	public function trans($key, $params = array(), $domain = "messages")
	{
		return $this->container->get("translator")->trans($key, $params, $domain);
	}

	public function generate($route, $params = array())
	{
		return $this->container->get("router")->generate($route, $params);
	}
}

?>