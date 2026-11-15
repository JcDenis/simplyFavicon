<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Database\Statement\UpdateStatement;
use Dotclear\Helper\Process\TraitProcess;
use Exception;

/**
 * @brief       simplyFavicon install class.
 * @ingroup     simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class Install
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::INSTALL));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        try {
            // Move setting from system namespace to module namespace, for all blogs
            $sql = new UpdateStatement();
            $sql
                ->ref(App::db()->con()->prefix() . App::blogWorkspace()::NS_TABLE_NAME)
                ->set([
                    'setting_ns = ' . $sql->quote(My::id()),
                    'setting_id = ' . $sql->quote('active'),
                ])
                ->where('setting_ns = ' . $sql->quote('system'))
                ->and('setting_id = ' . $sql->quote('simply_favicon'))
                ->update();

            return true;
        } catch (Exception $e) {
            App::error()->add($e->getMessage());

            return false;
        }
    }
}
