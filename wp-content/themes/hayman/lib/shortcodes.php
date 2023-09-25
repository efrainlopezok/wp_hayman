<?php

add_shortcode( 'button' , 'button_function');

function button_function( $atts, $content ) {
	$out 	=	'';
	$a = shortcode_atts( array(
		'align' => 'center',
		'color' => 'black',
		'link'   => '#'
	), $atts );

	$out = "<p class='button-txt' style='text-align:".$a['align']."'><a class='btn btn-".$a[color]."' href='$a[link]' >$content</a></p>";
	return $out;
}


add_shortcode( 'icon' , 'icon_function');

function icon_function( $atts, $content ) {
	$out 	=	'';
	$a = shortcode_atts( array(
		'i' => 'default',
	), $atts );

	$out = "<div class='icon-service'><i class='icon icon-".$a['i']."'></i> <div class='icon-description'>".do_shortcode($content).'</div></div>';
	return $out;
}



add_shortcode( 'gallery_image', 'gallery_image_function');

function gallery_image_function($atts, $content) {
	$images = get_field('gallery_images', $atts['id_gallery']);
	$size = 'full';
	if( $images ): ?>
	<div class="gallery-slider">
		<?php foreach( $images as $image ): ?>
			<div class="item-slide" style="background-image: url(<?php echo wp_get_attachment_image_src( $image['ID'], $size )[0];?>);"></div>
		<?php endforeach; ?>
	</div>

<?php endif;
}

add_shortcode( 'membership', 'membership_function');

function membership_function($atts, $content) {
	$rows = get_field('membership_plan', 'option');
	$first = 0;
	if($rows) {
		echo '<div class="feature">';
		foreach($rows as $row) {
			$plans = $row['plan'];
			$best_plan = $plans['best_plan'];
			if($best_plan && $best_plan[0] == "yes") {
				$best_plan = 'best-plan';
			}
			if($first == 0) 
				echo '<div class="feature-wrap one-third first '.$best_plan.'">';
			else 
				echo '<div class="feature-wrap one-third '.$best_plan.'">';
			echo '<div style="background-color: '.$plans['plan_color'].'">';
			echo '<h6>'.$plans['short_title'].'</h6>';
			echo '<h3>'.$plans['title'].'</h3>';
			echo '<div class="membership-img"><img src="'.$plans['plan_image'].'"></div>';
			echo '<p>'.$plans['title_description'].'</p>';
			echo '<h2>'.$plans['price'].'</h2>';
			echo '<p>'.$plans['price_description'].'</p>';
			$features = $plans['features'];
			if($features) {
				echo '<ul class="features-list">';
				foreach($features as $feature) {
					if($feature['feature']) {
						echo '<li><i class="fa fa-check" aria-hidden="true"></i>'.$feature['feature'].'</li>';	
					}
					else {
						echo '<li>&nbsp;</li>';
					}
					
				}
				echo '</ul>';
			}
			echo '<h5>'.$plans['title_rate'].'</h5>';
			$rates = $plans['rates'];
			if($rates) {
				echo '<ul class="rates">';
				foreach ($rates as $rate) {
					echo '<li>'.$rate['vibe_rate'].'</li>';
				}
				echo '</ul>';
			}
			echo '<a href="'.$plans['button_link'].'" target="'.$plans['button_target'].'" class="btn btn-'.$plans['button_color'].'">'.$plans['button_text'].'</a>';
			echo '</div>';
			echo '<div class="plan_description">'.$plans['plan_description'].'</div>';
			echo '</div>';
			$first++;
		}
		echo '</div>';
	}
}

add_shortcode('testimonial' , 'testimonial_function');

