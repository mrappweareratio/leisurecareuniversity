<?php

// We need to be able to figure out the attributes of a wrapped shortcode
function bs_attribute_map($str, $att = null) {
    $res = array();
    $return = array();
    $reg = get_shortcode_regex();
    preg_match_all('~'.$reg.'~',$str, $matches);
    foreach($matches[2] as $key => $name) {
        $parsed = shortcode_parse_atts($matches[3][$key]);
        $parsed = is_array($parsed) ? $parsed : array();

            $res[$name] = $parsed;
            $return[] = $res;
        }
    return $return;
}

// Font Awesome Shortcodes
function addscFontAwesome($atts) {
	extract(shortcode_atts(array(
	'type'  => '',
	'size' => '',
	'rotate' => '',
	'flip' => '',
	'pull' => '',
	'spin' => 'false',
 
	), $atts));
     
	$type = ($type) ? 'fa fa-'.$type. '' : 'fa-star';
	$size = ($size) ? 'fa-'.$size. '' : '';
	$rotate = ($rotate) ? 'fa-rotate-'.$rotate. '' : '';
	$flip = ($flip) ? 'fa-flip-'.$flip. '' : '';
	$pull = ($pull) ? 'pull-'.$pull. '' : '';
	$spin = ($spin = 'true') ? 'fa-spin' : '';
 
	$theAwesomeFont = '<i class="'.($type).' '.($size).' '.($rotate).' '.($flip).' '.($pull).' '.($animated).'"></i>';

	return $theAwesomeFont;
}

add_shortcode('icon', 'addscFontAwesome');


// Buttons Shortcodes
function scbuttons($atts) {
	extract(shortcode_atts(array(
	'size'  => '',
	'corners' => '',
	'color' => '',
	'text' => '',
	'href' => '',
	), $atts));

	$classes = "btn";
	$size = ($size) ? ' btn-'.$size. '' : 'btn-small';
	$corners = ($corners) ? ' btn-'.$corners. '' : 'btn-round';
	$color = ($color) ? ' btn-'.$color. '' : 'btn-red';
	$classes .= $size.$corners.$color;
 
	$button = '<a class="'.$classes.'" href="'.$href.'" >'.$text.'</a>';
     
	return $button;
}
add_shortcode('button', 'scbuttons');



// Pretty Bootstrap Columns shortcode
function pretty_col($atts, $content = null) {
	extract(shortcode_atts(array(
		'icon' => '',
		'title' => '',
		'link' => '',
		'columns' => '',
		'offset' => '',
		'breakpoint' => ''
	), $atts));

	if ($link != '') {
		$anchor = '<h2><a href="'.$link.'">'.$title.'</a></h2>';
	} else {
		$anchor = '<h2>'.$title.'</h2>';
	}

	if ($breakpoint != '') {
		$break = $breakpoint;
	} else {
		$break= 'md';
	}

	if ($offset != '') {
		$offcol = ' col-'.$break.'-offset-'.$offset;
	} else {
		$offcol = '';
	}

	$return_string = '';
	$return_string = '<div class="col-'.$break.'-'.$columns.$offcol.' service-column">';
	$return_string .= '<figure class="service-icon"><i class="fa fa-'.$icon.'"></i></figure>';
	$return_string .= $anchor;
	$return_string .= '<p class="service-description">'.$content.'</p></div>';

	return $return_string;
}
add_shortcode('prettycol', 'pretty_col');


// Bootstrap columns
function bootstrapColumns($atts, $content = null) {
	extract(shortcode_atts(array(
		'columns' => '',
		'offset' => '',
		'breakpoint' => ''
	), $atts));

	$col = '<div class="col-'.$breakpoint.'-'.$columns;
	$off = ' col-'.$breakpoint.'-offset-'.$offset.'"';
	$string = $col.$off.'>'.do_shortcode($content).'</div>';

	return $string;
}
add_shortcode('col', 'bootstrapColumns');


// Row shortcode - wrap any columns into this shortcode
function row($atts, $content = null) {

	$return_string = '<div class="row">'.do_shortcode($content).'</div>';

	return $return_string;
}
add_shortcode("row", "row");


// Bootstrap Tabs Shortcode
function tabs( $atts, $content = null ) {

	if( isset( $GLOBALS['tabs_count'] ) )
		$GLOBALS['tabs_count']++;
	else
		$GLOBALS['tabs_count'] = 0;

	$GLOBALS['tabs_default_count'] = 0;
      
	extract( shortcode_atts( array(
		"type"   => false,
		"xclass" => false
	), $atts ) );
 
	$ul_class  = 'nav';
	$ul_class .= ( $type )     ? ' nav-' . $type : ' nav-tabs';
	$ul_class .= ( $xclass )   ? ' ' . $xclass : '';

	$div_class = 'tab-content';

	$id = 'custom-tabs-'. $GLOBALS['tabs_count'];

	$atts_map = bs_attribute_map( $content );

	// Extract the tab titles for use in the tab widget.
	if ( $atts_map ) {
		$tabs = array();
		$GLOBALS['tabs_default_active'] = true;
		foreach( $atts_map as $check ) {
			if( !empty($check["tab"]["active"]) ) {
				$GLOBALS['tabs_default_active'] = false;
			}
		}
		$i = 0;
		foreach( $atts_map as $tab ) {
			$tabs[] = sprintf(
				'<li%s><a href="#%s" data-toggle="tab">%s</a></li>',
				( !empty($tab["tab"]["active"]) || ($GLOBALS['tabs_default_active'] && $i == 0) ) ? ' class="active"' : '',
				'custom-tab-' . $GLOBALS['tabs_count'] . '-' . sanitize_title( $tab["tab"]["title"] ),
				$tab["tab"]["title"]
			);
			$i++;
		}
	}

	$ul_class = esc_attr( $ul_class );
	$id = esc_attr( $id );
	$tabs = ( $tabs )  ? implode( $tabs ) : '';
	$div_class = esc_attr( $div_class );
	
	$output = '<ul class="'.$ul_class.'" id="'.$id.'">'.$tabs.'</ul><div class="'.$div_class.'">'.do_shortcode( $content ).'</div>';

	return $output;
}
add_shortcode("tabs", "tabs");


