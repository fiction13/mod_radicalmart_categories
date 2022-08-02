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

use Joomla\Registry\Registry;
use Joomla\CMS\Factory;

/**
 * @package     pkg_radicalmicro
 *
 * @since       1.0.0
 */
class modRadicalMartCategoriesHelper
{
    /**
     * @var array
     *
     * @since 1.0.0
     */
    protected $params = [];


    /**
     * @var array
     *
     * @since 1.1.1
     */
    protected $tree = [];

    /**
     * @param Registry $params
     *
     * @throws Exception
     */
    public function __construct(Registry $params)
    {
        $this->params = $params;
    }

    /**
     * @param $categories
     *
     *
     * @since 1.1.0
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     *
     * @return mixed|null
     *
     * @since 1.1.0
     */
    function buildTree()
    {
        if (!$this->tree)
        {
            $childs = array();

            foreach ($this->categories as $item)
            {
                if (!in_array($item->parent_id, $this->params->get('exclude', [])))
                {
                    $childs[$item->parent_id][$item->id] = $item;
                }
            }

            foreach ($this->categories as $item)
            {
                if (isset($childs[$item->id]))
                {
                    $item->childs = $childs[$item->id];
                }
            }

            $this->tree = array_shift($childs);
        }

        return $this->tree;
    }

    /**
     * @param $categories
     * @param int $level
     * @param string $wrapperTag
     * @param string $itemTag
     * @param array $wrapperAttribs
     * @param array $itemAttribs
     *
     * @return string|void
     *
     * @since 1.1.0
     */
    function renderTree($categories, $level = 1, $wrapperTag = 'ul', $itemTag = 'li', $wrapperAttribs = [], $itemAttribs = [], $activeClass = 'uk-active', $openClass = 'uk-open', $triggerElement = '')
    {
        if ($level > (int)$this->params->get('level'))
        {
            return;
        }

        $result = '<' . $wrapperTag . ' ' . $this->renderAttribs($wrapperAttribs, $level) . '>';

        foreach ($categories as $index => $category)
        {
            if (isset($category->childs))
            {
                $result .= '<' . $itemTag . ' ' . $this->renderAttribs($itemAttribs, $level, $category, $activeClass, $openClass) . '>';
                $result .= '<a href="' . $category->link . '">' . $category->title . $triggerElement . '</a>';
                $result .= $this->renderTree($category->childs, $level + 1, $wrapperTag, $itemTag, $wrapperAttribs, $itemAttribs);
                $result .= '</' . $itemTag . '>';
            }
            else
            {
                $result .= '<' . $itemTag . ' ' . $this->renderAttribs([], $level, $category, $activeClass) . '><a href="' . $category->link . '">' . $category->title . '</a></' . $itemTag . '>';
            }
        }
        return $result . '</' . $wrapperTag . '>';
    }


    /**
     * @param $attribs          Array of attribs
     * @param $level            Category level
     * @param null $category    Category object
     * @param null $activeClass
     * @param null $openClass
     *
     * @return string
     *
     * @since version
     */
    public function renderAttribs($attribs, $level, $category = null, $activeClass = null, $openClass = null)
    {
        $result = [];

        // Check level attribs
        if (isset($attribs[$level]))
        {
            $result = $attribs[$level];
        }

        // Check active category
        if ($category && $this->checkActive((int) $category->id))
        {
            if (isset($result['class']))
            {
                $result['class'] .= ' ' . $activeClass;
            }
            else
            {
                $result['class'] = $activeClass;
            }
        }

        // Check open category
        if ($category && $this->checkOpen($category, $level))
        {
            if (isset($result['class']))
            {
                $result['class'] .= ' ' . $openClass;
            }
            else
            {
                $result['class'] = $openClass;
            }
        }

        // Check result
        if ($result)
        {
            return $this->buildAttrs($result);
        }

        return '';
    }

    /**
     * @param $attrs
     *
     * @return string
     *
     * @since 1.1.0
     */
    protected function buildAttrs($attrs)
    {
        $result = ' ';

        if (is_string($attrs))
        {
            $result .= $attrs;

        }
        elseif (!empty($attrs))
        {
            foreach ($attrs as $key => $param)
            {
                $param = (array)$param;
                $value = implode(' ', $param);
                $value = $this->cleanAttrValue($value);
                $result .= ' ' . $key . '="' . $value . '"';
            }
        }

        return trim($result);
    }

    /**
     * @param $value
     *
     * @return string
     *
     * @since 1.1.0
     */
    public function cleanAttrValue($value)
    {
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        return $value;
    }

    /**
     * @param $id
     *
     * @return bool
     *
     * @since 1.1.1
     */
    public function checkActive($id)
    {
        $input = Factory::getApplication()->input;

        if ($input->getString('option') == 'com_radicalmart' && $input->getString('view') == 'category' && $input->getInt('id') === $id)
        {
            return true;
        }

        return false;
    }

    /**
     * @param $id
     *
     * @return bool
     *
     * @since 1.1.1
     */
    public function checkOpen($category, $level)
    {
        $input = Factory::getApplication()->input;

        if (
            $input->getString('option') == 'com_radicalmart' &&
            $input->getString('view') == 'category' &&
            $level === 1 &&
            isset($category->childs) &&
            (isset($category->childs[$input->getInt('id')]) || (int) $category->id === $input->getInt('id'))
        ) {
            return true;
        }

        return false;
    }
}