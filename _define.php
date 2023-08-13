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
    '2023.08.13',
    [
        'requires'    => [['core', '2.27']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcCore::app()->auth::PERMISSION_ADMIN,
        ]),
        'settings' => [
            'blog' => '#params.' . basename(__DIR__) . '_params',
        ],
        'type'       => 'plugin',
        'support'    => 'https://git.dotclear.watch/JcDenis/' . basename(__DIR__) . '/issues',
        'details'    => 'https://git.dotclear.watch/JcDenis/' . basename(__DIR__) . '/src/branch/master/README.md',
        'repository' => 'https://git.dotclear.watch/JcDenis/' . basename(__DIR__) . '/raw/branch/master/dcstore.xml',
    ]
);
