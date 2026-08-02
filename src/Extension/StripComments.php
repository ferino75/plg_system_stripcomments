<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  System.fgstripcomments
 *
 * @copyright   (C) 2026 Fero. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace FG\Plugin\System\StripComments\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\Event\Application\AfterRenderEvent;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\SubscriberInterface;

final class StripComments extends CMSPlugin implements SubscriberInterface
{
	/**
	 * Map the events this plugin listens to.
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onAfterRender' => 'onAfterRender',
		];
	}

	/**
	 * Remove backend-only marker strings such as "{-- Levice --}" from the
	 * rendered front-end output.
	 */
	public function onAfterRender(AfterRenderEvent $event): void
	{
		$app = $event->getApplication();

		// Front-end only by default — the markers must stay visible in the back-end.
		if ($app->isClient('administrator') && !$this->params->get('run_admin', 0)) {
			return;
		}

		if (!$app->isClient('site') && !$app->isClient('administrator')) {
			// Skip API, CLI, etc.
			return;
		}

		// Only touch HTML documents.
		$document = $app->getDocument();

		if ($document === null || $document->getType() !== 'html') {
			return;
		}

		$body = $app->getBody();

		if ($body === '') {
			return;
		}

		$open  = (string) $this->params->get('open_delim', '{--');
		$close = (string) $this->params->get('close_delim', '--}');

		if ($open === '' || $close === '') {
			return;
		}

		// Eat any whitespace BEFORE the marker so "Title {-- note --}" becomes
		// "Title" (no trailing space) and "A {-- x --} B" becomes "A B".
		$markerBody    = '\s*' . preg_quote($open, '/') . '.*?' . preg_quote($close, '/');
		$markerPattern = '/' . $markerBody . '/su';

		$scope = (string) $this->params->get('scope', 'titles');

		if ($scope === 'titles') {
			// Strip markers only inside titles: headings (h1-h6), the page
			// <title>, and link text (<a>) such as menu items and breadcrumbs.
			// Body/paragraph text is left untouched.
			$cleaned = preg_replace_callback(
				'#(<(h[1-6]|title|a)\b[^>]*>)(.*?)(</\2>)#sui',
				static function (array $m) use ($markerPattern): string {
					return $m[1] . preg_replace($markerPattern, '', $m[3]) . $m[4];
				},
				$body
			);
		} else {
			// Strip markers everywhere in the output, but leave <script> and
			// <style> blocks untouched — their content is code/CSS, not page
			// text, and could coincidentally contain the delimiter sequence.
			// (*SKIP)(*FAIL) makes the engine skip over those blocks entirely
			// without ever testing the marker pattern inside them.
			$skipAwarePattern = '#(?:<script\b[^>]*>.*?</script>|<style\b[^>]*>.*?</style>)(*SKIP)(*FAIL)|'
				. $markerBody . '#siu';

			$cleaned = preg_replace($skipAwarePattern, '', $body);
		}

		// preg_replace* returns null on failure (e.g. backtrack limit) — keep original then.
		if ($cleaned !== null) {
			$app->setBody($cleaned);
		}
	}
}
