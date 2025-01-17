<?php declare(strict_types = 1);

namespace App\Router;

use Nette\Application\Routers\RouteList;
use Nette\StaticClass;

final class RouterFactory
{

	use StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList();

		$router->addRoute('api/items', [
			'presenter' => 'Api',
			'action' => 'items',
		]);

		$router->addRoute('<presenter>[[/<locale=en_GB>][/<action>]]', [
			'presenter' => 'Basic',
			'action' => 'default',
			'locale' => 'en_GB',
		]);

		return $router;
	}

}
