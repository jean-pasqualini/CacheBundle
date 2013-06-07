<?php

namespace Adibox\Bundle\CacheBundle\Iterator;

class sortingIterator extends \ArrayIterator 
{
	public function __construct(\Traversable $iterator, $callback)
	{
		if(!is_callable($callback))
		{
			throw new \InvalidArgumentException("Callback must be callable");
		}

		parent::__construct(iterator_to_array($iterator));

		$this->uasort($callback);
	}
}