=== Multi-column Tag Map ===
Contributors: tugbucket
Tags: tags, lists, expandable, column, alphabetical
Requires at least: 2.1
Tested up to: 2.8
Stable tag: 0.1

Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site.

== Description ==

Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site. This makes it easier for visitors to quickly search for topics that might intrest them. 

= Features =
* Alphabetically lists all tags used in the site
* Display tags in one to five columns
* The initial amount of tags from each letter, can be limited
* jQuery Show/Hide effect 
* Customizable "show mre" link 


== Installation ==

Drop mcTagMap folder into /wp-content/plugins/ and activate the plug in the Wordpress admin area.

Add this where you want the listing to appear.

<code>
&lt;?php if(function_exists('wp_mcTagMap')): ?>
&lt;?php wp_mcTagMap() ?>
&lt;?php endif; ?>
</code>

= Parameters = 

columns (1-5) - default: 2
more (the .more link text) - default: "View more"
hide (yes or no) - default: no
num_show (how many to show before displaying the more link) - default: 5

= Example =

<code>
&lt;?php if(function_exists('wp_mcTagMap')): ?>
&lt;?php wp_mcTagMap('columns=4&hide=yes&num_show=5&more=See More') ?>
&lt;?php endif; ?>
</code>

= Note =
You must have jQuery in order to use the show/hide feature 

== Frequently Asked Questions ==

none

== Screenshots ==

1. /trunk/mctagmap-2col.gif
2. /trunk/mctagmap-4col.gif

== Changelog ==
