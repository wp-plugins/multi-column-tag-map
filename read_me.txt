=== Multi-column Tag Map ===
Contributors: tonywhite
Tags: tags, lists, expandable, column
Tested up to: 2.8

Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site. This makes it easier for visitors to quickly search for topics that might intrest them.

== Description ==

Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site. This makes it easier for visitors to quickly search for topics that might intrest them.  


== Installation ==

Drop mcTagMap folder into /wp-content/plugins/ and activate the plug in the Wordpress admin area.

Add this where you want the listing to appear.

<?php if(function_exists('wp_mcTagMap')): ?>
<?php wp_mcTagMap() ?>
<?php endif; ?>

Parameters: 

columns (1-5) - default: 2;
more (the .more link text) - default: "View more";
hide (yes or no) - default: no;
num_show (how many to show before displaying the more link) - default: 5;

Example:

<?php if(function_exists('wp_mcTagMap')): ?>
<?php wp_mcTagMap('columns=4&hide=yes&num_show=5&more=See More') ?>
<?php endif; ?>


== Screenshots ==

1. /trunk/mctagmap-2col.gif
2. /trunk/mctagmap-4col.gif
