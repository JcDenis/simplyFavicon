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
    '2023.07.29',
    [
        'requires'    => [['core', '2.27']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcCore::app()->auth::PERMISSION_ADMIN,
        ]),
        'type'       => 'plugin',
        'support'    => 'https://github.com/JcDenis/' . basename(__DIR__),
        'details'    => 'http://plugins.dotaddict.org/dc2/details/' . basename(__DIR__),
        'repository' => 'https://raw.githubusercontent.com/JcDenis/' . basename(__DIR__) . '/master/dcstore.xml',
        'settings'   => [
            'blog' => '#params.simply_favicon_params',
        ],
    ]
);
