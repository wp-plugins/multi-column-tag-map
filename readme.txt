=== Multi-column Tag Map ===
Contributors: tugbucket
Tags: tags, lists, expandable, column, alphabetical, toggleable, site amp
Requires at least: 2.1
Tested up to: 2.9.1
Stable tag: 3.0

Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site.

== Description ==

Multi-column Tag Map display a columnized, alphabetical, expandable and toggleable listing of all tags used in your site. This makes it easier for visitors to quickly search for topics that might intrest them. 

= Features =
* Alphabetically lists all tags used in the site
* Display tags in one to five columns
* The initial amount of tags from each letter can be limited
* jQuery Show/Hide effect 
* jQuery toogle effect
* Customizable "show more" link 
* Customizable "show less" link
* Can show tags with no posts related to them
* Can show tags belonging to private posts


== Installation ==

Unzip the 'mcTagMap' folder into '/wp-content/plugins/' and activate the plug in the Wordpress admin area.

You can hardcode this into your themes' PHP files like so:

`<?php if(function_exists('wp_mcTagMap')): ?>`
`<?php wp_mcTagMap() ?>`
`<?php endif; ?>`


This method is configurable in two ways.

The first method uses the standard '&' dilemeter. This method does not allow for special characters (shown with default values).

`<?php wp_mcTagMap('columns=2&hide=no&num_show=5&more=View more&toggle=no&show_empty=no') ?>`


The second method uses the vertical pipe '|' as a dilemeter thus allowing the use of special characters:

`<?php wp_mcTagMap('columns=3|hide=yes|num_show=10|more=more &#187;|toggle=&#171; less|show_empty=yes') ?>`


= Shortcode Installation =

`[mctagmap columns="3" more="more &#187;" hide="no" num_show="4" toggle="&#171;" show_empty="yes"]`


= Defaults = 

* columns = 2 (possible values: 1-5)
* hide = no (possible values: yes or no)
* num_show = 5
* more = View more
* toggle = no (possible values: 'YOUR TEXT' or no)
* show_empty = no (possible values: yes or no)

= Explanation of options =

* columns: This sets the number of columns to display your tags in. NOTE: if you have less letters than your set number of columns, the plug in will end up inserting an extra closing tag. this will mess up your layout.
* hide: This tells the list of tags for each letter to cut the list off at the point specified in the 'num_show' option.
* num_show: This tells the plug-in how many list items to show on page load.
* more: This will be the text of the link to dispaly more links. Only visible if 'hide' is set to 'yes' and 'num_show' is less than the total number of tags shown in each list.
* toggle: If set to anything except 'no', this will tell the 'more' link to become a toggle link. The text you set for 'toggle' will be the 'hide' link text.
* show_empty: If set to 'yes', this will display tags in the lists that currenlty do not have posts associated with them. NOTE: If a post is set to private the tag will still show up in the list but, clicking th elink will go to an empty archive unless the user is logged in. This is the same behavoir as clicking a tag link where there is no post to go to. This is not a bug.


= Note =
You must be using jQuery in order to use the show/hide feature 


== Frequently Asked Questions ==

none

== Screenshots ==

1. Default view.`/trunk/screenshot-1.gif`
2. Four columns with hiding. `/trunk/screenshot-2.gif`

== Changelog ==

* v1.2 - Updated the plugin PHP to correct the CSS path.
* v1.3.1 - Fixed a conflict in jQuery for the show/hide to work.
* v2.0 - Added shortcode functionality.
* v2.1 - Fixed a sorting coflict with the deafults.
* v2.2 - Fixed shorcode placement issue.
* v3.0 - Added toggleability to the lists, the ability to show empty posts and the ability to use special characters in the links.
