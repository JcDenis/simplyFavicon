<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Helper\Process\TraitProcess;
use Dotclear\Helper\File\Path;

/**
 * @brief       simplyFavicon frontend class.
 * @ingroup     simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class Frontend
{
    use TraitProcess;

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
            if (!App::blog()->isDefined() || !My::settings()->get('active')) {
                return;
            }

            $public_path = Path::fullFromRoot(App::blog()->settings()->get('system')->getStr('public_path', false), App::config()->dotclearRoot()) . '/favicon.';
            $public_url  = App::blog()->url() . App::url()->getBase('simplyFavicon') . '.';

            // Declare every existing favicon, browsers pick the one they support
            foreach (My::MIME_TYPES as $ext => $mime) {
                if (!file_exists($public_path . $ext)) {
                    continue;
                }

                $href = $public_url . $ext;
                if ($ext === 'ico') {
                    echo '<link rel="icon" href="' . $href . '" sizes="any">' . "\n";
                } else {
                    echo '<link rel="icon" type="' . $mime . '" href="' . $href . '">' . "\n";
                }
                if ($ext === 'png') {
                    echo '<link rel="apple-touch-icon" href="' . $href . '">' . "\n";
                }
            }
        });

        return true;
    }
}
