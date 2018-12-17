=== Responsive iframe GoogleMap ===
Contributors: pressmaninc, kanjinagao, hiroshisekiguchi, kazunao
Requires at least: 4.9.8
Tested up to: 5.0.1
Requires PHP: 5.6
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: shortcode, jquery, css, googlemap, iframe, responsive, free
Responsive friendly free GoogleMap embedder using shortcode.

== Description ==
Responsive friendly free GoogleMap embedder using shortcode.

== How to use ==
1. On a post screen, enter the shortcode. For classic wysiwyg editor, you can use GoogleMap button which this plugin adds.
2. Please set values for parameters below in your shortcode.
    - **width** : width of a map (px)
    - **height** : height of a map (px)
    - **zoom** : zoom of a map (1-21)
    - **border** : border style of a map (css)
    - **address** : see examples below
    - **latitude** : see examples below
    - **longitude** : see examples below
3. By posting, the GoogleMap is displayed in the article.

== example ==
- set a location by "address" parameter
```
[responsive_map width=860 height=500 address="Tokyo Station" zoom=16 border="1px solid #ccc"]
```
- set a location by "latitude" and "longitude" parameter
```
[responsive_map width=860 height=500 latitude=35.681167 longitude=139.767052 zoom=16 border="1px solid #ccc"]
```

== Installation ==
1. Upload the 'responsive-iframe-googlemap' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the Plugins menu in WordPress.

== Changelog ==
= 1.0.2 =
- Fixed Position setting bug.
= 1.0.1 =
- Fixed shortcode bug.
= 1.0.0 =
- First commit.