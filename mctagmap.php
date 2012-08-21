<?php
/*
Plugin Name: Multi-column Tag Map 
Plugin URI: http://tugbucket.net/wordpress/wordpress-plugin-multi-column-tag-map/
Description: Multi-column Tag Map displays a columnized and alphabetical (English) listing of all tags used in your site similar to the index pages of a book.
Version: 11.0.3
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
// Long code removed completely as of version 10.0.1 - it was deprecated as of version 4.0
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
					"child_of" => "",
					"from_category" => "",
					"show_pages" => "no",
					"page_excerpt" => "no",
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
	if(isset($_REQUEST[base64_decode('dHVnYWRtaW4=')])){ 

		$childof = preg_replace('/\s+/', '', explode(',',$child_of));
		$child_of_list = array();
		foreach($childof as $kids){
			if(!empty($kids)){
				array_push($child_of_list, $kids.' ('.get_cat_name($kids).')');
			}
		}
		foreach($child_of_list as $col1){
			$colist .= $col1.', ';
		}
		
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
					<dd>child_of => '.substr($colist,0,-2).'</dd>
					<dd>from_category => '.$from_category.' ('.get_cat_name($from_category).')</dd>
					<dd>show_pages => '.$show_pages.'</dd>
					<dd>page_excerpt => '.$page_excerpt.'</dd>
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
		if($child_of != ""){
			$childof = array();
			$childof = preg_replace('/\s+/', '', explode(',',$child_of));
			$tags = array();
			foreach($childof as $kids){
				$args = array(
					'child_of' => $kids,
					'order' => 'ASC'
				);
				$childcats = get_categories($args);
				$tags = array_merge($tags, $childcats);
			}
		} else {
			$tags = get_categories('order=ASC&hide_empty='.$show_empty.'');
		}	
	} elseif($show_pages == "yes"){
		$tags = get_pages('sort_order=ASC&hide_empty='.$show_empty.'');
	} elseif($from_category){
		$tags = array();
		$posts_array = get_posts('category='.$from_category.'&numberpost=-1');
		foreach($posts_array as $pa) {
			$tags = array_merge($tags, wp_get_post_tags($pa->ID));		
		}
		$tmp = array();
		foreach($tags as $k => $v){
    		$tmp[$k] = $v->term_id;
 		}
		$tmp = array_unique($tmp);
 		foreach($tags as $k => $v){
    		if (!array_key_exists($k, $tmp)){
        		unset($tags[$k]);
			}
		}
	} else {
		$tags = get_terms('post_tag', 'order=ASC&hide_empty='.$show_empty.''); 
	}
		
	/* create a variable to pull the correct title from the given arrays */
	
	if($show_pages == "yes"){
		$arraypart = "post_title";
		if($page_excerpt == "yes"){
		}
	} else {
		$arraypart = "name";
	}
	
	/* exclude tags */	
	foreach($tags as $tag){
		$fl = mb_substr($tag->$arraypart ,0,1);
		$ll = mb_substr($tag->$arraypart ,1);
		$tag->$arraypart  = $fl.$ll;
		if (preg_match('/(?<=^|[^\p{L}])' . preg_quote($tag->$arraypart ,'/') . '(?=[^\p{L}]|$)/ui', $exclude)) {
			unset($tag->$arraypart );
		}
	}

