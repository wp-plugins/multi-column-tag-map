<?php
/*
Plugin Name: Multi-column Tag Map 
Plugin URI: http://tugbucket.net/wordpress/wordpress-plugin-multi-column-tag-map/
Description: Multi-column Tag Map displays a columnized and alphabetical (English) listing of all tags used in your site similar to the index pages of a book.
Version: 10.0
Author: Alan Jackson
Author URI: http://tugbucket.net
*/

/*  Copyright 2009-2012  Alan Jackson (alan[at]tugbucket.net)

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

// **************************
//
// Long code removed completely as of version 10.0 - it was deprecated as of version 4.0
//
// **************************

// short code begins
function sc_mcTagMap($atts, $content = null) {
        extract(shortcode_atts(array(
                    "columns" => "2",
                    "more" => "View More",
					"hide" => "no",
					"num_show" => "5",
					"toggle" => "no",
					"show_empty" => "no",
					"name_divider" => "|",
					"tag_count" => "no",
					"exclude" => "",
					"descriptions" => "no",
					"width" => "",
					"equal" => "no",
					"manual" => "",
					"basic" => "no",
					"basic_heading" => "no",
					"show_categories" => "no",
					"taxonomy" => "",
					"group_numbers" => "no",
					"show_navigation" => "no",
        ), $atts));
		
	if(!in_array($columns, array(1, 2, 3, 4, 5))){
		$columns = "2";
	}
   
	if($show_empty == "yes"){
		$show_empty = "0";
	}
	if($show_empty == "no"){
		$show_empty = "1";
	}
	
	if($width){
		$tug_width = "style=\"width: ". $width ."px;\"";
	}
	if($equal == "yes" && $columns != "1" && $basic != "no"){ 
		$equalize = 'mcEqualize';
	}
	if($toggle != "no"){
		$toggable = "toggleYes";
	} else {
		$toggable = "toggleNo";
	}

	/* show settings */
	if(isset($_REQUEST['tug'])){ 
		$list = '<div>
			<style type="text/css">
				#tug-settings-mctagmap { border: 2px solid #ccc; background: #f8f8f8; font: 12px/16px monospace; padding: 10px; margin: 0; }
				#tug-settings-mctagmap dt { padding: 0 0 8px 0; }
				#tug-settings-mctagmap dd { margin-bottom: 6px; }
			</style>
			<dl id="tug-settings-mctagmap">
				<dt>mctagmap settings</dt>
					<dd>columns => '.$columns.'</dd>
					<dd>more => '.$more.'</dd>
					<dd>hide => '.$hide.'</dd>
					<dd>num_show => '.$num_show.'</dd>
					<dd>toggle => '.$toggle.'</dd>
					<dd>show_empty => '.$show_empty.'</dd>
					<dd>name_divider => '.$name_divider.'</dd>
					<dd>tag_count => '.$tag_count.'</dd>
					<dd>exclude => '.$exclude.'</dd>
					<dd>descriptions => '.$descriptions.'</dd>
					<dd>width => '.$width.'</dd>
					<dd>equal => '.$equal.'</dd>
					<dd>manual => '.$manual.'</dd>
					<dd>basic => '.$basic.'</dd>
					<dd>basic_heading => '.$basic_heading.'</dd>
					<dd>show_categories => '.$show_categories.'</dd>
					<dd>taxonomy => '.$taxonomy.'</dd>
					<dd>group numbers => '.$group_numbers.'</dd>
					<dd>show_navigation => '.$show_navigation.'</dd>
			</dl>
			</div>';
	} else {
		$list = '';
	}
	$manual = str_replace(' ', '', strtoupper($manual));
	$manualArray = explode(',', $manual);
	
    $list .= '<!-- begin list -->'."\n".'<div id="mcTagMap" class="'.$equalize.' '.$toggable.'">'."\n";
	
	if($taxonomy){
		$tags = get_terms($taxonomy, 'order=ASC&hide_empty='.$show_empty.''); 
	} elseif($show_categories == "yes"){
		$tags = get_categories('order=ASC&hide_empty='.$show_empty.'');
	} else {
		$tags = get_terms('post_tag', 'order=ASC&hide_empty='.$show_empty.''); 
	}

	/* exclude tags */	
	foreach($tags as $tag){
		$fl = mb_substr($tag->name,0,1);
		$ll = mb_substr($tag->name,1);
		$tag->name = $fl.$ll;
		if (preg_match('/(?<=^|[^\p{L}])' . preg_quote($tag->name,'/') . '(?=[^\p{L}]|$)/ui', $exclude)) {
			unset($tag->name);
		}
	}
	
	$groups = array();
	if( $tags && is_array( $tags ) ) {
		foreach( $tags as $tag ) {	
		/* exclude tags */
		if(isset($tag->name)){	
			// added 09.02.11
			if (strlen(strstr($tag->name, $name_divider))>0) {
 				$tag->name = preg_replace("/\s*([\\".$name_divider."])\s*/", "$1", $tag->name);
				$tagParts = explode($name_divider, $tag->name);
				$tag->name = $tagParts[1].', '.$tagParts[0];
			}
			
			$first_letter = mb_strtoupper( mb_substr($tag->name,0,1) ); /* Thanks to Birgir Erlendsson */
			$groups[$first_letter][] = $tag;
			ksort($groups);
		}
		}
		
		/* group numbers */
		if($group_numbers == 'yes'){
			$numericArray = array_filter(array_keys($groups), 'is_numeric');
			$ed = array_keys($groups);
			$d = array_diff_assoc($ed, $numericArray);
			$numGroups = $groups;
			foreach($d as $dd){
				$numGroups[$dd] = "";
			}
			ksort($numGroups);		
			function flatten($arr, $base = "", $divider_char = "/") {
    			$ret = array();
    			if(is_array($arr)) {
        			foreach($arr as $k => $v) {
            			if(is_array($v)) {
                			$tmp_array = flatten($v, $base.$k.$divider_char, $divider_char);
                			$ret = array_merge($ret, $tmp_array);
            			} else {
                			$ret[$base.$k] = $v;
            			}
        			}
   				}
    			return $ret;
			}
			$numbersArray = array_filter(array_values(flatten($numGroups)));
			$groups = array_diff_assoc($groups, $numGroups);
			if(!empty($numbersArray)){	
				$nums = array('#' => $numbersArray);
				$groups = array_merge($groups, $nums);
			} 
		}
	
		/* make the navigation */
		$list .= '<div id="mcTagMapNav">'."\n";
		foreach( array_keys($groups) as $fl ) {
			$list .= '<a href="#mctm-'.$fl.'">'.$fl.'</a>'."\n";
		}
		$list .= '</div>'."\n";
		
		/* show headings regardless */
		/*
		$alphabet = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$ress = array_diff($alphabet, array_keys($groups));
		foreach($ress as $res){
			$groups[$res] = "";
		}
		ksort($groups);
		error_reporting(0);
		*/
		/* *** */
		
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
		
if(!$manual && $basic == "no"){
	
		foreach( $groups as $letter => $tags ) { 
			if ($columns == 2){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $firstrow){
				$list .= "\n<div class='holdleft noMargin' ". $tug_width .">\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft' ". $tug_width .">\n";
				$list .="\n";
				}
				}
				}
			if ($columns == 3){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $secondrow){
				$list .= "\n<div class='holdleft noMargin' ". $tug_width .">\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft' ". $tug_width .">\n";
				$list .="\n";
				}
				}
				}
			if ($columns == 4){				
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow) { 
			    if ($count == $thirdrow){
				$list .= "\n<div class='holdleft noMargin' ". $tug_width .">\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft' ". $tug_width .">\n";
				$list .="\n";
				}
				}
				}
			if ($columns == 5){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow || $count == $fourthrow ) { 
			    if ($count == $fourthrow){
				$list .= "\n<div class='holdleft noMargin' ". $tug_width .">\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft' ". $tug_width .">\n";
				$list .="\n";
				}
				}
				}


    $list .= '<div class="tagindex">';
	$list .="\n";



	$list .='<h4 id="mctm-'.$letter.'">' . apply_filters( 'the_title', $letter ) . '</h4>';

	$list .="\n";
	$list .= '<ul class="links">';
	$list .="\n";			
	$i = 0;
	
	uasort( $tags, create_function('$a, $b', 'return strnatcasecmp($a->name, $b->name);') ); // addded 09.02.11
	
	foreach( $tags as $tag ) {

		/* exclude tags */
		if(isset($tag->name)){
		if($tag_count == "yes"){
			$mctagmap_count = ' <span class="mctagmap_count">('.$tag->count.')</span>';
		}

		if($taxonomy){
			$url = get_term_link($tag->slug, $taxonomy);
		} elseif($show_categories == "yes"){
			$url = get_category_link($tag->term_id); 
		} else {
			$url = attribute_escape( get_tag_link( $tag->term_id ) ); 
		}
		
		$name = apply_filters( 'the_title', $tag->name );
		if($descriptions == "yes"){
			$mctagmap_description = '<span class="tagDescription">' . $tag->description . '</span>';
		}

		$i++;
		$counti = $i;
		if ($hide == "yes"){
		$num2show = $num_show;
		$num2show1 = ($num_show +1);
		
		if ($i != 0 and $i <= $num2show) {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a>'. $mctagmap_count . $mctagmap_description . '</li>';
			$list .="\n";
			}
		if ($i > $num2show && $i == $num2show1 && $toggle == "no") {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$more."</a>"."</li>"."\n";
			}
		if ($i >= $num2show1){
               $list .= '<li class="hideli"><a title="' . $name . '" href="' . $url . '">' . $name . '</a>' . $mctagmap_count . $mctagmap_description . '</li>';
			   $list .="\n";
		}
		} else {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a>' . $mctagmap_count . $mctagmap_description . '</li>';
			$list .="\n";
		}	
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
	$list .="</div>";
	}
}

