<?php
namespace Adibox\Bundle\CacheBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

use Symfony\Component\HttpFoundation\Response;

use Adibox\Bundle\CacheBundle\Interfaces\interfaceRender;
use Adibox\Bundle\CacheBundle\Iterator\iterateCacheUnserialize;

class listener {

	private $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function onKernelView(GetResponseForControllerResultEvent $event)
	{
		$response = ($event->hasResponse()) ? $event->getResponse() : $event->getControllerResult();

		if($response instanceof interfaceRender)
		{
			$reponse = new iterateCacheUnserialize($response, $this);
		}

		if($response instanceof iterateCacheUnserialize)
		{
			$event->setResponse(new Response($this->container->get("templating")->render("AdiboxCacheBundle::toView.html.twig", array("elements" => $response))));
			$event->stopPropagation();
		}
	}

}

?>