function testimonial_function($atts, $content) {
	$out = '';
	$a = shortcode_atts( array(
		'id' => '',
	), $atts );

	if($a['id'] != '') {
		$testimonial 	=	get_post($a['id']);
		if($testimonial) {
			$testimonial_list	=	get_field('testimonial_list',$testimonial->ID);

			$out 			.= '<div class="testimonial-slider">';
			foreach ($testimonial_list as $tst) {
				$author_name	=	$tst['author_name'];
				$ocupation		=	$tst['ocupation'];
				$author_picture	=	$tst['author_picture'];
				$description	=	$tst['description'];
				$out 			.= '<div class="item-slide">';	
				$out 		.= '<div class="testimonial_picture" style="background-image: url('.$author_picture.')">';
				$out 		.= '</div>';
				$out 		.= '<div class="testimonial_description">';
				$out 	.= do_shortcode($description);
				$out 		.= '</div>';
				$out 		.= '<div class="testimonial_info">';
				$out 	.= '<h5>- '.$author_name.'</h5>';
				$out 	.= '<span>'.$ocupation.'</span>';
				$out 		.= '</div>';
				$out 			.= '</div>';
			}
			
			$out 			.= '</div>';
		} else {
			$out .= 'Not found';
		}
	}
	return $out;
}

function dropdown_option($atts) {
	$dropid = (isset($atts['dropid'])) ? $atts['dropid'] : '';
	global $sco_array;
	if (!empty($atts['value']) && !empty($atts['text'])) {
		$sco_array[$dropid][$atts['value']] = $atts['text'];
	}
}
add_shortcode('dropdown','dropdown_option');

function sc_dropdown($atts) {
	$id = (isset($atts['id'])) ? $atts['id'] : 'sc_dropdown';
	$dropid = (isset($atts['dropid'])) ? $atts['dropid'] : '';
	global $sco_array;
	$sel = '';
	if (!empty($sco_array[$dropid])) {
		$sel .= '<span class="select-wrap"><select id="'.$id.'" >';
		$sel .= '<option value="option0">Neque Porro Quisquam</option>';
		foreach($sco_array[$dropid] as $k=>$v) {
			$sel .= '<option value="'.$k.'">'.$v.'</option>';
		}
		$sel .= '</select></span>';
	}
	return $sel;
}
add_shortcode('dropdownend','sc_dropdown');

//Shortocdes for the Landing Page
add_shortcode('service', 'service_function');
function service_function($atts, $content) {
	$out = '';
	$out .= '<div class="service-box">';
	$out .= '<i class="icon ico-'.$atts['ico'].'"></i>';
	$out .= do_shortcode($content);
	$out .= '</div>';
	return $out;
}

add_shortcode('pricing','pricing_function');
function pricing_function($atts, $content) {
	$out = '';
	$out .= '<div class="pricing_box">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	return $out;
}

add_shortcode('pricing_image','pricing_image_function');
function pricing_image_function($atts, $content) {
	$str = $content;
	preg_match('/(src=["\'](.*?)["\'])/', $str, $match);  //find src="X" or src='X'
	$split = preg_split('/["\']/', $match[0]); // split by quotes
	$src = $split[1]; // X between quotes
	$out = '';
	$out .= '<div class="pricing_image" style="background-image:url('.$src.')">';
	$out .= '</div>';
	return $out;
}

add_shortcode('pricing_content','pricing_content_function');
function pricing_content_function($atts, $content) {
	$out = '';
	$out .= '<div class="pricing_content">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	return $out;
}

add_shortcode('testimonial_grid','testimonial_grid_function');

