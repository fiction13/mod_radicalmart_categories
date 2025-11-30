<?php
/*
 * @package   mod_radicalmart_categories
 * @version   2.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

?>

<?php if (!empty($items)): ?>
    <div class="radicalmart-categories radicalmart-categories_overlay row row-cols-md-2 row-cols-lg-3">
		<?php foreach ($items as $item) : ?>
            <div class="item-<?php echo $item->id; ?>">
				<?php echo LayoutHelper::render('modules.radicalmart_categories.overlay', $item); ?>
            </div>
		<?php endforeach; ?>
    </div>
<?php endif; ?>