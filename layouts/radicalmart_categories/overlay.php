<?php
/*
 * @package   mod_radicalmart_categories
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

defined('_JEXEC') or die;

/* @var object $displayData Category object */

use Joomla\CMS\HTML\HTMLHelper;

?>
<a class="radicalmart-categories__item uk-display-block uk-inline-clip uk-card uk-overflow-hidden uk-link-reset uk-transition-toggle"
   href="<?php echo $displayData->link; ?>">
	<div class="uk-cover-container uk-height-medium uk-transition-scale-up uk-transition-opaque">
		<?php if ($icon = $displayData->media->get('image', $displayData->media->get('icon')))
		{
			echo HTMLHelper::image($icon, htmlspecialchars($displayData->title), array('uk-cover' => ''));
		}
		else
		{
			echo HTMLHelper::image('com_radicalmart/no-image.svg', htmlspecialchars($displayData->title),
				array('uk-cover' => ''), true);
		} ?>
	</div>
	<div class="uk-overlay uk-overlay-primary uk-light uk-position-bottom">
		<?php echo $displayData->title; ?>
	</div>
</a>