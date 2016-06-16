=== VelocityPage ===
Contributors: markjaquith
Tags: page builder, page layout, frontend, editor
Requires at least: 3.8
Tested up to: 3.9

Allows you to visually customize and control your page layouts right on the front of your site

== Description ==

Allows you to visually customize and control your page layouts right on the front of your site

== Installation ==

1. Upload the `velocitypage` folder to your `/wp-content/plugins/` directory.
2. Activate the "VelocityPage" plugin in your WordPress administration interface.
3. Enter your license key when prompted to receive updates and support.

== Changelog ==

= 1.0.2 =
* Support non-pretty permalink installs better
* Fix `<title>` output
* Bug fixes
* Support for "client licenses"
* Spellchecker browser support

= 1.0.1 =
* Removes the `?vp-transition` URL when transitioning a page, so you can refresh after saving and get a PHP view
* Fixes a bug where media wouldn't work if you had disabled the WordPress toolbar
* Some CSS fixes for esoteric Webkit CSS rules

= 1.0.0 =
* New item: media
* New item: shortcode
* New item: HR
* New item: spacer
* Adds ability to change column configuration
* Alternative row styles
* New themes: Maven, Paper Plane, Ronnia, Landify
* Revisions integration
* Tentatively use VP on existing pages
* Import page content when using user-theme
* Continuous export of VP page content to WordPress page

= 0.9.3=
* Improved the clarity of the image linking dialog
* Renamed "Section" to "Row"
* New item button now shows up contextually (you can insert items at any position, not just at end)
* Removed last accidental PHP shortcode, causing problems on some PHP installs
* Add a clearfix to some themes that set the wrapper class to be overflow:hidden

= 0.9.2 =
* Fixed issue where license nag would continue to show after you'd entered license key
* Fixed dragged item background color when theme doesn't specify white background (but just assumes it as the browser default)
* Removed accidental PHP shortcode which causes problems on some PHP installs

= 0.9.1 =
* Fixed issue where some themes hid the "Edit" button
* Fixed issue where some themes hide or clip the on-page controls
* Faster and more efficient JS rendering
* A more intuitive license key flow
* Added a note about how enabling VelocityPage on a page will then use VelocityPage's output, ignoring the WordPress page contents (soon: import/export from the WordPress page contents)
* Added a settings link from the plugins page
* Fixed an issue with inserting small images
* Fixed an issue where the image chooser would pop up immediately
* CSS defenses
* Uses a CSS sprite for row columns
* Added `entry-content` class to text items

= 0.9.0 =
* Original release
