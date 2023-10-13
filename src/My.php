<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Module\MyPlugin;

/**
 * @brief   simplyFavicon My helper.
 * @ingroup simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class My extends MyPlugin
{
    protected static function checkCustomContext(int $context): ?bool
    {
        return match ($context) {
            // Limit BACKEND to admin
            self::BACKEND => App::task()->checkContext('BACKEND')
                && App::blog()->isDefined()
                && App::auth()->check(App::auth()->makePermissions([
                    App::auth()::PERMISSION_ADMIN,
                ]), App::blog()->id()),

            default => null,
        };
    }
}
