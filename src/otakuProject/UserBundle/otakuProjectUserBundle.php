<?php

namespace otakuProject\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class otakuProjectUserBundle extends Bundle
{
	public function getParent()
	{
    	return 'FOSUserBundle';
  	}
}
