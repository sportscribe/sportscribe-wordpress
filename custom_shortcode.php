<?php


function ss_header_img_function() {
  $post = get_post();
  if($post && get_option('sportscribe_use_header_img')) {
    $img = get_post_meta( $post->ID , 'ss_meta_match_img', true);
    return $img ? "<img src='$img'/>" : '';
  } else {
    return '';
  }
}


add_shortcode('ss_header_img', 'ss_header_img_function');

?>
