<?php
/*
 * @package   mod_radicalmart_categories
 * @version   2.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2022 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

namespace Joomla\Module\RadicalMartCategories\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\RadicalMart\Site\Helper\RouteHelper;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\CMS\Factory;

/**
 * @package     Helper class
 *
 * @since       1.2.0
 */
class CategoriesHelper
{
	/**
	 * @var array
	 *
	 * @since 1.0.0
	 */
	protected $params = [];


	/**
	 * @var int
	 *
	 * @since 1.1.1
	 */
	public static $level = 1;


	/**
	 * @param   Registry  $params
	 *
	 * @since 1.2.0
	 */
	public function __construct(Registry $params)
	{
		$this->params = $params;
	}

	/**
	 * Method for get categories tree
	 *
	 * @since 1.2.0
	 */
	public function getTreeItems()
	{
		// Get categories
		$categories = $this->getCategories();

		// Check admin type view
		$app            = Factory::getApplication();
		$input          = $app->getInput();
		$component      = $input->get('option', 'com_radicalmart');
		$view           = $input->get('view', 'category');
		$id             = $input->getInt('id', 0);
		$activeCategory = $id ?: $input->getInt('category');
		$sameView       = $component == 'com_radicalmart' && ($view == 'category' || $view == 'product');
		$tree           = $this->buildTree($categories, (int) $this->params->get('parent', 1), $sameView, $activeCategory);

		return $tree;
	}

	/**
	 * Method for get categories
	 *
	 * @since 1.2.0
	 */
	public function getCategories()
	{
		// Get items
		$db = Factory::getContainer()->get('DatabaseDriver');;
		$query = $db->getQuery(true)
			->select(['c.id', 'c.parent_id', 'c.level', 'c.title', 'c.alias',
				'c.type', 'c.introtext', 'c.media', 'c.plugins', 'c.language', 'c.totals'])
			->from($db->quoteName('#__radicalmart_categories', 'c'))
			->where($db->quoteName('c.alias') . '!=' . $db->quote('root'))
			->whereIn('c.state', [1])
			->order($db->escape('c.lft') . ' ' . $db->escape('asc'));

		// Filter by language
		if (Multilanguage::isEnabled())
		{
			$query->whereIn('c.language', [Factory::getApplication()->getLanguage()->getTag(), '*'],
				ParameterType::STRING);
		}

		// Filter by mode
		if ($this->params->get('mode') === 'parent')
		{
			if ($this->params->get('exclude')) $query->whereNotIn('c.id', $this->params->get('exclude'));
		}
		else
		{
			if ($this->params->get('custom')) $query->whereIn('c.id', $this->params->get('custom'));
		}

		$items = $db->setQuery($query)->loadObjectList();

		return $items;
	}

	/**
	 * Method for build categories tree
	 *
	 * @param   array     $items           Categories array
	 * @param   int       $parentId        Parent category id
	 * @param   bool      $sameView        Is current category
	 * @param   int       $id              Category id
	 * @param   bool|int  $activeCategory  Active category id or false
	 *
	 * @since 1.2.0
	 */
	public function buildTree(array $items, $parentId = 1, $sameView = false, $id = 1, $activeCategory = false)
	{
		$tree = [];

		foreach ($items as $item)
		{
			if ($item->level > (int) $this->params->get('level')) continue;
			if ($activeCategory || ($sameView && $item->id == $id)) $item->active = true;

			// Add item for custom mode forever
			$addItem = false;
			if ($this->params->get('mode') === 'custom') $addItem = true;


			// Only for parent mode
			if ($item->parent_id == $parentId && $this->params->get('mode') === 'parent')
			{
				$item->active = $item->active ?? false;
				$child        = $this->buildTree($items, $item->id, $sameView, $id, $activeCategory ?: false);
				if ($child)
				{
					$item->child  = $child;
					$item->active = $item->active || in_array(true, array_column($child, 'active'));

					self::$level++;
				}

				$addItem = true;
			}

			// Set item data
			if ($addItem)
			{
				$item->slug    = $item->id . ':' . $item->alias;
				$item->link    = Route::link('site',
					RouteHelper::getCategoryViewRoute($item->slug, $item->language));
				$item->media   = new Registry($item->media);
				$item->plugins = new Registry($item->plugins);
				$item->totals  = new Registry($item->totals);

				$tree[] = $item;
			}
		}

		return $tree;
	}

	/**
	 * @param   array   $categories  Categories array
	 * @param   int     $level       Category evel
	 * @param   string  $layout      Category layout
	 *
	 * @return string|void
	 *
	 * @since 1.1.0
	 */
	public function renderTree($categories, $level = 1, $layout = 'accordion')
	{
		$result = [];
		foreach ($categories as $index => $category)
		{
			$result[] = LayoutHelper::render('modules.radicalmart_categories.' . $layout, ['category' => $category, 'level' => $level + 1, 'params' => $this->params]);
		}

		return implode("\n", $result);
	}
}