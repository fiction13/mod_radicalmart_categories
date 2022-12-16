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

use Joomla\CMS\Layout\LayoutHelper;
?>

<?php if (!empty($items)): ?>
    <div class="radicalmart-categories radicalmart-categories_overlay <?php echo $moduleclass_sfx; ?>">
        <div class="radicalmart-categories__list uk-grid-divider uk-grid-medium" uk-grid
             uk-height-match="target: > div > .uk-card >.uk-card-body,> div > .uk-card >.uk-card-footer > .uk-grid; row:false">
            <?php foreach ($items as $i => $item): ?>
                <div class="uk-width-1-<?php echo $params->get('cols'); ?>@s">
                    <?php echo LayoutHelper::render('modules.radicalmart_categories.overlay',
                        $item); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