// Bootstrap Tab Shortcode
function tab( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'title'   => false,
		'active'  => false,
		'fade'    => false,
		'xclass'  => false,
	), $atts ) );
    
	if( $GLOBALS['tabs_default_active'] && $GLOBALS['tabs_default_count'] == 0 ) {
		$active = true;
	}
	$GLOBALS['tabs_default_count']++;

	$class  = 'tab-pane';
	$class .= ( $fade )            ? ' fade' : '';
	$class .= ( $active )          ? ' active' : '';
	$class .= ( $active && $fade ) ? ' in' : '';

	$id = 'custom-tab-'. $GLOBALS['tabs_count'] . '-'. sanitize_title( $title );

	return sprintf( 
		'<div id="%s" class="%s">%s</div>',
		esc_attr( $id ),
		esc_attr( $class ),
		do_shortcode( $content )
	);

}
add_shortcode("tab", "tab");


// Bootstrap Collapsible Shortcode - use it with Collapse shortcode
function collapsibles( $atts, $content = null ) {

	if( isset($GLOBALS['collapsibles_count']) )
		$GLOBALS['collapsibles_count']++;
	else
		$GLOBALS['collapsibles_count'] = 0;

	extract( shortcode_atts( array(
		"xclass" => false
	), $atts ) );
      
	$class = 'panel-group';
	$class .= ( $xclass )   ? ' ' . $xclass : '';

	$id = 'custom-collapse-'. $GLOBALS['collapsibles_count'];

	return sprintf( 
		'<div class="%s" id="%s"%s>%s</div>',
		esc_attr( $class ),
		esc_attr( $id ),
		( $data_props ) ? ' ' . $data_props : '',
		do_shortcode( $content )
	);

}
add_shortcode("collapsibles", "collapsibles");


// Bootstrap Collapse Shortcode - use it with Collapsible shortcode
function collapse( $atts, $content = null ) {

	extract( shortcode_atts( array(
		"title"   => false,
		"type"    => false,
		"active"  => false,
		"xclass"  => false,
	), $atts ) );

	$panel_class = 'panel';
	$panel_class .= ( $type )     ? ' panel-' . $type : ' panel-default';
	$panel_class .= ( $xclass )   ? ' ' . $xclass : '';

	$collapse_class = 'panel-collapse';
	$collapse_class .= ( $active )  ? ' in' : ' collapse';

	$parent = 'custom-collapse-'. $GLOBALS['collapsibles_count'];
	$current_collapse = $parent . '-'. sanitize_title( $title );
      
	return sprintf( 
		'<div class="%1$s"%2$s>
			<div class="panel-heading">
				<h4 class="panel-title">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#%3$s" href="#%4$s">%5$s</a>
				</h4>
			</div>
			<div id="%4$s" class="%6$s">
				<div class="panel-body">%7$s</div>
			</div>
		</div>',
		esc_attr( $panel_class ),
		( $data_props ) ? ' ' . $data_props : '',
		$parent,
		$current_collapse,
		$title,
		esc_attr( $collapse_class ),
		do_shortcode( $content )
	);
}
add_shortcode("collapse", "collapse");


// Google Map shortcode
function googleMap($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => 'myMap',
		"type" => 'road',
		"latitude" => '36.394757',
		"longitude" => '-105.600586',
		"zoom" => '16',
		"message" => 'This is the message...',
		"width" => '100%',
		"height" => '400',
		"hue" => ''
	), $atts));

	$mapType = '';
	if($type == "satellite") 
		$mapType = "SATELLITE";
	else if($type == "terrain")
		$mapType = "TERRAIN";  
	else if($type == "hybrid")
		$mapType = "HYBRID";
	else
		$mapType = "ROADMAP";  

echo '<!-- Google Map -->
	<script type="text/javascript">  
		jQuery(document).ready(function() {

			function initializeGoogleMap() {
				var myLatlng = new google.maps.LatLng('.$latitude.','.$longitude.');
				var myOptions = {
					center: myLatlng,  
					zoom: '.$zoom.',
					mapTypeControl: false,
					mapTypeId: google.maps.MapTypeId.'.$mapType.',
					panControl: false,
					zoomControl: true,
					scaleControl: true,
					streetViewControl: false,
					scrollwheel: false
				};

			var styles = [{
				stylers: [
					{ hue: "'.$hue.'" },
					{ saturation: -20 }
				]},{
				featureType: "road",
				elementType: "geometry",
				stylers: [
					{ lightness: 100 },
					{ visibility: "simplified" }
				]
			}];

			var map = new google.maps.Map(document.getElementById("'.$id.'"), myOptions);
			map.setOptions({styles: styles});

			var contentString = "'.$message.'";
			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			var marker = new google.maps.Marker({
				position: myLatlng,
				center: myLatlng
			});

			google.maps.event.addListener(marker, "click", function() {
				infowindow.open(map,marker);
			});

			google.maps.event.addDomListener(window, "resize", function() {
				map.setCenter(myLatlng);
			});

			marker.setMap(map);

			}
			initializeGoogleMap();

		});
	</script>';

return '<div id="'.$id.'" style="width:'.$width.'px; height:'.$height.'px;" class="googleMap"></div>';
}
add_shortcode('googlemap','googleMap');

?>