function testimonial_grid_function($atts, $content) {
	$out = '';
	$a = shortcode_atts( array(
		'id' => '',
	), $atts );

	if($a['id'] != '') {
		$testimonial 	=	get_post($a['id']);
		if($testimonial) {
			$testimonial_list	=	get_field('testimonial_list',$testimonial->ID);
			$flag = 1;
			$first = '';
			$out 			.= '<div class="testimonial-grid">';
			foreach ($testimonial_list as $tst) {
				if($flag == 1) 
					$first = ' first';
				else
					$first = '';
				$author_name	=	$tst['author_name'];
				$ocupation		=	$tst['ocupation'];
				$author_picture	=	$tst['author_picture'];
				$description	=	$tst['description'];
				$out 			.= '<div class="item-grid one-half'.$first.'">';	
				$out 		.= '<div class="testimonial_picture" style="background-image: url('.$author_picture.')">';
				$out 		.= '</div>';
				$out 		.= '<div class="testimonial_description">';
				$out 	.= do_shortcode($description);
				$out 	.= '<h5>'.$author_name.'</h5>';
				$out 		.= '</div>';
				$out 			.= '</div>';
				$flag++;
				if($flag == 3) $flag = 1; 
			}
			
			$out 			.= '</div>';
		} else {
			$out .= 'Not found';
		}
	}
	return $out;
}

add_shortcode( 'gallery_mansory', 'gallery_mansory_function');

function gallery_mansory_function($atts, $content) {
	$images = get_field('gallery_images', $atts['id_gallery']);
	$size = '';
	$hide = '';
	$out = '';
	$i=1;
	if( $images ): 
		$out .= '<div class="grid">';
		foreach( $images as $image ): 
			$url = wp_get_attachment_image_src( $image['ID'], $size )[0];
			if($i == 1 || $i == 4) 
				$size = ' w1';
			if($i == 2) 
				$size = ' w2';
			if($i == 3 || $i == 6) 
				$size = ' w3';
			if($i == 5) 
				$size = ' w4';
			$out .= '<div class="grid-item '.$size.$hide.'" style="background-image: url('.$url.')" data-mfp-src="'.$url.'">';
			$out .= '<div class="grid-hover">';
			$out .= '<div class="content-center">';
			$out .= $image['description'];
			$out .= '</div>';
			$out .= '</div>';
			$out .= '</div>';
			$i++;
			if($i==7) {
				$i = 1;
				$hide = ' hide';
			}
		endforeach; 
		$out .= '</div>';
	endif;	
	return $out;
}

/* gallery mansory mobile */
add_shortcode( 'gallery_mansory_mobile', 'gallery_mansory_mobile_function');

function gallery_mansory_mobile_function($atts, $content) {
	$images = get_field('gallery_images', $atts['id_gallery']);
	$size = '';
	$hide = '';
	$out = '';
	// $i=1;
	if( $images ): 
		$out .= '<div class="grid-slide">';
		foreach( $images as $image ): 
			$url = wp_get_attachment_image_src( $image['ID'], $size )[0];
			// if($i == 1 || $i == 4) 
			// 	$size = ' w1';
			// if($i == 2) 
			// 	$size = ' w2';
			// if($i == 3 || $i == 6) 
			// 	$size = ' w3';
			// if($i == 5) 
			// 	$size = ' w4';
			$out .= '<div class="grid-item '.$size.$hide.'" style="background-image: url('.$url.')" data-mfp-src="'.$url.'">';
			$out .= '<div class="grid-hover">';
			$out .= '<div class="content-center">';
			$out .= $image['description'];
			$out .= '</div>';
			$out .= '</div>';
			$out .= '</div>';
			// $i++;
			// if($i==7) {
			// 	$i = 1;
			// 	$hide = ' hide';
			// }
		endforeach; 
		$out .= '</div>';
	endif;	
	return $out;
}

/*Amenities*/
add_shortcode('amenities','amenities_grid_function');

function amenities_grid_function($atts, $content) {
	$out = '';
	$a = shortcode_atts( array(
		'id' => '',
	), $atts );

	$out .= '<div class="am-slide">';
	if( have_rows('amenities_slider') ):
		while ( have_rows('amenities_slider') ) : the_row();
			$out .= '<div class="slide-amenities"><div class="cont-amenites" style="background-position: center;background-size:cover;background-image:url('.get_sub_field('am_image').')"></div>';
			$out .= '<p>'.get_sub_field('am_title').'<p></div>';
		endwhile;               
	endif;
	$out .= '</div>';
	return $out;
}
