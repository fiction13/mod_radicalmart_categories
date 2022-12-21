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

use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

/* @var object $displayData Category object */

?>
<a class="radicalmart-categories__item uk-card uk-card-small uk-card-default uk-display-block uk-link-reset"
   href="<?php echo $displayData->link; ?>">
    <div class="uk-card-media-top uk-display-block uk-inline-clip uk-transition-toggle">
        <div class="uk-cover-container uk-height-medium uk-width-1-1 uk-transition-scale-up uk-transition-opaque ">
			<?php echo MediaHelper::renderImage(
				'mod_radicalmart_categories.grid',
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
    </div>
    <div class="uk-card-body uk-card-small">
        <h2 class="uk-card-title uk-margin-small-bottom"><?php echo $displayData->title; ?></h2>
    </div>
</a>