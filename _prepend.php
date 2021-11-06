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

$__autoload['publicSimplyFavicon'] = dirname(__FILE__) . '/_public.php';

$core->url->register('simplyFavicon', 'favicon', '^favicon.(.*?)$', ['publicSimplyFavicon', 'simplyFaviconUrl']);
