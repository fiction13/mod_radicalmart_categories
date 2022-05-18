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
    <div class="radicalmart-categories radicalmart-categories_accordion <?php echo $moduleclass_sfx; ?>">
        <?php
            echo $helper->renderTree(
                $items,
                1,
                'ul',
                'li',
                [
                    1 => [
                        'class'  => 'uk-nav-default uk-nav',
                        'uk-nav' => 'toggle: > a > i'
                    ],
                    2 => [
                        'class' => 'uk-nav-sub',
                        'hidden' => ''
                    ]
                ],
                [
                    1 => [
                        'class' => 'uk-parent'
                    ]
                ],
                'uk-active',
                'uk-open',
                '<i uk-icon="chevron-down" class="uk-margin-auto-left"></i>',
            );
        ?>
    </div>
<?php endif; ?>
