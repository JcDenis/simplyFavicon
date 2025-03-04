<?php
/**
 * @file
 * @brief       The simplyFavicon pacKman definition
 * @ingroup     simplyFavicon
 *
 * @defgroup    simplyFavicon Plugin simplyFavicon.
 *
 * Multi-agents favicon.
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

$this->registerModule(
    'Simply favicon',
    'Multi-agents favicon',
    'Jean-Christian Denis',
    '2025.03.04',
    [
        'requires'    => [['core', '2.33']],
        'permissions' => 'My',
        'settings'    => ['blog' => '#params.' . $this->id . '_params'],
        'type'        => 'plugin',
        'support'     => 'https://github.com/JcDenis/' . $this->id . '/issues',
        'details'     => 'https://github.com/JcDenis/' . $this->id . '/',
        'repository'  => 'https://raw.githubusercontent.com/JcDenis/' . $this->id . '/master/dcstore.xml',
        'date'        => '2025-03-02T19:28:05+00:00',
    ]
);
