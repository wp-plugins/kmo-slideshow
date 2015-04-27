=== KMO Slideshow ===
Contributors: kmo_design
Donate link: http://www.kmo.com.au/
Tags: slideshow, folder, jquery, slides
Requires at least: 3.0.1
Tested up to: 4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin generates a gallery from a folder and displays using a shortcode.

== Description ==

This plugin generates a gallery from a folder and displays using a shortcode.
The folder must be uploaded (using FTP) to the wp-content/upload folder.

To include a slideshow in a post or a page, use the following shortcode:

	[kmoslideshow folder="local_path_to_folder"]

You can customize the slideshow using the following attributes:

* Slideshow width (width) in px
* Image border (border) in px (default 0)
* Image padding (padding) in px (default 0)
* Slide duration (interval) in milliseconds (default 4000)
* Pagination display (pagination): true or false (default true)
* Transition effect (effect): fade or slide (default slide)

Default slideshow width is set to the width of the container unless the width attribute is set.
The height is calculate from the first image.

	[kmoslideshow folder="path" width="500" padding="5"
			border="1" interval="5000" pagination="false" effect="fade"]
 
This plugin uses SlidesJS 3.0.3 by Nathan Searles - http://www.slidesjs.com 

== Installation ==

1. Upload the kmo-slideshow directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Upload a folder of pictures to 'wp-content/upload/gallery'
4. Insert the following short code in post or page:

	[kmoslideshow folder="wp-content/upload/gallery"]

== Changelog ==
