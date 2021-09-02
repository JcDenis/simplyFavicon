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

if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

$core->addBehavior('adminBlogPreferencesForm', ['adminSimplyFavicon', 'adminBlogPreferencesForm']);
$core->addBehavior('adminBeforeBlogSettingsUpdate', ['adminSimplyFavicon', 'adminBeforeBlogSettingsUpdate']);

class adminSimplyFavicon
{
    public static function adminBlogPreferencesForm($core, $blog_settings)
    {
        echo
        '<div class="fieldset"><h4 id="simply_favicon_params">Favicon</h4>' .
        '<p><label class="classic">' .
        form::checkbox('simply_favicon', '1', (boolean) $blog_settings->system->simply_favicon) . 
        __('Enable "Simply favicon" extension') . '</label></p>' .
        '<p class="form-note">' .
        __("You must place an image called favicon.png or .jpg or .ico into your blog's public directory.") .
        '</p>' .
        '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate($blog_settings)
    {
        $blog_settings->system->put('simply_favicon', !empty($_POST['simply_favicon']));
    }
}