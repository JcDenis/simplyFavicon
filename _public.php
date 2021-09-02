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

if (!defined('DC_RC_PATH')){
    return;
}

$core->addBehavior('publicHeadContent', ['publicSimplyFavicon', 'publicHeadContent']);

class publicSimplyFavicon extends dcUrlHandlers
{
    public static $mimetypes = array(
        'ico' => 'image/x-icon',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'mng' => 'video/x-mng'
    );

    public static function simplyFaviconUrl($arg)
    {
        global $core;

        $mimetypes = self::$mimetypes;
        $public_path = path::real(path::fullFromRoot($core->blog->settings->system->public_path, DC_ROOT)) . '/favicon.';

        if (!$core->blog->settings->system->simply_favicon 
         || empty($arg) 
         || !array_key_exists($arg, $mimetypes) 
         || file_exists($public_path . 'favicon' . $arg)
        ) {
            throw new Exception ("Page not found", 404); 
        }
        else {
            header('Content-Type: ' . $mimetypes[$arg] . ';');
            readfile($public_path . $arg);
            exit;
        }
    }

    public static function publicHeadContent($core)
    {
        if (!$core->blog->settings->system->simply_favicon){
            return;
        }

        $mimetypes = self::$mimetypes;
        $public_path = path::real(path::fullFromRoot($core->blog->settings->system->public_path, DC_ROOT)) . '/favicon.';
        $public_url = $core->blog->url.$core->url->getBase('simplyFavicon') . '.';

        // ico : IE6
        if (file_exists($public_path . 'ico') && '?' != substr($core->blog->url, -1)) {
            echo 
            '<link rel="SHORTCUT ICON" type="image/x-icon" href="' . $public_url . 'ico" />' . "\n";
        }
        // png: apple and others
        if (file_exists($public_path . 'png')) {
            echo 
            '<link rel="apple-touch-icon" href="' . $public_url . 'png" />' . "\n" .
            '<link rel="icon" type="image/png" href="' . $public_url . 'png" />' . "\n";
        }
        // all others
        else {
            foreach($mimetypes as $ext => $mime)
            {
                if (file_exists($public_path . $ext)) {
                    echo
                    '<link rel="icon" type="' . $mime . '" href="' . $public_url . $ext . '" />' . "\n";
                    break;
                }
            }
        }
    }
}