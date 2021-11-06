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

$this->registerModule(
    'Simply favicon',
    'Multi-agents favicon',
    'Jean-Christian Denis',
    '2021.09.02.1',
    [
        'requires'    => [['core', '2.19']],
        'permissions' => 'admin',
        'type'        => 'plugin',
        'support'     => 'https://github.com/JcDenis/simplyFavicon',
        'details'     => 'http://plugins.dotaddict.org/dc2/details/simplyFavicon',
        'repository'  => 'https://raw.githubusercontent.com/JcDenis/simplyFavicon/master/dcstore.xml',
        'settings'    => [
            'blog' => '#params.simply_favicon_params'
        ]
    ]
);
