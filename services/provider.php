<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  System.stripcomments
 *
 * @copyright   (C) 2026 Fero. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Custom\Plugin\System\StripComments\Extension\StripComments;

return new class () implements ServiceProviderInterface {
	public function register(Container $container): void
	{
		$container->set(
			PluginInterface::class,
			function (Container $container) {
				$plugin = new StripComments(
					$container->get(DispatcherInterface::class),
					(array) PluginHelper::getPlugin('system', 'stripcomments')
				);
				$plugin->setApplication(Factory::getApplication());

				return $plugin;
			}
		);
	}
};
