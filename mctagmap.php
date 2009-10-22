<?php
/*
Plugin Name: Multi-column Tag Map 
Plugin URI: http://tugbucket.net/wordpress/wordpress-plugin-multi-column-tag-map/
Description: Multi-column Tag Map display a columnized, alphabetical and expandable listing of all tags used in your site.
Version: 1.2
Author: Alan Jackson
Author URI: http://tugbucket.net
*/

/*  Copyright 2009  Alan Jackson (alan[at]tugbucket.net)

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
                   );

				   
	$options = explode("&",$options);
	
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
	$ns_options['more'] = $options['more'];
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
	
    $list = '<!-- begin list --><div id="mcTagMap">';
	$tags = get_terms('post_tag' );
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
		if ($options['hide'] == "yes"){
		$num2show = $options['num_show'];
		$num2show1 = ($options['num_show'] +1);
		if ($i != 0 and $i <= $num2show) {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			$list .="\n";
			}
		if ($i > $num2show && $i == $num2show1)  {
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

add_action('wp_head', 'mcTagMapCSSandJS');
function mcTagMapCSSandJS()
{
echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/multi-column-tag-map/mctagmap.css" type="text/css" media="screen" />';
echo "\n\n";
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

?>
