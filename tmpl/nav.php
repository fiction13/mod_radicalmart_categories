<?php
/*
 * @package   mod_radicalmart_categories
 * @version   1.1.3
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

defined('_JEXEC') or die;

?>

<?php if (!empty($items)): ?>
    <div class="radicalmart-categories radicalmart-categories_nav <?php echo $moduleclass_sfx; ?>">
        <?php
            echo $helper->renderTree(
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
