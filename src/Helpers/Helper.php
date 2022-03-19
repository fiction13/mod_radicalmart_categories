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

use Joomla\Registry\Registry;

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
        $childs = array();

        foreach ($this->categories as $item) {
            if (!in_array($item->parent_id, $this->params->get('exclude', [])))
            {
                $childs[$item->parent_id][$item->id] = $item;
            }
        }

        foreach ($this->categories as $item)
        {
            if (isset($childs[$item->id])) {
                $item->childs = $childs[$item->id];
            }
        }

        return array_shift($childs);
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
    function renderTree($categories, $level = 1, $wrapperTag = 'ul', $itemTag = 'li', $wrapperAttribs = [], $itemAttribs = [])
    {

        if ($level > (int) $this->params->get('level')) {
            return;
        }

        $ret = '<' . $wrapperTag . ' ' . (isset($wrapperAttribs[$level]) ? $this->buildAttrs($wrapperAttribs[$level]) : '') . '>';

        foreach ($categories as $index => $category)
        {
            if (isset($category->childs))
            {
                $ret .= '<' . $itemTag . ' ' . (isset($itemAttribs[$level]) ? $this->buildAttrs($itemAttribs[$level]) : '') . '><a href="#">' . $category->title . '</a>';
                $ret .= $this->renderTree($category->childs, $level + 1, $wrapperTag, $itemTag, $wrapperAttribs, $itemAttribs);
                $ret .= '</' . $itemTag . '>';
            }
            else
            {
                $ret .= '<' . $itemTag . '><a href="' . $category->link . '">' . $category->title . '</a></' . $itemTag . '>';
            }
        }
        return $ret . '</' . $wrapperTag . '>';
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

                $param  = (array)$param;
                $value  = implode(' ', $param);
                $value  = $this->cleanAttrValue($value);
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
    public function cleanAttrValue($value, $isTrim = true)
    {
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        return $value;
    }
}