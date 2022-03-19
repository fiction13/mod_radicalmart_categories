<?php
/*
 * @package   mod_radicalmart_categories
 * @version   1.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

\JLoader::register('RadicalMartHelperIntegration', JPATH_ADMINISTRATOR . '/components/com_radicalmart/helpers/integration.php');
\JLoader::register('modRadicalMartCategoriesHelper', __DIR__ . '/src/Helpers/Helper.php');

RadicalMartHelperIntegration::initializeSite();

BaseDatabaseModel::addIncludePath(JPATH_SITE . '/components/com_radicalmart/models');
$model = BaseDatabaseModel::getInstance('Categories', 'RadicalMartModel', array('ignore_request' => true));
$level = 0;

$model->setState('params', Factory::getApplication()->getParams());
$model->setState('filter.category.id', (int)$params->get('parent'));
$model->setState('filter.published', 1);
$model->setState('filter.limit', (int)$params->get('limit'));

// Check exclude
if ($params->get('exclude')) {
    $model->setState('filter.item_id', $params->get('exclude'));
    $model->setState('filter.item_id.include', false);
}

// Get categories
$allCategories = $model->getItems();

// Get full category object
if ($allCategories) {
    $items = [];
    $modelCategory = BaseDatabaseModel::getInstance('Category', 'RadicalMartModel', array('ignore_request' => true));
    $modelCategory->setState('params', Factory::getApplication()->getParams());

    foreach ($allCategories as $key => $category) {
        $items[] = $modelCategory->getItem($category->id);
    }
}

// Get category tree
$helper = new modRadicalMartCategoriesHelper($params);

$helper->setCategories($items);

$items = $helper->buildTree();

// Suffix
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

require ModuleHelper::getLayoutPath($module->module, $params->get('layout', 'grid'));
