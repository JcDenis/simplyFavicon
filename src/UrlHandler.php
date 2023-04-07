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
use dcUrlHandlers;
use Dotclear\Helper\File\Path;

class UrlHandler extends dcUrlHandlers
{
    public static array $mimetypes = [
        'ico' => 'image/x-icon',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'mng' => 'video/x-mng',
    ];

    public static function simplyFaviconUrl(string $arg): void
    {
        $public_path = Path::fullFromRoot(dcCore::app()->blog->settings->get('system')->get('public_path'), DC_ROOT);

        if (dcCore::app()->blog->settings->get('system')->get('simply_favicon')
            && !empty($arg)
            && array_key_exists($arg, self::$mimetypes)
            && file_exists($public_path . '/favicon.' . $arg)
        ) {
            header('Content-Type: ' . self::$mimetypes[$arg] . ';');
            readfile($public_path . '/favicon.' . $arg);
            exit;
        }

        self::p404();
    }
}
