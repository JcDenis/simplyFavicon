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
use dcSettings;
use Dotclear\Helper\File\Path;
use Dotclear\Helper\Html\Form\{
    Checkbox,
    Div,
    Label,
    Note,
    Para
};

class Backend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = defined('DC_CONTEXT_ADMIN');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->addBehaviors([
            'adminBlogPreferencesFormV2' => function (dcSettings $blog_settings): void {
                // nullsafe
                if (is_null(dcCore::app()->blog)) {
                    return;
                }

                $exists = [];
                $path   = Path::fullFromRoot((string) $blog_settings->get('system')->get('public_path'), DC_ROOT);
                foreach (['ico', 'png', 'bmp', 'gif', 'jpg', 'mng'] as $ext) {
                    if (file_exists($path . '/favicon.' . $ext)) {
                        $url      = dcCore::app()->blog->url . dcCore::app()->url->getURLFor('simplyFavicon', $ext);
                        $exists[] = '<li><a href="' . $url . '">' . $url . '</a></li>';
                    }
                }

                echo
                '<div class="fieldset clear"><h4 id="simply_favicon_params">' . __('Favicon') . '</h4>' .
                '<div class="two-cols"><div class="col">' .
                (new Div())->class('box')->items([
                    (new Para())->items([
                        (new Checkbox('simply_favicon', (bool) $blog_settings->get('system')->get('simply_favicon')))->value('1'),
                        (new Label(__('Enable favorite icon'), Label::OUTSIDE_LABEL_AFTER))->for('simply_favicon')->class('classic'),
                    ]),
                    (new Note())->text(__("You must place an image called favicon.png or .jpg or .ico into your blog's public directory."))->class('form-note'),
                ])->render() .
                '</p></div><div class="col">' .
                (
                    empty($exists) ?
                    '<p>' . __('There are no favicon in blog public directory') . '</p>' :
                    '<p>' . __('Current favicons:') . '</p><ul class="nice">' . implode($exists) . '</ul>'
                ) .
                '</div></div><br class="clear" /></div>';
            },
            'adminBeforeBlogSettingsUpdate' => function (dcSettings $blog_settings): void {
                $blog_settings->get('system')->put('simply_favicon', !empty($_POST['simply_favicon']));
            },
        ]);

        return true;
    }
}
