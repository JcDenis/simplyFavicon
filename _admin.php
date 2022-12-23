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

dcCore::app()->addBehavior('adminBlogPreferencesFormV2', function ($blog_settings) {
    $exists = [];
    $path   = path::fullFromRoot((string) $blog_settings->get('system')->get('public_path'), DC_ROOT);
    foreach (['ico', 'png', 'bmp', 'gif', 'jpg', 'mng'] as $ext) {
        if (file_exists($path . '/favicon.' . $ext)) {
            $exists[] = sprintf('<li title="%s">%s</li>', $path . '/favicon.' . $ext, 'favicon.' . $ext);
        }
    }

    echo
    '<div class="fieldset clear"><h4 id="simply_favicon_params">' . __('Favicon') . '</h4>' .
    '<div class="two-cols"><div class="col">' .
    '<p><label class="classic">' .
    form::checkbox('simply_favicon', '1', (bool) $blog_settings->get('system')->get('simply_favicon')) .
    __('Enable "Simply favicon" extension') . '</label></p>' .
    '<p class="form-note">' .
    __("You must place an image called favicon.png or .jpg or .ico into your blog's public directory.") .
    '</p></div><div class="col">' .
    (
        empty($exists) ?
        '<p>' . __('There are no favicon in blog public directory') . '</p>' :
        '<p>' . __('Current favicons:') . '</p><ul class="nice">' . implode($exists) . '</ul>'
    ) .
    '</div></div><br class="clear" /></div>';
});

dcCore::app()->addBehavior('adminBeforeBlogSettingsUpdate', function ($blog_settings) {
    $blog_settings->get('system')->put('simply_favicon', !empty($_POST['simply_favicon']));
});
