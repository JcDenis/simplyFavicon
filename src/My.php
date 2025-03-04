<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\Module\MyPlugin;

/**
 * @brief       simplyFavicon My helper.
 * @ingroup     simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class My extends MyPlugin
{
    /**
     * Mime types.
     *
     * @var     array<string, string> MIME_TYPES
     */
    public const MIME_TYPES = [
        'ico' => 'image/x-icon',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'mng' => 'video/x-mng',
    ];

    // Use default permissions
}
