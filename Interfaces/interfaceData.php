<?php

namespace Adibox\Bundle\CacheBundle\Interfaces;

interface interfaceData
{
	public function postWakeUp();

	public function loadDataDependsContainer($container);
}

?>