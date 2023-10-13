<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Core\Process;
use Dotclear\Helper\File\Path;

/**
 * @brief   simplyFavicon frontend class.
 * @ingroup simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::behavior()->addBehavior('publicHeadContent', function (): void {
            if (!App::blog()->isDefined() || !App::blog()->settings()->get('system')->get('simply_favicon')) {
                return;
            }

            $public_path = Path::fullFromRoot(App::blog()->settings()->get('system')->get('public_path'), App::config()->dotclearRoot()) . '/favicon.';
            $public_url  = App::blog()->url() . App::url()->getBase('simplyFavicon') . '.';

            // ico : IE6
            if (file_exists($public_path . 'ico') && '?' != substr(App::blog()->url(), -1)) {
                echo
                '<link rel="SHORTCUT ICON" type="image/x-icon" href="' . $public_url . 'ico" />' . "\n";
            }
            // png: apple and others
            if (file_exists($public_path . 'png')) {
                echo
                '<link rel="apple-touch-icon" href="' . $public_url . 'png" />' . "\n" .
                '<link rel="icon" type="image/png" href="' . $public_url . 'png" />' . "\n";
                // all others
            } else {
                foreach (UrlHandler::$mimetypes as $ext => $mime) {
                    if (in_array($ext, ['ico', 'png'])) {
                        continue;
                    }
                    if (file_exists($public_path . $ext)) {
                        echo
                        '<link rel="icon" type="' . $mime . '" href="' . $public_url . $ext . '" />' . "\n";

                        break;
                    }
                }
            }
        });

        return true;
    }
}