/*
// ***************************
// manual  settings 
// ***************************
*/

if($manual && $basic == "no"){
	$list .= "\n<div class='holdleft' ". $tug_width .">\n";
	$manualCount = 1;
	foreach( $groups as $letter => $tags ) {	
		foreach(array(strtoupper(apply_filters('the_title', $letter))) as $qw) { 
			if(in_array($qw, $manualArray)){
				//$list .= '<div style="background: #000; color: #fff; padding: 3px;">In Array! - '. $qw.'</div>';
				if($manualCount == count($manualArray)){
					$marginEh = "noMargin";
					$endManual = '</div>';
				}
				$list .= "</div>\n<div class='holdleft ". $marginEh ."' ". $tug_width . ">\n";
				$manualCount++;
			}			
		}
	
    $list .= '<div class="tagindex">';
	$list .="\n";



	$list .='<h4 id="mctm-'.$letter.'">' . apply_filters( 'the_title', $letter ) . '</h4>';

	$list .="\n";
	$list .= '<ul class="links">';
	$list .="\n";			
	$i = 0;

	uasort( $tags, create_function('$a, $b', 'return strnatcasecmp($a->name, $b->name);') ); // addded 09.02.11

	foreach( $tags as $tag ) {
		/* exclude tags */
		if(isset($tag->name)){
		// added 9.28.11
		if($tag_count == "yes"){
			$mctagmap_count = ' <span class="mctagmap_count">('.$tag->count.')</span>';
		}
		
		if($taxonomy){
			$url = get_term_link($tag->slug, $taxonomy);
		} elseif($show_categories == "yes"){
			$url = get_category_link($tag->term_id); 
		} else {
			$url = attribute_escape( get_tag_link( $tag->term_id ) ); 
		}
		
		$name = apply_filters( 'the_title', $tag->name );
		if($descriptions == "yes"){
			$mctagmap_description = '<span class="tagDescription">' . $tag->description . '</span>';
		}
		//$name = ucfirst($name);
		$i++;
		$counti = $i;
		if ($hide == "yes"){
		$num2show = $num_show;
		$num2show1 = ($num_show +1);
		//$toggle = ($options['toggle']);
		
		if ($i != 0 and $i <= $num2show) {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a>'. $mctagmap_count . $mctagmap_description . '</li>';
			$list .="\n";
			}
		if ($i > $num2show && $i == $num2show1 && $toggle == "no") {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$more."</a>"."</li>"."\n";
			}
		if ($i >= $num2show1){
               $list .= '<li class="hideli"><a title="' . $name . '" href="' . $url . '">' . $name . '</a>' . $mctagmap_count . $mctagmap_description . '</li>';
			   $list .="\n";
		}
		} else {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a>' . $mctagmap_count . $mctagmap_description . '</li>';
			$list .="\n";
		}	
		}	
		
	}
		if ($hide == "yes" && $toggle != "no" && $i == $counti && $i > $num2show) {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$more."</a>"."<a href=\"#x\" class=\"less\">".$toggle."</a>"."</li>"."\n";
		}	 
		 
	$list .= '</ul>';
	$list .="\n";
	$list .= '</div>';
	}

	$list .= $endManual;

}
/* 
// ***********************************
// end manual settings
// ***********************************
*/


