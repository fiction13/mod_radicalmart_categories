<?php
/*
 * @package   mod_radicalmart_categories
 * @version   2.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

\defined('_JEXEC') or die;

extract($displayData);

use Joomla\Module\RadicalMartCategories\Site\Helper\CategoriesHelper;

$id = uniqid('item-');

?>

<?php if (isset($category->child)): ?>
    <div id="<?php echo $id; ?>" class="list-group-item">
        <a href="<?php echo $category->link; ?>"
           class="list-group-heading text-decoration-none d-flex justify-content-between d-flex align-items-center <?php echo $category->active ? 'active' : ''; ?>">
            <div>
				<?php echo $category->title; ?>
            </div>
            <i class="fa fa-chevron-right" data-bs-toggle="collapse" role="button"
               data-bs-target="#<?php echo $id; ?> .collapse" onclick="event.preventDefault();"></i>
        </a>
        <div class="collapse <?php echo $category->active ? 'show' : ''; ?>">
            <div class="list-group mt-2">
				<?php echo (new CategoriesHelper($params))->renderTree($category->child, $level, 'accordion'); ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <a href="<?php echo $category->link; ?>" class="list-group-item list-group-heading <?php echo $category->active ? 'active' : ''; ?>">
		<?php echo $category->title; ?>
    </a>
<?php endif; ?>
