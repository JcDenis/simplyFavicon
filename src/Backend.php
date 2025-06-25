<?php

declare(strict_types=1);

namespace Dotclear\Plugin\simplyFavicon;

use Dotclear\App;
use Dotclear\Core\Process;
use Dotclear\Helper\File\Path;
use Dotclear\Helper\Html\Form\{
    Checkbox,
    Div,
    Fieldset,
    Img,
    Label,
    Legend,
    Li,
    Link,
    None,
    Note,
    Para,
    Text,
    Ul
};
use Dotclear\Interface\Core\BlogSettingsInterface;

/**
 * @brief       simplyFavicon backend class.
 * @ingroup     simplyFavicon
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
            'adminBlogPreferencesFormV2' => function (BlogSettingsInterface $blog_settings): void {
                if (!App::blog()->isDefined()) {
                    return;
                }

                $exists = [];
                $path   = Path::fullFromRoot((string) $blog_settings->get('system')->get('public_path'), App::config()->dotclearRoot());
                foreach (['ico', 'png', 'bmp', 'gif', 'jpg', 'mng'] as $ext) {
                    if (file_exists($path . '/favicon.' . $ext)) {
                        $url      = App::blog()->url() . App::url()->getURLFor('simplyFavicon', $ext);
                        $exists[] = (new Li())
                            ->items([
                                (new Link())
                                    ->href($url)
                                    ->text($url)
                            ]);
                    }
                }

                echo (new Fieldset(My::id() . '_params'))
                    ->legend((new Legend((new Img(My::icons()[0]))->class('icon-small')->render() . ' ' . __('Favicon'))))
                    ->items([
                        (new Div())
                            ->class('two-boxes')
                            ->items([
                                (new Para())
                                    ->items([
                                        (new Checkbox('simply_favicon', (bool) $blog_settings->get('system')->get('simply_favicon')))
                                            ->value('1'),
                                        (new Label(__('Enable favorite icon'), Label::OUTSIDE_LABEL_AFTER))
                                            ->for('simply_favicon')
                                            ->class('classic'),
                                    ]),
                                (new Note())
                                    ->text(__("You must place an image called favicon.png or .jpg or .ico into your blog's public directory."))
                                    ->class('form-note'),
                            ]),
                        (new Div())
                            ->class('box')
                            ->items([
                                (empty($exists) ? (new Text('p', __('There are no favicon in blog public directory'))) :
                                    (new Div())
                                        ->items([
                                            (new Text('p', __('Current favicons:'))),
                                            (new Ul())
                                                ->class('nice')
                                                ->items($exists),
                                        ])
                                )
                            ]),

                    ])
                    ->render();
            },
            'adminBeforeBlogSettingsUpdate' => function (BlogSettingsInterface $blog_settings): void {
                $blog_settings->get('system')->put('simply_favicon', !empty($_POST['simply_favicon']));
            },
        ]);

        return true;
    }
}
