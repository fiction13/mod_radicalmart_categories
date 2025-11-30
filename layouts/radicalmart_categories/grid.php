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

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

/* @var object $displayData Category object */

?>
<a class="card d-block mb-3 text-decoration-none" href="<?php echo $displayData->link; ?>">
    <div class="card-img-top bg-light d-flex justify-content-center align-items-center text-center p-1"
         style="height: 250px">
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
    </div>
    <div class="card-body">
        <h2 class="card-title h5 link-dark"><?php echo $displayData->title; ?></h2>
        <div class="card-text">
			<?php echo Text::_('COM_RADICALMART_PRODUCTS_LIST'); ?>
        </div>
    </div>
</a>