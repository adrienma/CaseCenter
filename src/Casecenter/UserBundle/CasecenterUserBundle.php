<?php

namespace Casecenter\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CasecenterUserBundle extends Bundle
{
	public function getParent()
	{
		return "FOSUserBundle";
	}
}
