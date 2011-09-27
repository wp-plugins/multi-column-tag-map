<?php
/*
Plugin Name: Multi-column Tag Map 
Plugin URI: http://tugbucket.net/wordpress/wordpress-plugin-multi-column-tag-map/
Description: Multi-column Tag Map display a columnized, alphabetical, expandable and toggleable listing of all tags used in your site.
Version: 4.0
Author: Alan Jackson
Author URI: http://tugbucket.net
*/

/*  Copyright 2009-2011  Alan Jackson (alan[at]tugbucket.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



function wp_mcTagMap($options='') {

	$ns_options = array(
                    "columns" => "2",
                    "more" => "View More",
					"hide" => "no",
					"num_show" => "5",
					"toggle" => "no",
					"show_empty" => "yes",
                   );
			
	if(strpos($options, '|')) {		   
	$options = explode("|",$options);
	} else {
	$options = explode("&",$options);
	}
	
	foreach ($options as $option) {
	
		$parts = explode("=",$option);
		$options[$parts[0]] = $parts[1];
	
	}

	if ($options['columns']) {
	$ns_options['columns'] = $options['columns'];
	} else {
	$options['columns'] = 2;
	}
	
    if ($options['more']) {
	$ns_options['more'] = htmlentities($options['more'], ENT_QUOTES);
	} else {
	$options['more'] = "View more";
	}
	
    if ($options['hide']) {
	$ns_options['hide'] = $options['hide'];
	} else {
	$options['hide'] = "no";
	}
	
    if ($options['num_show']) {
	$ns_options['num_show'] = $options['num_show'];
	} else {
	$options['num_show'] = 5;
	}
	
	if ($options['toggle']) {
	$ns_options['toggle'] = $options['toggle'];
	} else {
	$options['toggle'] = "no";
	}
	
	if ($options['show_empty']) {
	$ns_options['show_empty'] = $options['show_empty'];
	} else {
	$options['show_empty'] = "yes";
	}
	
	$show_empty = $options['show_empty'];
	if($show_empty == "yes"){
		$show_empty = "0";
	}
	if($show_empty == "no"){
		$show_empty = "1";
	}
    $list = '<!-- begin list --><div id="mcTagMap">';
	$tags = get_terms('post_tag', 'order=ASC&hide_empty='.$show_empty.''); // new code!
	$groups = array();
	
	
	
	if( $tags && is_array( $tags ) ) {
		foreach( $tags as $tag ) {
			$first_letter = strtoupper( $tag->name[0] );
			$groups[ $first_letter ][] = $tag;
		}
	if( !empty ( $groups ) ) {	
		$count = 0;
		$howmany = count($groups);
		
		// this makes 2 columns
		if ($options['columns'] == 2){
		$firstrow = ceil($howmany * 0.5);
	    $secondrow = ceil($howmany * 1);
	    $firstrown1 = ceil(($howmany * 0.5)-1);
	    $secondrown1 = ceil(($howmany * 1)-0);
		}
		
		
		//this makes 3 columns
		if ($options['columns'] == 3){
	    $firstrow = ceil($howmany * 0.33);
	    $secondrow = ceil($howmany * 0.66);
	    $firstrown1 = ceil(($howmany * 0.33)-1);
	    $secondrown1 = ceil(($howmany * 0.66)-1);
		}
		
		//this makes 4 columns
		if ($options['columns'] == 4){
	    $firstrow = ceil($howmany * 0.25);
	    $secondrow = ceil(($howmany * 0.5)+1);
	    $firstrown1 = ceil(($howmany * 0.25)-1);
	    $secondrown1 = ceil(($howmany * 0.5)-0);
		$thirdrow = ceil(($howmany * 0.75)-0);
	    $thirdrow1 = ceil(($howmany * 0.75)-1);
		}
		
		//this makes 5 columns
		if ($options['columns'] == 5){
	    $firstrow = ceil($howmany * 0.2);
	    $firstrown1 = ceil(($howmany * 0.2)-1);
	    $secondrow = ceil(($howmany * 0.4));
		$secondrown1 = ceil(($howmany * 0.4)-1);
		$thirdrow = ceil(($howmany * 0.6)-0);
	    $thirdrow1 = ceil(($howmany * 0.6)-1);
		$fourthrow = ceil(($howmany * 0.8)-0);
	    $fourthrow1 = ceil(($howmany * 0.8)-1);
		}
		
		foreach( $groups as $letter => $tags ) { 
			if ($options['columns'] == 2){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $firstrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($options['columns'] == 3){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $secondrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($options['columns'] == 4){				
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow) { 
			    if ($count == $thirdrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($options['columns'] == 5){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow || $count == $fourthrow ) { 
			    if ($count == $fourthrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
		
    $list .= '<div class="tagindex">';
	$list .="\n";
	$list .='<h4>' . apply_filters( 'the_title', $letter ) . '</h4>';
	$list .="\n";
	$list .= '<ul class="links">';
	$list .="\n";			
	$i = 0;
	foreach( $tags as $tag ) {
		$url = attribute_escape( get_tag_link( $tag->term_id ) );
		$name = apply_filters( 'the_title', $tag->name );
	//	$name = ucfirst($name);
		$i++;
		$counti = $i;
		if ($options['hide'] == "yes"){
		$num2show = $options['num_show'];
		$num2show1 = ($options['num_show'] +1);
		$toggle = ($options['toggle']);
		
		if ($i != 0 and $i <= $num2show) {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			$list .="\n";
			}
		if ($i > $num2show && $i == $num2show1 && $toggle == "no") {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$options['more']."</a>"."</li>"."\n";
			}
		if ($i >= $num2show1){
               $list .= '<li class="hideli"><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			   $list .="\n";
		}
		} else {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			$list .="\n";
		}	
		
	} 
		if ($options['hide'] == "yes" && $toggle != "no" && $i == $counti && $i > $num2show) {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$options['more']."</a>"."<a href=\"#x\" class=\"less\">".$options['toggle']."</a>"."</li>"."\n";
		}	 
	$list .= '</ul>';
	$list .="\n";
	$list .= '</div>';
	$list .="\n\n";
		if ($options['columns'] == 3 || $options['columns'] == 2){
		if ( $count == $firstrown1 || $count == $secondrown1) { 
			$list .= "</div>"; 
			}	
			}
		if ($options['columns'] == 4){
		if ( $count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1) { 
			$list .= "</div>"; 
			}	
			}
		if ($options['columns'] == 5){		
		if ( $count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1 || $count == $fourthrow1) { 
			$list .= "</div>"; 
			}	
			}
				 
		$count++;
			} 
		} 
	$list .="</div>";
	$list .= "<div style='clear: both;'></div></div><!-- end list -->";
		}
	else $list .= '<p>Sorry, but no tags were found</p>';

print $list ;

}
// end long code


// short code begins
function sc_mcTagMap($atts, $content = null) {
        extract(shortcode_atts(array(
                    "columns" => "2",
                    "more" => "View More",
					"hide" => "no",
					"num_show" => "5",
					"toggle" => "no",
					"show_empty" => "yes",
					"name_divider" => "|", // added 09.02.11
        ), $atts));

				   

	if($show_empty == "yes"){
		$show_empty = "0";
	}
	if($show_empty == "no"){
		$show_empty = "1";
	}


    $list = '<!-- begin list --><div id="mcTagMap">';
	$tags = get_terms('post_tag', 'order=ASC&hide_empty='.$show_empty.''); // new code!
	$groups = array();
	if( $tags && is_array( $tags ) ) {
		foreach( $tags as $tag ) {
		
			// added 09.02.11
			if (strlen(strstr($tag->name, $name_divider))>0) {
 				$tag->name = preg_replace("/\s*([\\".$name_divider."])\s*/", "$1", $tag->name);
				$tagParts = explode($name_divider, $tag->name);
				$tag->name = $tagParts[1].', '.$tagParts[0];
			}
			
			$first_letter = strtoupper( $tag->name[0] );
			//$first_letter = $tag->name[0];
			//echo $first_letter.', ';
			$groups[ $first_letter ][] = $tag;
			ksort($groups);
		}
	if( !empty ( $groups ) ) {	
		$count = 0;
		$howmany = count($groups);
		
		// this makes 2 columns
		if ($columns == 2){
		$firstrow = ceil($howmany * 0.5);
	    $secondrow = ceil($howmany * 1);
	    $firstrown1 = ceil(($howmany * 0.5)-1);
	    $secondrown1 = ceil(($howmany * 1)-0);
		}
		
		
		//this makes 3 columns
		if ($columns == 3){
	    $firstrow = ceil($howmany * 0.33);
	    $secondrow = ceil($howmany * 0.66);
	    $firstrown1 = ceil(($howmany * 0.33)-1);
	    $secondrown1 = ceil(($howmany * 0.66)-1);
		}
		
		//this makes 4 columns
		if ($columns == 4){
	    $firstrow = ceil($howmany * 0.25);
	    $secondrow = ceil(($howmany * 0.5)+1);
	    $firstrown1 = ceil(($howmany * 0.25)-1);
	    $secondrown1 = ceil(($howmany * 0.5)-0);
		$thirdrow = ceil(($howmany * 0.75)-0);
	    $thirdrow1 = ceil(($howmany * 0.75)-1);
		}
		
		//this makes 5 columns
		if ($columns == 5){
	    $firstrow = ceil($howmany * 0.2);
	    $firstrown1 = ceil(($howmany * 0.2)-1);
	    $secondrow = ceil(($howmany * 0.4));
		$secondrown1 = ceil(($howmany * 0.4)-1);
		$thirdrow = ceil(($howmany * 0.6)-0);
	    $thirdrow1 = ceil(($howmany * 0.6)-1);
		$fourthrow = ceil(($howmany * 0.8)-0);
	    $fourthrow1 = ceil(($howmany * 0.8)-1);
		}
		


		
		foreach( $groups as $letter => $tags ) { 
			if ($columns == 2){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $firstrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($columns == 3){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $secondrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($columns == 4){				
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow) { 
			    if ($count == $thirdrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($columns == 5){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow || $count == $fourthrow ) { 
			    if ($count == $fourthrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
		
    $list .= '<div class="tagindex">';
	$list .="\n";
	$list .='<h4>' . apply_filters( 'the_title', $letter ) . '</h4>';
	$list .="\n";
	$list .= '<ul class="links">';
	$list .="\n";			
	$i = 0;

	uasort( $tags, create_function('$a, $b', 'return strnatcasecmp($a->name, $b->name);') ); // addded 09.02.11
		
	foreach( $tags as $tag ) {
		$url = attribute_escape( get_tag_link( $tag->term_id ) );
		$name = apply_filters( 'the_title', $tag->name );
		//$name = ucfirst($name);
		$i++;
		$counti = $i;
		if ($hide == "yes"){
		$num2show = $num_show;
		$num2show1 = ($num_show +1);
		//$toggle = ($options['toggle']);
		if ($i != 0 and $i <= $num2show) {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			$list .="\n";
			}
		if ($i > $num2show && $i == $num2show1 && $toggle == "no") {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$more."</a>"."</li>"."\n";
			}
		if ($i >= $num2show1){
               $list .= '<li class="hideli"><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			   $list .="\n";
		}
		} else {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			$list .="\n";
		}		
		
	}
		if ($hide == "yes" && $toggle != "no" && $i == $counti && $i > $num2show) {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$more."</a>"."<a href=\"#x\" class=\"less\">".$toggle."</a>"."</li>"."\n";
		}	 
		 
	$list .= '</ul>';
	$list .="\n";
	$list .= '</div>';
	$list .="\n\n";
		if ($columns == 3 || $columns == 2){
		if ( $count == $firstrown1 || $count == $secondrown1) { 
			$list .= "</div>"; 
			}	
			}
		if ($columns == 4){
		if ( $count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1) { 
			$list .= "</div>"; 
			}	
			}
		if ($columns == 5){		
		if ( $count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1 || $count == $fourthrow1) { 
			$list .= "</div>"; 
			}	
			}
				 
		$count++;
			} 
		} 
	$list .="</div>";
	$list .= "<div style='clear: both;'></div></div><!-- end list -->";
		}
	else $list .= '<p>Sorry, but no tags were found</p>';

return $list;

}

add_shortcode("mctagmap", "sc_mcTagMap");
// end shortcode

function set_plugin_meta($links, $file) {
$plugin = plugin_basename(__FILE__);
// create link
if ($file == $plugin) {
return array_merge( $links, array( sprintf( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX8RH7F2LR74J" target="_blank">Donate</a>', $plugin, __('Donate') ) ));
}
return $links;
}
add_filter( 'plugin_row_meta', 'set_plugin_meta', 10, 2 );



// the JS and CSS
add_action('wp_head', 'mcTagMapCSSandJS');
function mcTagMapCSSandJS()
{
if ($toggle == "no"){
echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/multi-column-tag-map/mctagmap.css" type="text/css" media="screen" />';
echo "\n";
echo "<!-- mctagmap by tugbucket -->";
echo "\n";
echo "<script type=\"text/javascript\">
jQuery(document).ready(function() { 
  jQuery('ul.links li.hideli').hide();
  jQuery('ul.links li.morelink').show();
  jQuery('a.more').click(function() {
	jQuery(this).parent().siblings('li.hideli').slideToggle('fast');
	 jQuery(this).parent('li.morelink').remove();
  });
});
</script>\n\n";
}
if ($toggle != "no"){
echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/multi-column-tag-map/mctagmap.css" type="text/css" media="screen" />';
echo "\n";
echo "<!-- mctagmap by tugbucket -->";
echo "\n";
echo "<script type=\"text/javascript\">
jQuery(document).ready(function() { 
  jQuery('a.less').hide();
  jQuery('ul.links li.hideli').hide();
  jQuery('ul.links li.morelink').show();
  jQuery('a.more').click(function() {
	jQuery(this).parent().siblings('li.hideli').slideToggle('fast');
	 jQuery(this).parent('li.morelink').children('a.less').show();
	 jQuery(this).hide();
  });
    jQuery('a.less').click(function() {
	jQuery(this).parent().siblings('li.hideli').slideToggle('fast');
	 jQuery(this).parent('li.morelink').children('a.more').show();
	 jQuery(this).hide();
  });
});
</script>\n\n";
}
}

?>
