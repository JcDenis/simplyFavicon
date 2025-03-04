<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Core\Frontend\Url;
use Dotclear\Helper\File\Path;

/**
 * @brief       simplyFavicon frontend URL handler.
 * @ingroup     simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class FrontendUrl extends Url
{
    public static function simplyFaviconUrl(string $arg): void
    {
        if (!App::blog()->isDefined()) {
            return;
        }

        $public_path = Path::fullFromRoot(App::blog()->settings()->get('system')->get('public_path'), App::config()->dotclearRoot());

        if (App::blog()->settings()->get('system')->get('simply_favicon')
            && !empty($arg)
            && array_key_exists($arg, My::MIME_TYPES)
            && file_exists($public_path . '/favicon.' . $arg)
        ) {
            header('Content-Type: ' . My::MIME_TYPES[$arg] . ';');
            readfile($public_path . '/favicon.' . $arg);
            exit;
        }

        self::p404();
    }
}