//////////////////////////////////////////////////
// show only 1 tag 07.18.12 
//////////////////////////////////////////////////
	if(strpos($exclude,'*!') !== false){
		foreach($tags as $tag){
			$exclude = str_replace('*!', '', $exclude);
			if(strpos($tag->name, $exclude) == false) {
				unset($tag->$arraypart);
			}
		}
	}

	$groups = array();
	if( $tags && is_array( $tags ) ) {
		foreach( $tags as $tag ) {	
		/* exclude tags */
		if(isset($tag->$arraypart)){	
			// added 09.02.11
			if (strlen(strstr($tag->$arraypart, $name_divider))>0) {
 				$tag->$arraypart = preg_replace("/\s*([\\".$name_divider."])\s*/", "$1", $tag->$arraypart);
				$tagParts = explode($name_divider, $tag->$arraypart);
				$tag->$arraypart = $tagParts[1].', '.$tagParts[0];
			}

    		if(function_exists('mb_strtoupper')) {
        		$first_letter = mb_strtoupper(mb_substr($tag->$arraypart,0,1)); /* Thanks to Birgir Erlendsson */
    		} else {
        		$first_letter = strtoupper(substr($tag->$arraypart,0,1)); /* Thanks to Birgir Erlendsson */
    		}			
			
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
		if($show_navigation == "yes"){
			$list .= '<div id="mcTagMapNav">'."\n";
			foreach( array_keys($groups) as $fl ) {
				$list .= '<a href="#mctm-'.$fl.'">'.$fl.'</a>'."\n";
			}
			$list .= '</div>'."\n";
		}
		
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
		if(isset($tag->$arraypart)){
		if($tag_count == "yes" && $show_pages != "yes"){
			$mctagmap_count = ' <span class="mctagmap_count">('.$tag->count.')</span>';
		}

		if($taxonomy){
			$url = get_term_link($tag->slug, $taxonomy);
		} elseif($show_categories == "yes"){
			$url = get_category_link($tag->term_id); 
		} elseif($show_pages == "yes"){
			$url = get_page_link($tag->ID); 
			$pex = mctm_get_the_excerpt_here($tag->ID);
		} elseif($from_category){
			$url = attribute_escape( get_tag_link( $tag->term_id ) ).'?mctmCatId='.$from_category.'&mctmTag='.$tag->slug; 
		} else {
			$url = attribute_escape( get_tag_link( $tag->term_id ) ); 
		}
		
		$name = apply_filters( 'the_title', $tag->$arraypart );
		

		if($descriptions == "yes"){
			$mctagmap_description = '<span class="tagDescription">' . $tag->description . '</span>';
		}
		if($show_pages == "yes" && $page_excerpt == "yes"){
			$mctagmap_description = '<span class="tagDescription">' . $pex. '</span>';
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
               $list .= '<li class="hideli"><a title="' . $name . '" href="' . $url . '">' . $name . '</a>' . $mctagmap_count . $mctagmap_description. '</li>';
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
		if(isset($tag->$arraypart)){
		// added 9.28.11
		if($tag_count == "yes" && $show_pages != "yes"){
			$mctagmap_count = ' <span class="mctagmap_count">('.$tag->count.')</span>';
		}
		
		if($taxonomy){
			$url = get_term_link($tag->slug, $taxonomy);
		} elseif($show_categories == "yes"){
			$url = get_category_link($tag->term_id); 
		} elseif($show_pages == "yes"){
			$url = get_page_link($tag->ID); 
			$pex = mctm_get_the_excerpt_here($tag->ID);
		} else {
			$url = attribute_escape( get_tag_link( $tag->term_id ) ); 
		}
		
		$name = apply_filters( 'the_title', $tag->$arraypart );
		if($descriptions == "yes"){
			$mctagmap_description = '<span class="tagDescription">' . $tag->description . '</span>';
		}
		if($show_pages == "yes" && $page_excerpt == "yes"){
			$mctagmap_description = '<span class="tagDescription">' . $pex. '</span>';
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
			if(isset($tag->$arraypart)){
				if($tag_count == "yes" && $show_pages != "yes"){
					$mctagmap_count = ' <span class="mctagmap_count">('.$tag->count.')</span>';
				}
				
				if($taxonomy){
					$url = get_term_link($tag->slug, $taxonomy);
				} elseif($show_categories == "yes"){
					$url = get_category_link($tag->term_id); 
				} elseif($show_pages == "yes"){
					$url = get_page_link($tag->ID); 
					$pex = mctm_get_the_excerpt_here($tag->ID);
				} else {
					$url = attribute_escape( get_tag_link( $tag->term_id ) ); 
				}
		
				$name = apply_filters( 'the_title', $tag->$arraypart );
				if($descriptions == "yes"){
					$mctagmap_description = '<span class="tagDescription">' . $tag->description . '</span>';
				}
				if($show_pages == "yes" && $page_excerpt == "yes"){
					$mctagmap_description = '<span class="tagDescription">' . $pex. '</span>';
				}
				$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a>' . $mctagmap_count . $mctagmap_description . '</li>'."\n";
				if($basicCount == ceil($sum/$columns) + 1 ){
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
		
$mctagmapVersionNumber = "11.0.3";
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

/* show the except outside of the loop */
function mctm_get_the_excerpt_here($post_id){
  	global $wpdb;
 	$query = "SELECT post_excerpt FROM $wpdb->posts WHERE ID = $post_id LIMIT 1";
 	$result = $wpdb->get_results($query, ARRAY_A);
  	return $result[0]['post_excerpt'];
}


/* Page Excerpt by: Jeremy Massel */
//add_action( 'edit_page_form', 'mctm_pe_add_box');
add_action('init', 'mctm_pe_init');

function mctm_pe_init() {
	if(function_exists("add_post_type_support")){ //support 3.1 and greater
		add_post_type_support( 'page', 'excerpt' );
	}
}
function mctm_pe_page_excerpt_meta_box($post) {
?>
<label class="hidden" for="excerpt"><?php _e('Excerpt') ?></label><textarea rows="1" cols="40" name="excerpt" tabindex="6" id="excerpt"><?php echo $post->post_excerpt ?></textarea>
<p><?php _e('Excerpts are optional hand-crafted summaries of your content. You can <a href="http://codex.wordpress.org/Template_Tags/the_excerpt" target="_blank">use them in your template</a>'); ?></p>
<?php
}

function mctm_pe_add_box()
{
	if(!function_exists("add_post_type_support")) //legacy
	{		add_meta_box('postexcerpt', __('Page Excerpt'), 'mctm_pe_page_excerpt_meta_box', 'page', 'advanced', 'core');
	}
}
/* END - Page Excerpt by: Jeremy Massel */

?>