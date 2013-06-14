<?php

namespace Adibox\Bundle\CacheBundle\TwigExtension;

use Adibox\Bundle\CacheBundle\Interfaces\InterfaceRender;
use \Twig_Extension;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CacheHelper extends Twig_Extension implements ContainerAwareInterface {

	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function getFilters()
    {
    	return array(
            'renderObject' => new \Twig_Filter_Method($this, 'renderObject', array('is_safe' => array('html'))),
    	);
    }

    public function renderObject(InterfaceRender $renderObject)
    {
        $renderObject->setContainer($this->container);

        $renderObject->loadDataDependsContainer($this->container);

        $renderObject->postWakeUp();

        return $renderObject->getRender();
    }

    public function getName()
    {
    	return "adiboxcachebundle.twigextension.cachehelper";
    }
}

?>