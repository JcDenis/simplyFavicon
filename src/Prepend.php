<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Core\Process;

/**
 * @brief       simplyFavicon prepend class.
 * @ingroup     simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class Prepend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::PREPEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::url()->register(
            'simplyFavicon',
            'favicon',
            '^favicon.(.*?)$',
            UrlHandler::simplyFaviconUrl(...)
        );

        return true;
    }
}