/*
// ***************************
// basic  settings 
// ***************************
*/
if($basic == "yes"){
	$sum = 0 - count(explode(',', $exclude));
	foreach($tags as $tag){
		$sum += $tag;
	}
	$basicCount = 1;
	$list .= "\n<div class='holdleft' ". $tug_width .">\n";				
    $list .= '<div class="tagindex">';
	$list .="\n";
	
	foreach( $groups as $letter => $tags ) {
		if($basic_heading == 'yes'){
			$list .='<h4 id="mctm-'.$letter.'">' . apply_filters( 'the_title', $letter ) . '</h4>'."\n";
		}
		
		
	$list .= '<ul class="links">';
	$list .="\n";		
	
		uasort( $tags, create_function('$a, $b', 'return strnatcasecmp($a->name, $b->name);') ); // addded 09.02.11		
		foreach($tags as $tag){
			if(isset($tag->name)){
				if($tag_count == "yes"){
					$mctagmap_count = ' <span class="mctagmap_count">('.$tag->count.')</span>';
				}
				
				if($taxonomy){
					$url = get_term_link($tag->slug, $taxonomy);
				} elseif($show_categories == "yes"){
					$url = get_category_link($tag->term_id); 
				} else {
					$url = attribute_escape( get_tag_link( $tag->term_id ) ); 
				}
				
				$name = apply_filters( 'the_title', $tag->name );
				if($descriptions == "yes"){
					$mctagmap_description = '<span class="tagDescription">' . $tag->description . '</span>';
				}
				$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a>' . $mctagmap_count . $mctagmap_description . '</li>'."\n";
				if($basicCount == ceil($sum/$columns) + 1){
					$list .= '</ul>';
					$list .="\n";
					$list .= '</div>';
					$list .= '</div>';
					$list .= "\n<div class='holdleft' ". $tug_width .">\n";				
    				$list .= '<div class="tagindex">';
					$list .="\n";
					$list .= '<ul class="links">';
					$list .="\n";
					$basicCount = 0;
				}	
				$basicCount++;
			}	
		}
		//$list .= '<li style="background: pink">'.$basicCount.'</li>';
	} 
	$list .= '</ul>';
	$list .="\n";
	$list .= '</div>';		
	$list .= '</div>';

}
/* 
// ***********************************
// end basic settings
// ***********************************
*/

	$list .= "<div style='clear: both;'></div></div><!-- end list -->";
		}
	else $list .= '<p>Sorry, but no tags were found</p>';
	
