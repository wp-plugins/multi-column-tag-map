=== Multi-column Tag Map ===
Contributors: tugbucket
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX8RH7F2LR74J
Tags: tags, lists, expandable, column, alphabetical, toggleable, site map, index, appendix, glossary
Requires at least: 2.1
Tested up to: 3.2
Stable tag: 8.0

Multi-column Tag Map displays a columnized and alphabetical (English) listing of all tags used in your site similar to the index pages of a book.

== Description ==

Multi-column Tag Map displays a columnized  and alphabetical (English) listing of all tags used in your site similar to the index pages of a book. This makes it easier for your visitors to quickly search for topics that might intrest them. 

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
* Optionally list tags of peoples names last name first
* Can display the number of posts that share a tag
* Can exclude tags you do not want to appear in the lists
* Can display the tag description
* Can set the width of the columns in the shortcode
* Can add your own custom CSS to your theme's directory


== Installation ==

Unzip the 'mcTagMap' folder into '/wp-content/plugins/' and activate the plug in the Wordpress admin area.

= Hardcode Installation **deprecated since verion 4.0** =

You can hardcode this into your themes' PHP files like so:

`<?php if(function_exists('wp_mcTagMap')): ?>
<?php wp_mcTagMap() ?>
<?php endif; ?>`


This method is configurable in two ways.

The first method uses the standard '&' dilemeter. This method does not allow for special characters (shown with default values).

`<?php wp_mcTagMap('columns=2&hide=no&num_show=5&more=View more&toggle=no&show_empty=no') ?>`


The second method uses the vertical pipe '|' as a dilemeter thus allowing the use of special characters:

`<?php wp_mcTagMap('columns=3|hide=yes|num_show=10|more=more &amp;#187;|toggle=&amp;#171; less|show_empty=yes') ?>`

**NOTE:** As of version 4.0, only the shortcode installation will be supported.


= Shortcode Installation Example =

`[mctagmap columns="3" more="more &#187;" hide="yes" num_show="3" toggle="&#171; less" show_empty="yes" name_divider="|" tag_count="yes" descriptions="yes" exclude="2009,exposition" width="170" equal="yes"]`



= Defaults = 

* columns = 2 (possible values: 1-5)
* hide = no (possible values: yes or no)
* num_show = 5
* more = View more
* toggle = no (possible values: 'YOUR TEXT' or no)
* show_empty = no (possible values: yes or no)
* name_divider = |
* tag_count = no (possible values: yes or no)
* exclude = 
* descriptions = no (possible values: yes or no)
* width = 190 (do not use 'px', 'em', etc)
* equal = no (possible values: yes or no)

= Explanation of options =

* columns: This sets the number of columns to display your tags in. NOTE: if you have less letters than your set number of columns, the plug in will end up inserting an extra closing tag. this will mess up your layout.
* hide: This tells the list of tags for each letter to cut the list off at the point specified in the 'num_show' option.
* num_show: This tells the plug-in how many list items to show on page load.
* more: This will be the text of the link to dispaly more links. Only visible if 'hide' is set to 'yes' and 'num_show' is less than the total number of tags shown in each list.
* toggle: If set to anything except 'no', this will tell the 'more' link to become a toggle link. The text you set for 'toggle' will be the 'hide' link text.
* show_empty: If set to 'yes', this will display tags in the lists that currently do not have posts associated with them. NOTE: If a post is set to private the tag will still show up in the list but, clicking the link will go to an empty archive unless the user is logged in. This is the same behavoir as clicking a tag link where there is no post to go to. This is not a bug.
* name_divider: This allows for multi-word tags to be sorted by words other than the first word eg. "Edgar Allen Poe" would be sorted under the "E"s. If you write your tag "Edgar Allen | Poe" it will now produce "Poe, Edgar Allen" and be sorted with the "P"s.
* tag_count: If this option is set to "yes", the number of posts that share that tag will be displayed like "(3)". The count is wrapped in a span with a class of "mctagmap_count" so that the count can be styled individually in the CSS if desired. 
* exclude: A coma seperated, case sensitive list of the tags you do not wish to appear in the lists.
* descriptions: If set to yes, the plugin will create a span and populate it with the tags description. By default the text is set to 90% italics.
* width: The default width (190px) can be set in the shortcode without any need to alter the CSS. 
* equal: What this does is makes the horizontal sections equal height based on the tallest in the row. This is only recommended if you are using the "hide" option. Look at the first image in the screenshots page for a better example. 

= Note =
You must be using jQuery in order to use the show/hide feature.

= Additional Options =
In the past, when a new update was released, it would overwrite any changes manually made to the the files for the plugin. Now you can make a folder named "multi-column-tag-map" in your theme's directory. Move a copy of the plugin's "mctagmap.css" into that folder. There you can make style changes that will not be overwritten when you update the mctagmap plugin.


== Frequently Asked Questions ==

= The plugin doesn't work correctly in [non-english] language, can you fix it? =

Currently the plugin only displays and groups non-English words. It does not sort these words alphabetically. If someone would like to help translate it into another language, it would be appreciated.

= Does the plugin work in [insert theme name]? =

mctagmap does nothing to the core functions of Wordpress. There should be no reason that a theme changes the default functions as to how Wordpress handles tags. Knowing that, there shouldn't be any reason why the plugin does not work in your theme. The CSS might get overwritten due the the hierarchy of your themes CSS but, that can be changed by editing the mctagmap.css in the plugins folder.


= The map is displaying in a "stair case" fashion =

See screenshot <a href=\"http://wordpress.org/extend/plugins/multi-column-tag-map/screenshots/\">"pre-code error"</a>.

In your admin panel for the page, switch to HTML view. Notice your theme is wrapping the shortcode in:

`<pre><code> </code></pre>`

Please remove that. That should fix it up.


== Screenshots ==

1. Using all options. `/trunk/screenshot-1.gif`
2. In use at <a href=\"http://www.noveleats.com/ingredient/\">Novel Eats</a>. `/trunk/screenshot-2.gif`
3. In use at the <a href=\"http://soctheory.iheartsociology.com/index/\">Department of Sociology of Occidental College</a>. `/trunk/screenshot-3.gif`
4. Someextra styling added at <a href=\"http://blog.caplin.com/index/\">Caplin's blog</a>. `/trunk/screenshot-4.gif`
5. The common "pre-code error". `/trunk/screenshot-5.gif`

== Changelog ==

* v1.2 - Updated the plugin PHP to correct the CSS path.
* v1.3.1 - Fixed a conflict in jQuery for the show/hide to work.
* v2.0 - Added shortcode functionality.
* v2.1 - Fixed a sorting coflict with the defaults.
* v2.2 - Fixed shorcode placement issue.
* v3.0 - Added toggleability to the lists, the ability to show empty posts and the ability to use special characters in the links.
* v4.0 - Deprecated hardcode support. Added name_divider shortcode option.
* v4.0.1 - Typos
* v4.1 - oops
* v4.2 - Fixed function conflict and added to the FAQ.
* v5.0 - Fixed a small issue with the name_divider addition. Added the tag_count option.
* v5.1 - cleaned up the tag_count function.
* v6.0 - Added language display support and the ability to exclude tags.
* v6.0.1 - upload error. 
* v6.0.2 - upload error. 
* v7.0 - Added the ablity to display tag descriptions and set the column width in the shortcode. Cleaned up some of the code that was being inserted in the head section.
* v8.0 - Added the ability to equalize the heights of the individual letters sections, the use of a custom CSS within the theme's folder and added to the FAQ.
