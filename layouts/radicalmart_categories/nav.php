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

extract($displayData);

use Joomla\Module\RadicalMartCategories\Site\Helper\CategoriesHelper;

?>

<?php if (isset($category->child)): ?>
    <li class="nav-item">
        <a href="<?php echo $category->link; ?>" class="nav-link <?php echo $category->active ? 'active' : '' ?>">
			<?php echo $category->title; ?>
        </a>
        <ul class="nav flex-column ms-4">
			<?php echo (new CategoriesHelper($params))->renderTree($category->child, $level, 'nav'); ?>
        </ul>
    </li>
<?php else : ?>
    <li class="nav-item">
        <a href="<?php echo $category->link; ?>" class="nav-link <?php echo $category->active ? 'active' : '' ?>">
			<?php echo $category->title; ?>
        </a>
    </li>
<?php endif; ?>
