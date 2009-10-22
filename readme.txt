=== Multi-column Tag Map ===
Contributors: tugbucket
Tags: tags, lists, expandable, column, alphabetical
Requires at least: 2.1
Tested up to: 2.8
Stable tag: 1.3

Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site.

== Description ==

Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site. This makes it easier for visitors to quickly search for topics that might intrest them. 

= Features =
* Alphabetically lists all tags used in the site
* Display tags in one to five columns
* The initial amount of tags from each letter, can be limited
* jQuery Show/Hide effect 
* Customizable "show more" link 


== Installation ==

Drop mcTagMap folder into /wp-content/plugins/ and activate the plug in the Wordpress admin area.

Add this where you want the listing to appear.

`<?php if(function_exists('wp_mcTagMap')): ?>`
`<?php wp_mcTagMap() ?>`
`<?php endif; ?>`


= Defaults = 

* columns = 2
* more = View more
* hide = no
* num_show = 5

= Example =

`<?php if(function_exists('wp_mcTagMap')): ?>`
`<?php wp_mcTagMap('columns=4&hide=yes&num_show=5&more=See More') ?>`
`<?php endif; ?>`


= Note =
You must have jQuery in order to use the show/hide feature 

== Frequently Asked Questions ==

none

== Screenshots ==

1. Default view.`/trunk/screenshot-1.gif`
2. Four columns with hiding. `/trunk/screenshot-2.gif`

== Changelog ==

v1.2 - Updated the plugin PHP to correct the CSS path.
v1.3 - Fixed a conflict in jQuery for the show/hide to work.
