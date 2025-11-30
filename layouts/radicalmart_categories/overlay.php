<?php
/*
 * @package   mod_radicalmart_categories
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

\defined('_JEXEC') or die;

use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

/* @var object $displayData Category object */
?>
<a class="btn btn-outline-secondary d-block mb-3 text-decoration-none d-flex justify-content-center align-items-center text-center p-1"
   href="<?php echo $displayData->link; ?>" title="<?php echo $displayData->title; ?>" style="height: 250px"
   data-bs-toggle="tooltip">
	<?php echo MediaHelper::renderImage(
		'com_radicalmart.categories',
		$displayData->media->get('image', $displayData->media->get('icon')),
		[
			'alt'     => $displayData->title,
			'loading' => 'lazy',
			'style'   => 'max-width: 100%; max-height:100%;'
		],
		[
			'category_id' => $displayData->id,
			'no_image'    => true,
			'thumb'       => true,
		]); ?>
</a>