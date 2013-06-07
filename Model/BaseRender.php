<?php
namespace Adibox\Bundle\CacheBundle\Model;

use Adibox\Bundle\CacheBundle\Model\BaseData;
use Adibox\Bundle\CacheBundle\Interfaces\InterfaceRender;

abstract class BaseRender extends BaseData implements InterfaceRender
{
	public function render($template, $vars = array())
	{
		return $this->container->get("templating")->render($template, $vars);
	}
}
?>