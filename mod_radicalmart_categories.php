<?php
/*
 * @package   mod_radicalmart_categories
 * @version   1.1.4
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

\JLoader::register('RadicalMartHelperIntegration', JPATH_ADMINISTRATOR . '/components/com_radicalmart/helpers/integration.php');
\JLoader::register('modRadicalMartCategoriesHelper', __DIR__ . '/src/Helpers/Helper.php');

RadicalMartHelperIntegration::initializeSite();

BaseDatabaseModel::addIncludePath(JPATH_SITE . '/components/com_radicalmart/models');
$model = BaseDatabaseModel::getInstance('Categories', 'RadicalMartModel', array('ignore_request' => true));
$level = 0;

$model->setState('params', Factory::getApplication()->getParams());
$model->setState('filter.published', 1);
$model->setState('filter.limit', (int) $params->get('limit'));

// Set language filter state
$model->setState('filter.language', Multilanguage::isEnabled());

if ($params->get('parent') != 1)
{
    $model->setState('category.id', (int) $params->get('parent'));
}

// Check exclude
if ($params->get('exclude'))
{
    $model->setState('filter.item_id', $params->get('exclude'));
    $model->setState('filter.item_id.include', false);
}

// Get categories
$items = $model->getItems();

// Get category tree
$helper = new modRadicalMartCategoriesHelper($params);

$helper->setCategories($items);

$items = $helper->buildTree();

// Suffix
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

require ModuleHelper::getLayoutPath($module->module, $params->get('layout', 'grid'));
