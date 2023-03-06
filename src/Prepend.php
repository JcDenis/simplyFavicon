<?php
/**
 * @brief simplyFavicon, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Jean-Christian Denis
 *
 * @copyright Jean-Christian Denis
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return;
}

Clearbricks::lib()->autoload(['publicSimplyFavicon' => __DIR__ . '/_public.php']);

dcCore::app()->url->register('simplyFavicon', 'favicon', '^favicon.(.*?)$', ['publicSimplyFavicon', 'simplyFaviconUrl']);
