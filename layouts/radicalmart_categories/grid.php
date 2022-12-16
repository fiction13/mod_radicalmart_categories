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

use Joomla\CMS\HTML\HTMLHelper;

/* @var object $displayData Category object */

?>
<a class="radicalmart-categories__item uk-card uk-card-small uk-card-default uk-display-block uk-link-reset"
   href="<?php echo $displayData->link; ?>">
	<div class="uk-card-media-top uk-display-block uk-inline-clip uk-transition-toggle">
		<div class="uk-cover-container uk-height-medium uk-width-1-1 uk-transition-scale-up uk-transition-opaque ">
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
	</div>
	<div class="uk-card-body uk-card-small">
		<h2 class="uk-card-title uk-margin-small-bottom"><?php echo $displayData->title; ?></h2>
	</div>
</a>