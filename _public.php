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
if (!defined('DC_RC_PATH')) {
    return;
}

dcCore::app()->addBehavior('publicHeadContent', ['publicSimplyFavicon', 'publicHeadContent']);

class publicSimplyFavicon extends dcUrlHandlers
{
    public static $mimetypes = [
        'ico' => 'image/x-icon',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'mng' => 'video/x-mng',
    ];

    public static function simplyFaviconUrl($arg)
    {
        $public_path = path::fullFromRoot(dcCore::app()->blog->settings->system->public_path, DC_ROOT);

        if (dcCore::app()->blog->settings->system->simply_favicon
            && !empty($arg)
            && array_key_exists($arg, self::$mimetypes)
            && file_exists($public_path . '/favicon.' . $arg)
        ) {
            header('Content-Type: ' . self::$mimetypes[$arg] . ';');
            readfile($public_path . '/favicon.' . $arg);
            exit;
        }

        self::p404();

        return null;
    }

    public static function publicHeadContent()
    {
        if (!dcCore::app()->blog->settings->system->simply_favicon) {
            return null;
        }

        $public_path = path::fullFromRoot(dcCore::app()->blog->settings->system->public_path, DC_ROOT) . '/favicon.';
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
            foreach (self::$mimetypes as $ext => $mime) {
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
    }
}
