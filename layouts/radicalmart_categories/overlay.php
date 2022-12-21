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

use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

?>
<a class="radicalmart-categories__item uk-display-block uk-inline-clip uk-card uk-overflow-hidden uk-link-reset uk-transition-toggle"
   href="<?php echo $displayData->link; ?>">
    <div class="uk-cover-container uk-height-medium uk-transition-scale-up uk-transition-opaque">
		<?php echo MediaHelper::renderImage(
			'mod_radicalmart_categories.overlay',
			$displayData->media->get('image', $displayData->media->get('icon')),
			[
				'alt'      => $displayData->title,
				'loading'  => 'lazy',
				'uk-cover' => ''
			],
			[
				'category_id' => $displayData->id,
				'no_image'    => true,
				'thumb'       => true,
			]); ?>
    </div>
    <div class="uk-overlay uk-overlay-primary uk-light uk-position-bottom">
		<?php echo $displayData->title; ?>
    </div>
</a>