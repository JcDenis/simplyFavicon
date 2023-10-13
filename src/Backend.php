<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Core\BlogSettings;
use Dotclear\Core\Process;
use Dotclear\Helper\File\Path;
use Dotclear\Helper\Html\Form\{
    Checkbox,
    Div,
    Label,
    Note,
    Para
};

/**
 * @brief   simplyFavicon backend class.
 * @ingroup simplyFavicon
 *
 * @author      Jean-Christian Denis
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class Backend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::behavior()->addBehaviors([
            'adminBlogPreferencesFormV2' => function (BlogSettings $blog_settings): void {
                if (!App::blog()->isDefined()) {
                    return;
                }

                $exists = [];
                $path   = Path::fullFromRoot((string) $blog_settings->get('system')->get('public_path'), App::config()->dotclearRoot());
                foreach (['ico', 'png', 'bmp', 'gif', 'jpg', 'mng'] as $ext) {
                    if (file_exists($path . '/favicon.' . $ext)) {
                        $url      = App::blog()->url() . App::url()->getURLFor('simplyFavicon', $ext);
                        $exists[] = '<li><a href="' . $url . '">' . $url . '</a></li>';
                    }
                }

                echo
                '<div class="fieldset clear"><h4 id="' . My::id() . '_params">' . __('Favicon') . '</h4>' .
                '<div class="two-cols"><div class="col">' .
                (new Div())
                    ->__call('class', ['box'])
                    ->__call('items', [[
                        (new Para())
                            ->__call('items', [[
                                (new Checkbox('simply_favicon', (bool) $blog_settings->get('system')->get('simply_favicon')))
                                    ->__call('value', ['1']),
                                (new Label(__('Enable favorite icon'), Label::OUTSIDE_LABEL_AFTER))
                                    ->__call('for', ['simply_favicon'])
                                    ->__call('class', ['classic']),
                            ]]),
                        (new Note())
                            ->__call('text', [__("You must place an image called favicon.png or .jpg or .ico into your blog's public directory.")])
                            ->__call('class', ['form-note']),
                    ]])
                    ->render() .
                '</p></div><div class="col">' .
                (
                    empty($exists) ?
                    '<p>' . __('There are no favicon in blog public directory') . '</p>' :
                    '<p>' . __('Current favicons:') . '</p><ul class="nice">' . implode($exists) . '</ul>'
                ) .
                '</div></div><br class="clear" /></div>';
            },
            'adminBeforeBlogSettingsUpdate' => function (BlogSettings $blog_settings): void {
                $blog_settings->get('system')->put('simply_favicon', !empty($_POST['simply_favicon']));
            },
        ]);

        return true;
    }
}
