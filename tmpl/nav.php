<?php
/*
 * @package   mod_radicalmart_categories
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

use Joomla\Module\RadicalMartCategories\Site\Helper\CategoriesHelper;

defined('_JEXEC') or die;

?>

<?php if (!empty($items)): ?>
    <div class="radicalmart-categories radicalmart-categories_nav <?php echo $moduleclass_sfx; ?>">
        <ul class="nav flex-column">
			<?php echo (new CategoriesHelper($params))->renderTree($items, 1, 'nav'); ?>
        </ul>
    </div>
<?php endif; ?>
