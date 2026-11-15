# simplyFavicon

Notes for AI assistants working on the Dotclear plugin simplyFavicon.

**Read first** the shared conventions of the author's Dotclear modules:
https://raw.githubusercontent.com/JcDenis/gh2da/master/CONVENTIONS.md
(if a web tool refuses the address, use `curl -s` on it from the shell).
The rules below take precedence for this module.

## Module

Add a favicon to your blog.

No admin page. Public side: URL handlers.

Required Dotclear and PHP versions: see `_define.php`.

## Structure

* `src/Backend.php`: admin side: menu entry, favorites, behaviors registration.
* `src/Frontend.php`: public side: behaviors, template tags and URL handlers registration.
* `src/FrontendUrl.php`: public URL handler.
* `src/Install.php`: install and update, moves the old setting `system.simply_favicon` to `simplyFavicon.active`.
* `src/My.php`: module helpers (`My::id()`, settings, permissions).
* `src/Prepend.php`: loaded on every request: autoload, URL handlers, permission types.
* `src/Uninstall.php`: cleaners for the plugin Uninstaller.
* URL handlers: `simplyFavicon`.
* Behaviors used: `publicHeadContent`, `adminBlogPreferencesFormV2`, `adminBeforeBlogSettingsUpdate`.

## Pitfalls

* The setting is in the module namespace (`simplyFavicon.active`) since 2026.11: do not write in the core `system` namespace.

## Testing

* Check the public URLs, in English and French.
* CI browses the common admin and public pages; extra pages can be listed in `.github/dotclear-test.txt`.
