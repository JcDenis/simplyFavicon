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
declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use dcCore;
use dcNsProcess;
use Dotclear\Helper\File\Path;

class Frontend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = defined('DC_RC_PATH');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->addBehavior('publicHeadContent', function (): void {
            if (!dcCore::app()->blog->settings->get('system')->get('simply_favicon')) {
                return;
            }

            $public_path = Path::fullFromRoot(dcCore::app()->blog->settings->get('system')->get('public_path'), DC_ROOT) . '/favicon.';
            $public_url  = dcCore::app()->blog->url . dcCore::app()->url->getBase('simplyFavicon') . '.';

            // ico : IE6
            if (file_exists($public_path . 'ico') && '?' != substr(dcCore::app()->blog->url, -1)) {
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
