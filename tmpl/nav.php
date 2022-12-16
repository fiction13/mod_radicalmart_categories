<?php
/*
 * @package   mod_radicalmart_categories
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

use Joomla\Module\RadicalmartCategories\Site\Helper\RadicalmartCategoriesHelper;

defined('_JEXEC') or die;

?>

<?php if (!empty($items)): ?>
    <div class="radicalmart-categories radicalmart-categories_nav <?php echo $moduleclass_sfx; ?>">
        <?php
           echo (new RadicalmartCategoriesHelper($params))->renderTree(
                $items,
                1,
                'ul',
                'li',
                [
                    1 => [
                        'class' => 'uk-nav'
                    ],
                    2 => [
                        'class' => 'uk-nav-sub'
                    ]
                ],
                [
                    1 => [
                        'class' => 'uk-parent'
                    ]
                ],
            );
        ?>
    </div>
<?php endif; ?>