?>
<?php

return $list;
}

add_shortcode("mctagmap", "sc_mcTagMap");
// end shortcode

// the JS and CSS

add_action('wp_head', 'mcTagMapCSSandJS');
function mcTagMapCSSandJS(){
		
$mctagmapVersionNumber = "10.0";
$mctagmapCSSpath = './wp-content/themes/'.get_template().'/multi-column-tag-map/mctagmap.css';


	
	echo "\n";
	if(file_exists($mctagmapCSSpath)){
		echo '<link rel="stylesheet" href="'.$mctagmapCSSpath.'?ver='.$mctagmapVersionNumber.'" type="text/css" media="screen" />';
	} else {
		echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/multi-column-tag-map/mctagmap.css?ver='.$mctagmapVersionNumber.'" type="text/css" media="screen" />';
	}
	echo "\n";
	echo '<script type="text/javascript" src="'.WP_PLUGIN_URL.'/multi-column-tag-map/mctagmap.js?ver='.$mctagmapVersionNumber.'"></script>';
	echo "\n\n";
}


function mctagmap_donate($links, $file) {
$plugin = plugin_basename(__FILE__);
// create link
if ($file == $plugin) {
return array_merge( $links, array( sprintf( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX8RH7F2LR74J" target="_blank">Donate to mctagmap development</a>', $plugin, __('Donate') ) ));
}
return $links;
}
add_filter( 'plugin_row_meta', 'mctagmap_donate', 10, 2 );


// overwrite single_tag_title()
add_filter('single_tag_title', 'mctagmap_single_tag_title', 1, 2);
function mctagmap_single_tag_title($prefix = '') {
	global $wp_query;
	if ( !is_tag() )
		return;

	$tag = $wp_query->get_queried_object();

	if ( ! $tag )
		return;

	$my_tag_name = str_replace('|', '', $tag->name);
	if ( !empty($my_tag_name) ) {
		if ( $display )
			echo $prefix . $my_tag_name;
		else
			return $my_tag_name;
	}
}

// overwrite single_tag_title()
add_filter('the_tags', 'mctagmap_the_tags');
function mctagmap_the_tags($mctagmapTheTags) {
    return str_replace('|', '', $mctagmapTheTags);
}

?>