<?php
function enqueue_admin()
{
    ?>
<style>
    
    li#wp-admin-bar-flatsome-activate
    {
        display: none;
    }
</style>
    <?php 
}
add_action( 'admin_head', 'enqueue_admin' ) ;
add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
//include_once('PhpSpreadsheet/vendor/autoload.php');
function mycustom_wpcf7_form_elements( $form ) {
	$form = do_shortcode( $form );

	return $form;
}
function mh_load_theme_style() {
	if ( !is_user_logged_in() ) {
	wp_dequeue_script('wc-password-strength-meter');
    wp_deregister_script('wc-password-strength-meter');
	}
	
	/* Add Font Awesome */
	wp_register_style( 'font-awesome', get_stylesheet_directory_uri() . '/fonts/css/all.min.css', false, false );
	wp_enqueue_style( 'font-awesome' );
	wp_register_script( 'mnfixed', get_stylesheet_directory_uri() . '/mnfixed.js', false, false );
	wp_enqueue_script( 'mnfixed' );
	
	wp_register_script( 'mh-js', get_stylesheet_directory_uri() . '/custom.js', false, false );
	wp_enqueue_script( 'mh-js' );
	//wp_dequeue_script('product-frontend');
	//wp_deregister_script('product-frontend');
	//wp_dequeue_script('shop-frontend');
	//wp_deregister_script('shop-frontend');
}
add_action( 'wp_enqueue_scripts', 'mh_load_theme_style', 998999 );
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Tùy chỉnh khác',
		'menu_title'	=> 'Tùy chỉnh khác',
		'menu_slug' 	=> 'Tùy chỉnh khác',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}
function disable_plugin_updates( $value ) {
  if ( isset($value) && is_object($value) ) {
    if ( isset( $value->response['advanced-custom-fields-pro/acf.php'] ) ) {
      unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    }
  }
  return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );

// Code đếm số dòng trong văn bản
function count_paragraph( $insertion, $paragraph_id, $content ) {
        $closing_p = '</p>';
        $paragraphs = explode( $closing_p, $content );
        foreach ($paragraphs as $index => $paragraph) {
                if ( trim( $paragraph ) ) {
                        $paragraphs[$index] .= $closing_p;
                }
                if ( $paragraph_id == $index + 1 ) {
                        $paragraphs[$index] .= $insertion;
                }
        }
 
        return implode( '', $paragraphs );
}
 
//Chèn bài liên quan vào giữa nội dung
 
// add_filter( 'the_content', 'prefix_insert_post_ads' );
 
// function prefix_insert_post_ads( $content ) {
 
//         $related_posts= "<div class='meta-related'>".do_shortcode('[related_posts_by_tax title=""]')."</div>";
 
//         if ( is_single() ) {
//                 return count_paragraph( $related_posts, 1, $content );
//         }
 
//         return $content;
// }
// add taxonomy nhu cau
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 ); 
// add taxonomy huong ban cong
add_action( 'init', 'custom_taxonomy_chu_dau_tu' );
function custom_taxonomy_chu_dau_tu()  {
$labels = array(
    'name'                       => 'Chủ đầu tư',
    'singular_name'              => 'Chủ đầu tư',
    'menu_name'                  => 'Chủ đầu tư',
    'all_items'                  => 'Chủ đầu tư',
    'new_item_name'              => 'Chủ đầu tư',
    'add_new_item'               => 'Thêm Chủ đầu tư',
    'edit_item'                  => 'Sửa Chủ đầu tư',
    'update_item'                => 'Cập Chủ đầu tư',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'chu-dau-tu', 'product', $args );
register_taxonomy_for_object_type( 'chu-dau-tu', 'product' );
}
add_action( 'init', 'custom_taxonomy_Item' );
function custom_taxonomy_Item()  {
$labels = array(
    'name'                       => 'Loại bất động sản',
    'singular_name'              => 'Loại bất động sản',
    'menu_name'                  => 'Loại bất động sản',
    'all_items'                  => 'Loại bất động sản',
    'parent_item'                => 'Cha',
    'parent_item_colon'          => 'Cha:',
    'new_item_name'              => 'Loại bất động sản mới',
    'add_new_item'               => 'Thêm loại bất động sản',
    'edit_item'                  => 'Sửa loại bất động sản',
    'update_item'                => 'Cập nhật loại bất động sản',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'bat-dong-san', 'product', $args );
register_taxonomy_for_object_type( 'bat-dong-san', 'product' );
}
add_action( 'init', 'custom_taxonomy_khuvuc' );
function custom_taxonomy_khuvuc()  {
$labels = array(
    'name'                       => 'Khu vực',
    'singular_name'              => 'Khu vực',
    'menu_name'                  => 'Khu vực',
    'all_items'                  => 'Khu vực',
    'parent_item'                => 'Cha',
    'parent_item_colon'          => 'Cha:',
    'new_item_name'              => 'Khu vực mới',
    'add_new_item'               => 'Thêm Khu vực',
    'edit_item'                  => 'Sửa Khu vực',
    'update_item'                => 'Cập nhật Khu vực',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'khu-vuc', 'product', $args );
register_taxonomy_for_object_type( 'khu-vuc', 'product' );
}
// add taxonomy khoang gia
add_action( 'init', 'custom_taxonomy_kg' );
function custom_taxonomy_kg()  {
$labels = array(
    'name'                       => 'Khoảng Giá',
    'singular_name'              => 'Khoảng Giá',
    'menu_name'                  => 'Khoảng Giá',
    'all_items'                  => 'Khoảng Giá',
    'parent_item'                => 'Khoảng Giá cha',
    'parent_item_colon'          => 'Khoảng Giá cha:',
    'new_item_name'              => 'Khoảng Giá mới',
    'add_new_item'               => 'Thêm Khoảng Giá',
    'edit_item'                  => 'Sửa Khoảng Giá',
    'update_item'                => 'Cập nhật Khoảng Giá',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'khoang-gia', 'product', $args );
register_taxonomy_for_object_type( 'khoang-gia', 'product' );
}
// add taxonomy so phong ngu
add_action( 'init', 'custom_taxonomy_pn' );
function custom_taxonomy_pn()  {
$labels = array(
    'name'                       => 'Số Phòng Ngủ',
    'singular_name'              => 'Số Phòng Ngủ',
    'menu_name'                  => 'Số Phòng Ngủ',
    'all_items'                  => 'Tất cả Số Phòng Ngủ',
    'new_item_name'              => 'Số Phòng Ngủ mới',
    'add_new_item'               => 'Thêm Số Phòng Ngủ',
    'edit_item'                  => 'Sửa Số Phòng Ngủ',
    'update_item'                => 'Cập nhật Số Phòng Ngủ',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'phong-ngu', 'product', $args );
register_taxonomy_for_object_type( 'phong-ngu', 'product' );
}
// add taxonomy huong ban cong
add_action( 'init', 'custom_taxonomy_huong' );
function custom_taxonomy_huong()  {
$labels = array(
    'name'                       => 'Hướng ban công',
    'singular_name'              => 'Hướng ban công',
    'menu_name'                  => 'Hướng ban công',
    'all_items'                  => 'Hướng ban công',
    'new_item_name'              => 'Hướng ban công mới',
    'add_new_item'               => 'Thêm Hướng ban công',
    'edit_item'                  => 'Sửa Hướng ban công',
    'update_item'                => 'Cập nhật Hướng ban công',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'huong-ban-cong', 'product', $args );
register_taxonomy_for_object_type( 'huong-ban-cong', 'product' );
}
//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'crunchify_disable_woocommerce_loading_css_js' );
 
function crunchify_disable_woocommerce_loading_css_js() {
 
	// Check if WooCommerce plugin is active
	if( function_exists( 'is_woocommerce' ) ){
 
		// Check if it's any of WooCommerce page
		if(! is_woocommerce() && ! is_cart() && ! is_checkout() ) { 		
			
			## Dequeue WooCommerce styles
			wp_dequeue_style('woocommerce-layout'); 
			wp_dequeue_style('woocommerce-general'); 
			wp_dequeue_style('woocommerce-smallscreen'); 	
 
			## Dequeue WooCommerce scripts
			wp_dequeue_script('wc-cart-fragments');
			wp_dequeue_script('woocommerce'); 
			wp_dequeue_script('wc-add-to-cart'); 
		
			wp_deregister_script( 'js-cookie' );
			wp_dequeue_script( 'js-cookie' );
 
		}
	}	
}
add_action('flatsome_product_box_after','thongtin_them_loop');
function thongtin_them_loop(){
	global $post, $product;
	$terms_khu_vuc = get_the_terms( $post->ID, 'khu-vuc' );
    $terms_category = get_the_terms( $post->ID, 'product_cat' );
$term_category = null;	
	if ( ! empty( $terms_category ) && ! is_wp_error( $terms_category ) ) {
		$term_category = $terms_category[0];
	}
$terms_khu_vuc_parent = null;
$terms_khu_vuc_child = null;
$link_khuvuc_parent =  '';
$link_khuvuc_parent =  '';
$text_link_khuvuc_parent = '';
$text_link_khuvuc_child = '';
if ( ! empty( $terms_khu_vuc ) && ! is_wp_error( $terms_khu_vuc ) ) {
foreach ( $terms_khu_vuc as $term ){
    if ( $term->parent == 0) {
		
		$terms_khu_vuc_parent = $term;
		
	}
	else{$terms_khu_vuc_child = $term;}
	
	
}
	$link_khuvuc_parent =  '/?khu-vuc='. $terms_khu_vuc_parent->slug . ($term_category!=null?'&product_cat='.$term_category->slug:'') ; 
	$link_khuvuc_child =  '/?khu-vuc='. $terms_khu_vuc_child->slug . ($term_category!=null?'&product_cat='.$term_category->slug:'') ; 
	$text_link_khuvuc_parent = ($term_category!= null? 'Tất cả '.$term_category->name. ' tại ':'Tất cả bất động sản tại ') . $terms_khu_vuc_parent->name;
	$text_link_khuvuc_child = ($term_category!= null? 'Tất cả '.$term_category->name. ' tại ':'Tất cả bất động sản tại ') . $terms_khu_vuc_child->name .', '. $terms_khu_vuc_parent->name;
}
	 
	$la_du_an = get_field('la_du_an');
	if($la_du_an==true){ ?>
		<div class="tt_them">
		    <div class="listing-address">
						<?php	if ( ! empty( $terms_khu_vuc_parent ) && ! is_wp_error( $terms_khu_vuc_parent ) ) { ?>
		<i class="icon-map-pin-fill"></i> <b>Địa chỉ:</b> <a href="<?php echo $link_khuvuc_parent ; ?>" title="<?php echo $text_link_khuvuc_parent; ?>"><?php echo $terms_khu_vuc_parent->name; ?></a>
		<?php	if ( ! empty( $terms_khu_vuc_child ) && ! is_wp_error( $terms_khu_vuc_child ) ) { ?> , <a  href="<?php echo $link_khuvuc_child ; ?>" title="<?php echo $text_link_khuvuc_child; ?>"><?php echo $terms_khu_vuc_child->name; ?></a><?php }?>
		
		<?php } ?>
			</div>
				<ul class="list-project list-pro<?php echo ($la_du_an==true?' la-du-an':''); ?>">
				    <li><i class="far fa-building"></i> <b>Loại hình:</b> <?php the_field('loai_hinh_ra_ngoai'); ?></li>
					<li><i class="fa fa-line-chart"></i> <b>Quy mô:</b> <?php the_field('quy_mo_du_an'); ?></li>
					
					<li><i class="far fa-user"></i> <b>Chủ đầu tư:</b> <?php the_field('ten_chu_dau_tux'); ?></li>
					
					<li><i class="far fa-building"></i> <b>Số tầng:</b> <?php the_field('so_tang'); ?></li>
					<li><i class="fa fa-area-chart"></i> <b>Diện tích:</b> <?php the_field('dien_tich_can'); ?></li>
			    </ul>
			    
			        
			    
			    
			
        </div>	
		
<?php	}
	else{
?>	
	<div class="tt_them">
				<ul class="list-project list-pro">
					<li><span class="font-icon area"></span><?php the_field('dien_tich'); ?></li>
					<li><span class="font-icon bedroom"></span><?php the_field('so_phong_ngu'); ?> PN</li>
					<li><span class="font-icon bathroom"></span><?php the_field('phong_wc'); ?> WC</li></ul>
			
	<?php	if ( ! empty( $terms_khu_vuc_parent ) && ! is_wp_error( $terms_khu_vuc_parent ) ) { ?>
		<i class="icon-map-pin-fill"></i> <a href="<?php echo $link_khuvuc_parent; ?>" title="<?php echo $text_link_khuvuc_parent; ?>"><?php echo $terms_khu_vuc_parent->name; ?></a>
		<?php	if ( ! empty( $terms_khu_vuc_child ) && ! is_wp_error( $terms_khu_vuc_child ) ) { ?> , <a  href="<?php echo $link_khuvuc_child ; ?>" title="<?php echo $text_link_khuvuc_child; ?>"><?php echo $terms_khu_vuc_child->name; ?></a><?php }?>
		
		<?php } ?>
		
			</div>
	<?php
		}
}
add_action('flatsome_product_box_tools_top','thongtin_them_top_right');
function thongtin_them_top_right(){
	global $product;
	$trang_thai = get_field('trang_thai_sp',$product->get_id()); 
	if($trang_thai){
	?>
			<div class="like-count hidden-xs hidden-sm"><div class="like-count-layout"><div class="like-count-content"><?php echo $trang_thai; ?></div></div></div> 
<?php }
	
}
add_action('flatsome_product_box_tools_bottom','thongtin_trangthai_loop');
function thongtin_trangthai_loop(){
	global $product;
	$trang_thai = get_field('trang_thai',$product->get_id()); 
	
	if($trang_thai){
	echo '<div class="trang_thai_div">'.$trang_thai .'</div>';
		
		
	}
	
}

function cw_change_product_price_display( $price ) {
   global $product;
   $gia_tuy_chinh = get_field('gia_tuy_chinh',$product->get_id()); 
	if($gia_tuy_chinh){return '<span class="woocommerce-Price-amount amount"> Giá: '.$gia_tuy_chinh.'</span>';}
	else{
		return '<span class="woocommerce-Price-amount amount"> Giá: '. $price.'</span>';
	}
    
  }
  add_filter( 'woocommerce_get_price_html', 'cw_change_product_price_display' );
  add_filter( 'woocommerce_cart_item_price', 'cw_change_product_price_display' );
function fnTopSearchBox(){
	
	ob_start();
	?>
<div class="top-search">
    <a href="#"></a>
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
        <div class="search-type">
            <select name="product_cat" class="hide category-search">
					<?php
	       $terms_cat_woo = get_terms(['taxonomy' => 'product_cat','hide_empty' => false, 'parent' => 0,'orderby' => 'slug']);
	       if ( !empty($terms_cat_woo) ) :
	             $order_cat = 0;
	            foreach( $terms_cat_woo as $term_cat_woo ) 
				{
					echo  '<option value="'. $term_cat_woo->slug .'">'. $term_cat_woo->name.'</option>'; 
					$order_cat++;
				}
	       endif;
	    ?>
			    
            </select>
        </div> <i class="zmdi icon-search"></i>
        
        <input placeholder="Nhập địa điểm, khu dân cư, tòa nhà" type="search" spellcheck="false" dir="auto" autocomplete="off" spellcheck="false" name="s">
        <input type="hidden" name="post_type" value="product">
    </form>
</div>
<?php	return ob_get_clean();
}
add_shortcode( 'topsearch', 'fnTopSearchBox' );

function fnCustomSearchBox(){
	
	ob_start();
?>
<div class="search_form_wrapper" style="position: relative ">
	<form id="suggest-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<div class="tab-container">
		<?php
	       $terms_cat_woo = get_terms(['taxonomy' => 'product_cat','hide_empty' => false, 'parent' => 0,'orderby' => 'slug']);
	       if ( !empty($terms_cat_woo) ) :
	             $order_cat = 0;
	            foreach( $terms_cat_woo as $term_cat_woo ) 
				{
					echo  '<div class="tab_form"><input type="radio" name="product_cat" value="'. $term_cat_woo->slug.'" id="'.  $term_cat_woo->slug .'" '. ($order_cat==0?' checked="checked" ':'') .'><label for="'. $term_cat_woo->slug.'">'. $term_cat_woo->name.'</label></div>'; 
					$order_cat++;
				}
	       endif;
	    ?>
	   
    </div>
		<div class="search-container"><a href="#"></a> <i class="zmdi icon-search"></i> <input placeholder="Nhập địa điểm, khu dân cư, tòa nhà" type="search" autocomplete="off" spellcheck="false" dir="auto" class="search-input" name="s"> <button type="submit" class="btn-ultra btn-red btn-search"><i class="zmdi icon-search"></i> <span>Tìm Kiếm</span></button> 
			<input type="hidden" name="post_type" value="product">
		</div>
	</form>
</div>	
<?php
		return ob_get_clean();
}
add_shortcode( 'customsearch', 'fnCustomSearchBox' );

add_shortcode( 'video_sp', 'mh_product_video' );
add_action('wp_footer', 'add_this_script_footer');
function add_this_script_footer()
{ 
	$contact_img = get_field('hinh_anh_dai_dien', 'option');	
		  $contact_title = get_field('tieu_de_chinh', 'option');
		  $contact_subtitle = get_field('tieu_de_phu', 'option');
		  $contact_hotline = get_field('hotline_number', 'option');
	      $cta_text_facebook = get_field('cta_text_facebook', 'option');
		  $contact_hotline_link = str_replace('.','',$contact_hotline);
		  $contact_hotline_link = str_replace(' ','',$contact_hotline_link);
	 
	
	echo '<script> var mtchildtheme_uri = "'. get_stylesheet_directory_uri() .'";</script>';
if(get_field('show_nut_rut_gon','option') == true && is_product()){
?>
  <style>
        .single-product div#tab-description {
            overflow: hidden;
            position: relative;
        }
        .single-product .tab-panels div#tab-description.panel:not(.active) {
            height: 0 !important;
        }
        .devvn_readmore_flatsome {
            text-align: center;
            cursor: pointer;
            position: absolute;
            z-index: 100;
            bottom: 0;
            width: 100%;
            background: #fff;
        }
        .devvn_readmore_flatsome:before {
            height: 55px;
            margin-top: -45px;
            content: "";
            background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
            display: block;
        }
        .devvn_readmore_flatsome a {
            color: #00779A after-white-space;
            display: block;
        }
        .devvn_readmore_flatsome a:after {
            content: '';
            width: 0;
            right: 0;
            border-top: 6px solid #00779A ;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            display: inline-block;
            vertical-align: middle;
            margin: -2px 0 0 5px;
        }
    </style>
    <script>
        (function($){
            $(document).ready(function(){
                $(window).load(function(){
                    if($('#tong-quan #tab-description').length > 0){
                        var wrap = $('#tong-quan #tab-description');
                        var current_height = wrap.height();
                        var your_height = 300;
                        if(current_height > your_height){
                            wrap.css('height', your_height+'px');
                            wrap.append(function(){
                                return '<div class="devvn_readmore_flatsome"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                            });
                            $('body').on('click','.devvn_readmore_flatsome', function(){
                                wrap.removeAttr('style');
                                $('body .devvn_readmore_flatsome').remove();
                            });
                        }
                    }
                });
            })
        })(jQuery)
    </script>
<?php
}

	
if(get_field('hien_icon_rung_lac','option') == true){	
 if( have_rows('tin_khuyen_mai','option') ){
	if( get_field('hien_icon_rung_lac_mobile','option') != true){
		echo '<style> @media (max-width: 549px){ #floating-container { display:none; } } </style>';
	}
 ?>
<div id="floating-container" class="">
    <div class="floating-button">
        <div class="hamburger hamburger--spin"><span class="hamburger-box"><i class="fa fa-bell hamburger-default" aria-hidden="true"></i><i class="hamburger-close" aria-hidden="true"></i></span><strong class="count"><?php echo count(get_field('tin_khuyen_mai','option')); ?></strong></div>
        <div class="birdseed-beacon" style="left: 20px; display: block;"><span></span></div>
    </div>
	 <ul class="floating-menu">
<?php  while( have_rows('tin_khuyen_mai','option') ): the_row(); 
     $tieu_de_tin = get_sub_field('tieu_de_tin');
	 $url_tin_khuyen_mai = get_sub_field('url_tin_khuyen_mai');
     echo '<li><a title="'. esc_attr($tieu_de_tin).'" href="'. $url_tin_khuyen_mai .'">'. esc_html($tieu_de_tin) .'</a></li>';
       endwhile;
?>
     
    </ul>
</div>
<?php }
   }
	else{
		if( !is_product() ){
		?>
		<div class="mobile-property-contact visible-on-mobile">
	<div class="d-flex justify-content-between">
		<div class="agent-details flex-grow-1">
			<div class="d-flex align-items-center">
				<div class="agent-image">
					<img class="rounded" src="<?php echo $contact_img; ?>" width="50" height="50" alt="<?php echo $contact_title; ?>">
				</div>
				<ul class="agent-information list-unstyled">
					<li class="agent-name">
						<?php echo $contact_title; ?>					</li>
					<li class="agent-name"><i class="houzez-icon icon-phone"></i> <?php echo $contact_hotline; ?></li>
					
				</ul>
			</div><!-- d-flex -->
		</div><!-- agent-details -->
		<div class="div-icon-envelop">
			
		
		<a class="btn-icon-envelop" href="<?php echo $cta_text_facebook ?>">
			<i class="fab fa-facebook-messenger"></i>
		</a>
			</div>
		<div class="div-icon-phone">
				<a class="btn-icon-phone" href="tel:<?php echo $contact_hotline; ?>">
	         <i class="far fa-phone-alt"></i>
	     </a>
	 	</div>		
	</div><!-- d-flex -->
</div>
	<?php
	}
		
	}
} 
function wporg_remove_all_dashboard_metaboxes() {
    // Remove Welcome panel
   // remove_action( 'welcome_panel', 'wp_welcome_panel' );
    // Remove the rest of the dashboard widgets
  //  remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
 //  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
   // remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
   // remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
}
add_action( 'wp_dashboard_setup', 'wporg_remove_all_dashboard_metaboxes' );
function fnMortgageCalc($atts){
	$atts = shortcode_atts( array(
'gia' => ''
), $atts );
$price_input = $atts['gia'];	
if(empty($atts['gia']) || $atts['gia'] =="" || $atts['gia'] =="0")
{ 
	$price_input = get_field('gia_tri_dat_mac_dinh','option');
}
	$max_price = get_field('gia_tri_dat_toi_da','option');
	if($price_input > $max_price){
		
		$max_price = ceil($price_input);
	}
	$max_loan_years = get_field('nam_vay_toi_da','option');
		echo '<script> var max_pricebds = '. $max_price .'; var max_loan_years = '.$max_loan_years.';</script>';
	 if(get_field('xuat_file_excel','option') == true){	
 echo '<script> var export_mortgage_excel = true; </script>';	
} else {
		 echo '<script> var export_mortgage_excel = false; </script>';
	 }

	if(get_field('show_contact_form_calc','option') == true){	
		 echo do_shortcode('[lightbox id="dang-ky-nhan-bang-tinh" width="600px" padding="0px"][contact-form-7 id="991" title="Form dk_bang_tinh"][/lightbox]');	
 echo '<script> var show_contact_form_calc = true; </script>';	
} else{
        
		 echo '<script> var show_contact_form_calc = false; </script>';
		
	}
	$laisuat = '';
	  while( have_rows('lai_suat_ngan_hang','option') ): the_row(); 
     $ten_ngan_hang = get_sub_field('ten_ngan_hang');
	 $lai_suat_nam = get_sub_field('lai_suat_nam');
    $laisuat .= '<option value="'. $lai_suat_nam .'">'. $ten_ngan_hang .'</option>';
       endwhile;
	ob_start();
	wp_register_style( 'ion.rangeSlider', get_stylesheet_directory_uri() . '/mortgage/css/ion.rangeSlider.min.css', false, false );
	wp_enqueue_style( 'ion.rangeSlider' );
	wp_register_style( 'calc-widget', get_stylesheet_directory_uri() . '/mortgage.css', false, false );
	wp_enqueue_style( 'calc-widget' );
 wp_enqueue_script( 'ion.rangeSlider',  get_stylesheet_directory_uri() . '/mortgage/js/ion.rangeSlider.min.js' , null, '2.7.2', true );
		 wp_enqueue_script( 'ChartJs',  get_stylesheet_directory_uri() . '/Chart.min.js' , null, '2.9.3', true );
	

	
		echo '<div class="loan-tool-block">
                <div id="calc-mortgage-tool" class="tool-box">
                    <div class="col box-left">
                        <div class="row">
                            <div class="label">Giá trị nhà đất (tỷ VNĐ)</div>
                            <div class="calc-wrapper">
                                <div class="slider-container range">

                                    <div class="range-slider">
                                        <input type="text" class="js-range-loan" value="" />
                                    </div>
                                </div>

                                <div class="input-group">
                                    <input disabled id="input_loan" type="text" class="js-input_loan calc-input" value="'. $price_input .'" />
                                    <label for="input_loan" class="unit">tỷ</label>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Tỷ lệ vay (%)</div>
                            <div class="calc-wrapper">
                                <div class="slider-container range">

                                    <div class="range-slider">
                                        <input type="text" class="js-range-ratio" value="" />
                                    </div>
                                </div>

                                <div class="input-group">
                                    <input disabled id="input_ratio" type="text" class="js-input_ratio calc-input" value="0" />
                                    <label for="input_ratio" class="unit">%</label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="label">Thời hạn vay (năm)</div>
                            <div class="calc-wrapper">
                                <div class="slider-container range">

                                    <div class="range-slider">
                                        <input type="text" class="js-range-year" value="" />
                                    </div>
                                </div>

                                <div class="input-group">
                                    <input disabled id="input_year" type="text" class="js-input_year calc-input" value="0" />
                                    <label for="input_year" class="unit">năm</label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="label">Lãi suất (% / năm)</div>
                            <div class="calc-wrapper">
                                <div class="slider-container dropdown">

                                    <select class="link">'. $laisuat.'</select>

                                </div>

                                <div class="input-group">
                                    <input disabled id="input_interest" type="text" class="js-input_interest calc-input" value="7.6" />
                                    <label for="input_interest" class="unit">%</label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="option-group">
                                <div class="option">
                                    <input checked type="radio" id="decrease" name="radio-category" value="decrease">
                                    <label for="decrease">
                                        Thanh toán theo dư nợ giảm dần
                                    </label>
                                </div>
                                <div class="option">
                                    <input type="radio" id="equal" name="radio-category" value="equal">
                                    <label for="equal">
                                        Thanh toán đều hàng tháng
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button id="btnXemKetQuaVay" class="btn-primary btn-medium btn-black-outline">Xem kết quả</button>
                        </div>
                    </div>
                    <div class="col box-right">
                        <h2>Kết quả</h2>
                        <div class="chart-box">
                            <div class="chart1 render-chart" id="canvas-holder" style="position: relative;">
                                <canvas style="height:200px; width:200px" id="chart-area"></canvas>
                                <div class="estimate">
                                    <div class="estimate-value" style="margin-top: 10px;">

                                    </div>
                                </div>

                            </div>
                            <div class="chart-description">
                                <div class="chart-legend">
                                    <div class="label">Cần trả trước:</div>
                                    <div class="value color1" id="sotientratruoc">5,000,000,000</div>
                                </div>
                                <div class="chart-legend">
                                    <div class="label">Gốc cần trả:</div>
                                    <div class="value color2" id="gocantra">5,000,000,000</div>
                                </div>
                                <div class="chart-legend">
                                    <div class="label">Lãi cần trả:</div>
                                    <div id="laicantra" class="value color3">2,865,833,333</div>
                                </div>
                            </div>
                        </div>
                        <div class="total-pay">
                            <div class="inner">
                                <div class="label">
                                    Thanh toán tháng đầu:
                                </div>
                                <div class="value" id="thanhtoanthangdau">
                                    47,969,458
                                </div>
                            </div>
                        </div>
                        <div class="down-payment"> 
                            <a id="btnBangChiTiet" href="'.(get_field('show_contact_form_calc','option')==true?'#dang-ky-nhan-bang-tinh':'javascript:void(0);').'" class="btn-primary btn-medium btn-red button"><i class="fas fa-file-download"></i> Xem bảng thanh toán từng tháng
                            </a>
                        </div>
                    </div>
                </div>
                <div id="tblChiTiet"></div>
            </div>';
                 wp_enqueue_script( 'calc-widget',  get_stylesheet_directory_uri() . '/mortgage.js' , null, '2.7.2', true );
		
		
		return ob_get_clean();
}
add_shortcode( 'MortgageCalc', 'fnMortgageCalc' );
function fnBangChiTietHangThang($sotienvay, $laisuatvay, $sothangvay, $paymentmethod) //Lãi theo năm
		{
		  
		  $laivay = $laisuatvay / 12; 
		  $tiengoc = $sotienvay/$sothangvay;
		  $laiphang = $sotienvay * ($laisuatvay/100/12);
		  $gocconlaitruoc = $sotienvay;
	      $tonglai = 0;
	      $tongcong = 0;
		  $data = array();
	     
		  if($paymentmethod ==true)
		  {
		  for($n = 0; $n < $sothangvay; $n++) 
	      {
		      
			 $tiengocconlai = ($n== $sothangvay-1?0:$gocconlaitruoc - $tiengoc);
			 $lai = $gocconlaitruoc* ($laisuatvay/100/12);
			 $tonglai += $lai;
			 $gocvalai = $tiengoc + $lai;
			 
			 $data[]  = array(
			     'KyThanhToan' => $n + 1,
			     'DuNoDauKy' => $gocconlaitruoc,
			     'LaiThanhToan' => round($lai),
			     'GocThanhToan' => $tiengoc,
			     'DuNoCuoiKy' => $tiengocconlai,
			     'TongThanhToan' => round($gocvalai)
			     );
			  $gocconlaitruoc = $gocconlaitruoc - $tiengoc;
		  }
		   }
		   else{
		     for($n = 0; $n < $sothangvay; $n++) 
	      {
		     $goc = $tiengoc; 
			 $tiengocconlai = ($n==$sothangvay-1?0:$gocconlaitruoc - $goc);
			
			 $gocvalai = $goc + $laiphang;
				 $data[]  = array(
			     'KyThanhToan' => $n + 1,
			     'DuNoDauKy' => $gocconlaitruoc,
			     'LaiThanhToan' => round($laiphang),
			     'GocThanhToan' => $tiengoc,
			     'DuNoCuoiKy' => $tiengocconlai,
			     'TongThanhToan' => round($gocvalai)
			     );
			    $gocconlaitruoc = $gocconlaitruoc - $tiengoc;
			
		  }
		   }
		  
		   return $data;
		}

function fnGetWeekVN($w){
    $rs = "";
    $weekdays = array ("Monday"=>"Thứ 2","Tuesday"=>"Thứ 3","Wednesday"=>"Thứ 4","Thursday"=>"Thứ 5","Friday"=>"Thứ 6","Saturday"=>"Thứ 7","Sunday"=>"Chủ nhật");
    foreach ($weekdays as $key => $value) { 
    if($w==$key){
    $rs = $value;
    }
    }
    return $rs;
}
function fnChonNgayXemNha(){
	    ob_start();
	echo '<style>
.book-calendar-slider{
margin-bottom:12px;
}
.book-calendar-slider .flickity-slider .carousel-cell{
 width: 28% !important;
 
  margin-right: 5px;
 
}

.book-calendar-slider .flickity-slider>div:not(.col), .book-calendar-slider .flickity-slider>a, .book-calendar-slider .flickity-slider>p, .book-calendar-slider .flickity-slider>a>img, .book-calendar-slider .flickity-slider>img, .book-calendar-slider .flickity-slider>figure {
    width: 28% !important;

  margin-right: 5px;
 
   
}
.book-calendar-slider-date .flickity-slider .carousel-cell{
height: 112px;
}
.book-calendar-slider-time .flickity-slider .carousel-cell{
height: 36px;
}
.book-calendar-slider .carousel-cell{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-flow:column;flex-flow:column;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;border-radius:2px;border:solid 1px #ccc;width:104px!important;height:112px;padding:12px 8px;cursor:pointer}
.book-calendar-slider .carousel-cell p{font-size:14px;line-height:1.5;font-weight:400;color:#838383}
.book-calendar-slider .carousel-cell strong{font-size:32px;line-height:normal;font-weight:600;color:#838383;padding-top:4px}
.book-calendar-slider .carousel-cell.is-selected{
border:solid 2px #30333a;-webkit-box-sizing: border-box; 
-moz-box-sizing: border-box; 
box-sizing: border-box;
}
.book-calendar-slider .carousel-cell.is-selected p,.book-calendar-slider .carousel-cell.is-selected strong{color:#30333a}



	
	</style>';
	    $begin = date("Y-m-d");
$end = date('Y-m-d', strtotime($begin. ' + 15 days'));
//echo $begin->format('Y-m-d');
//$html = '[ux_slider slide_width="28%" freescroll="true" hide_nav="true" nav_style="simple" draggable="false" bullets="false" bullet_style="dashes-spaced" class="book-calendar-slider"]';
$html = '<h3 class="label_gorm">Chọn ngày xem:</h3><div class="book-calendar-slider book-calendar-slider-date">';

$interval = new DateInterval('P1D');
$period_date = new DatePeriod( new DateTime($begin), $interval , new DateTime($end));

$dem = 1;
foreach ($period_date as $dt) {
    
  
  $m_day = $dt->format("d");
  $m_day_vn = ltrim($m_day,"0");
  $m_motnh = $dt->format("m");
  $m_motnh_vn = 'Tháng '. ltrim($m_motnh,"0");
  $m_week = $dt->format("l");
  $m_week_vn = fnGetWeekVN($m_week);
  $html .= '<div style="margin-right: 8px;" class="carousel-cell" data-date="'. $dt->format("Y-m-d") .'"><p>'. ($dem==1?"Hôm nay":$m_week_vn) .'</p> <strong>'. $m_day_vn .'</strong><p>'. $m_motnh_vn .'</p></div>';
  
  $dem++;
  
}

$html .= '</div>';
$html .= '<h3 class="label_gorm">Chọn khung giờ:</h3><div class="book-calendar-slider book-calendar-slider-time">';
$hur = 8;
for ($x = 1; $x <= 25; $x++) {
 if($x%2==1){
      if($x>=3){
         $hur++;
     }
	 $html .= '<div style="margin-right: 8px;" class="carousel-cell" data-time="'.$hur .':00' .'">'.$hur .':00</div>';
     
    
 }
 else{
	  $html .= '<div style="margin-right: 8px;" class="carousel-cell" data-time="'.$hur .':30' .'">'.$hur .':30</div>';
    
 }
}
$html .= '</div>';	
echo do_shortcode($html);
		return ob_get_clean();
}
add_shortcode( 'ChonNgayXemNha', 'fnChonNgayXemNha' );


/*gallery product*/
function addgallery2(){;?>
	<div class="carousel product-box-slider" data-flickity='{ "cellAlign": "left",
            "imagesLoaded": true,
            "lazyLoad": 1,
            "freeScroll": false,
            "wrapAround": true,
            "autoPlay": 6000,
            "pauseAutoPlayOnHover" : true,
            "prevNextButtons": true,
            "contain" : true,
            "adaptiveHeight" : true,
            "dragThreshold" : 10,
            "percentPosition": true,
            "pageDots": false,
            "rightToLeft": false,
            "draggable": true,
            "selectedAttraction": 0.1,
            "parallax" : 0,
            "friction": 0.6  }'>
        <?php global $product;?>
			<?php $attachment_ids = $product->get_gallery_image_ids();
			foreach( $attachment_ids as $attachment_id ) { ?>
				<div class="carousel_item" style="width: 23%!important;margin:0 5px;z-index: 999999">
					<?php echo wp_get_attachment_image($attachment_id, 'medium'); ?>
				</div>
			<?php } ?>
    </div>
    
<?php }
add_action('woocommerce_before_shop_loop_item_title','addgallery2');

/*UX bulder Pttuan410*/
function flatsome_ux_builder_thumbnail_pttuan( $name ) {
  return get_template_directory_uri() . '/inc/builder/shortcodes/thumbnails/' . $name . '.svg';
}
add_action('ux_builder_setup', 'pttuan_ux_product_custom_builder');
function pttuan_ux_product_custom_builder(){
$repeater_columns = '4';
$repeater_type = 'slider';
$repeater_col_spacing = 'small';

$repeater_posts = 'products';
$repeater_post_type = 'product';
$repeater_post_cat = 'product_cat';
$repeater_post_tax = 'yith_product_brand';
$args = array(
  'public'   => true,
  '_builtin' => false,
  'object_type' => array('product') 
); 
$output = 'names'; // or objects
$operator = 'and'; // 'and' or 'or'
$taxonomies = get_taxonomies( $args, $output, $operator ); 
$options = array(
'style_options' => array(
    'type' => 'group',
    'heading' => __( 'Style' ),
    'options' => array(
         'style' => array(
            'type' => 'select',
            'heading' => __( 'Style' ),
            'default' => 'default',
            'options' => require( get_template_directory() . '/inc/builder/shortcodes/values/box-layouts.php' )
        )
    ),
),
'layout_options' => require( get_template_directory() . '/inc/builder/shortcodes/commons/repeater-options.php' ),
'layout_options_slider' => require( get_template_directory() . '/inc/builder/shortcodes/commons/repeater-slider.php' ),
'box_options' => array(
	'type'    => 'group',
	'heading' => __( 'Box' ),
	'options' => array(
		'show_cat' => array(
			'type'    => 'checkbox',
			'heading' => __( 'Category' ),
			'default' => 'true',
		),
		'show_title' => array(
			'type'    => 'checkbox',
			'heading' => __( 'Title' ),
			'default' => 'true',
		),
		'show_rating' => array(
			'type'    => 'checkbox',
			'heading' => __( 'Rating' ),
			'default' => 'true',
		),
		'show_price' => array(
			'type'    => 'checkbox',
			'heading' => __( 'Price' ),
			'default' => 'true',
		),
		'show_add_to_cart' => array(
			'type'    => 'checkbox',
			'heading' => __( 'Add To Cart' ),
			'default' => 'true',
		),
		'show_quick_view' => array(
			'type'    => 'checkbox',
			'heading' => __( 'Quick View' ),
			'default' => 'true',
		),
		'equalize_box' => array(
			'type'    => 'checkbox',
			'heading' => __( 'Equalize Items' ),
			'default' => 'false',
		),
	),
),
// 'post_options' => require( get_template_directory() . '/inc/builder/shortcodes/commons/repeater-posts.php' ),

'post_options' => array(
    'type' => 'group',
    'heading' => __( 'Posts' ),
    'options' => array(
    'type_taxonomy' => array(
            'type' => 'select',
            'heading' => __( 'Type taxonomy' ),
            'default' => 'default',
            'options' => $taxonomies
        ),
    'custom_tax' => array(
        'type' => 'select',
        'heading' => 'Custom tax',
        'param_name' => 'custom_tax',
        'default' => '',
        'config' => array(
            'multiple' => true,
            'placeholder' => 'Select...',
            'termSelect' => array(
                'post_type' => 'product',
                'taxonomies' => $taxonomies
            ),
        )
    ),

    $repeater_posts => array(
        'type' => 'textfield',
        'heading' => 'Total Posts',
        
        'default' => '8',
    ),

    'offset' => array(
        'type' => 'textfield',
        'heading' => 'Offset',
        
        'default' => '',
    ),
  )
),
'filter_posts' => array(
    'type' => 'group',
    'heading' => __( 'Filter Posts' ),
    
    'options' => array(
         'orderby' => array(
            'type' => 'select',
            'heading' => __( 'Order By' ),
            'default' => 'normal',
            'options' => array(
                'normal' => 'Normal',
                'title' => 'Title',
                'sales' => 'Sales',
                'rand' => 'Random',
                'date' => 'Date'
            )
        ),
        'order' => array(
            'type' => 'select',
            'heading' => __( 'Order' ),
            'default' => 'desc',
            'options' => array(
                'asc' => 'ASC',
                'desc' => 'DESC',
            )
        ),
    )
)
);

$box_styles = require(  get_template_directory() . '/inc/builder/shortcodes/commons/box-styles.php' );
$options = array_merge($options, $box_styles);

$options['image_options']['conditions'] = 'style !== "default"';
$options['text_options']['conditions'] = 'style !== "default"';
$options['layout_options']['options']['depth']['conditions'] = 'style !== "default"';
$options['layout_options']['options']['depth_hover']['conditions'] = 'style !== "default"';
	add_ux_builder_shortcode('product-custom', array(
		'name' => 'Products custom Pttuan410',
    'category' => __( 'Shop' ),
    'priority' => 1,
    'thumbnail' =>  flatsome_ux_builder_thumbnail_pttuan( 'products' ),
    'options' => $options
	));

};
function pttuan_ux_product_custom_shortcode( $atts, $content = null,$tag ){
	$sliderrandomid = rand();
  if ( ! is_array( $atts ) ) {
    $atts = array();
  }
	extract(shortcode_atts(array(
		'_id' => 'product-grid-'.rand(),
		'title' => '',
		'ids' => '',
		'style' => 'default',
		'class' => '',
		'visibility' => '',

		// Ooptions
		'back_image' => true,

		// Layout
		'columns' => '4',
		'columns__sm' => '',
		'columns__md' => '',
		'col_spacing' => 'small',
		'type' => 'slider', // slider, row, masonery, grid
		'width' => '',
		'grid' => '1',
		'grid_height' => '600px',
		'grid_height__md' => '500px',
		'grid_height__sm' => '400px',
		'slider_nav_style' => 'reveal',
		'slider_nav_position' => '',
		'slider_nav_color' => '',
		'slider_bullets' => 'false',
	 	'slider_arrows' => 'true',
		'auto_slide' => '',
		'infinitive' => 'true',
		'depth' => '',
   		'depth_hover' => '',
	 	'equalize_box' => 'false',
	 	// posts
	 	'products' => '8',
		'cat' => '',
		'excerpt' => 'visible',
		'offset' => '',
    	'filter' => '',
		// Posts Woo
		'orderby' => '', // normal, sales, rand, date
		'order' => '',
		'tags' => '',
		'show' => '', //featured, onsale
		'out_of_stock' => '', // exclude.
		// Box styles
		'animate' => '',
		'text_pos' => 'bottom',
	  	'text_padding' => '',
	  	'text_bg' => '',
		'text_color' => '',
		'text_hover' => '',
		'text_align' => 'center',
		'text_size' => '',
		'image_size' => '',
		'image_radius' => '',
		'image_width' => '',
		'image_height' => '',
	    'image_hover' => '',
	    'image_hover_alt' => '',
	    'image_overlay' => '',
		'show_cat' => 'true',
		'show_title' => 'true',
		'show_rating' => 'true',
		'show_price' => 'true',
		'show_add_to_cart' => 'true',
		'show_quick_view' => 'true',
		'custom_tax' =>'',
		'type_taxonomy' => '',

	), $atts));

	// Stop if visibility is hidden
  if($visibility == 'hidden') return;

	$items                             = flatsome_ux_product_box_items();
	$items['cat']['show']              = $show_cat;
	$items['title']['show']            = $show_title;
	$items['rating']['show']           = $show_rating;
	$items['price']['show']            = $show_price;
	$items['add_to_cart']['show']      = $show_add_to_cart;
	$items['add_to_cart_icon']['show'] = $show_add_to_cart;
	$items['quick_view']['show']       = $show_quick_view;
	$items                             = flatsome_box_item_toggle_start( $items );

	ob_start();

	// if no style is set
	if(!$style) $style = 'default';

	$classes_box = array('box');
	$classes_image = array();
	$classes_text = array();
	$classes_repeater = array( $class );

	if ( $equalize_box === 'true' ) {
		$classes_repeater[] = 'equalize-box';
	}

	// Fix product on small screens
	if($style == 'overlay' || $style == 'shade'){
		if(!$columns__sm) $columns__sm = 1;
	}

	if($tag == 'ux_bestseller_products') {
		if(!$orderby) $atts['orderby'] = 'sales';
	} else if($tag == 'ux_featured_products'){
		$atts['show'] = 'featured';
	} else if($tag == 'ux_sale_products'){
		$atts['show'] = 'onsale';
	} else if($tag == 'products_pinterest_style'){
		$type = 'masonry';
		$style = 'overlay';
		$text_align = 'center';
		$image_size = 'medium';
		$text_pos = 'middle';
		$text_hover = 'hover-slide';
		$image_hover = 'overlay-add';
		$class = 'featured-product';
		$back_image = false;
		$image_hover_alt = 'image-zoom-long';
	} else if($tag == 'product_lookbook'){
		$type = 'slider';
		$style = 'overlay';
		$col_spacing = 'collapse';
		$text_align = 'center';
		$image_size = 'medium';
		$slider_nav_style = 'circle';
		$text_pos = 'middle';
		$text_hover = 'hover-slide';
		$image_hover = 'overlay-add';
		$image_hover_alt = 'zoom-long';
		$class = 'featured-product';
		$back_image = false;
	}

	// Fix grids
	if($type == 'grid'){
	  if(!$text_pos) $text_pos = 'center';
	  if(!$text_color) $text_color = 'dark';
	  if($style !== 'shade') $style = 'overlay';
	  $columns = 0;
	  $current_grid = 0;
	  $grid = flatsome_get_grid($grid);
	  $grid_total = count($grid);
	  flatsome_get_grid_height($grid_height, $_id);
	}

	// Fix image size
	if(!$image_size) $image_size = 'woocommerce_thumbnail';

   	// Add Animations
	if($animate) {$animate = 'data-animate="'.$animate.'"';}


	// Set box style
	if($class) $classes_box[] = $class;
	$classes_box[] = 'has-hover';
	if($style) $classes_box[] = 'box-'.$style;
	if($style == 'overlay') $classes_box[] = 'dark';
	if($style == 'shade') $classes_box[] = 'dark';
	if($style == 'badge') $classes_box[] = 'hover-dark';
	if($text_pos) $classes_box[] = 'box-text-'.$text_pos;
	if($style == 'overlay' && !$image_overlay) $image_overlay = true;

	if($image_hover) $classes_image[] = 'image-'.$image_hover;
	if($image_hover_alt)  $classes_image[] = 'image-'.$image_hover_alt;
	if($image_height)  $classes_image[] = 'image-cover';

	// Text classes
	if($text_hover) $classes_text[] = 'show-on-hover hover-'.$text_hover;
	if($text_align) $classes_text[] = 'text-'.$text_align;
	if($text_size) $classes_text[] = 'is-'.$text_size;
	if($text_color == 'dark') $classes_text[] = 'dark';

	$css_args_img = array(
	  array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%'),
	  array( 'attribute' => 'width', 'value' => $image_width, 'unit' => '%' ),
	);

    $css_image_height = array(
      array( 'attribute' => 'padding-top', 'value' => $image_height),
    );

	$css_args = array(
        array( 'attribute' => 'background-color', 'value' => $text_bg ),
        array( 'attribute' => 'padding', 'value' => $text_padding ),
  	);

  	// If default style
  	if($style == 'default'){
  		$depth = get_theme_mod('category_shadow');
  		$depth_hover = get_theme_mod('category_shadow_hover');
  	}

	// Repeater styles
	$repater['id'] = $_id;
	$repater['title'] = $title;
	$repater['tag'] = $tag;
	$repater['class'] = implode( ' ', $classes_repeater );
	$repater['visibility'] = $visibility;
	$repater['type'] = $type;
	$repater['style'] = $style;
	$repater['slider_style'] = $slider_nav_style;
	$repater['slider_nav_color'] = $slider_nav_color;
	$repater['slider_nav_position'] = $slider_nav_position;
	$repater['slider_bullets'] = $slider_bullets;
  	$repater['auto_slide'] = $auto_slide;
	$repater['row_spacing'] = $col_spacing;
	$repater['row_width'] = $width;
	$repater['columns'] = $columns;
	$repater['columns__md'] = $columns__md;
	$repater['columns__sm'] = $columns__sm;
	$repater['filter'] = $filter;
	$repater['depth'] = $depth;
	$repater['depth_hover'] = $depth_hover;

	get_flatsome_repeater_start($repater);

	?>
	<?php
	if ($custom_tax==''){
			$terms = get_terms($type_taxonomy, 'orderby=count&hide_empty=1' );
			$termsid = wp_list_pluck($terms,'term_id');
		}else{
			$termsid = explode( ',', $custom_tax );
		}
				$args = array(
				'post_type' => 'product',
				'offset' =>$offset,
				'posts_per_page' => $products,
				'order' => $order,
				'orderby' => $orderby,
				'tax_query' => array(
				    array(
				    'taxonomy' => $type_taxonomy,
				    'field' => 'term_id',
				    'terms' => $termsid
				     )
				  )
				);
		$products = new WP_Query( $args );
		while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php
          global $product;

          if($style == 'default'){
					 	 wc_get_template_part( 'content', 'product' );
					} else { ?>
	            	<?php

	            	$classes_col = array('col');

      					$out_of_stock = get_post_meta(get_the_ID(), '_stock_status',true) == 'outofstock';
      					if($out_of_stock) $classes[] = 'out-of-stock';

	            	if($type == 'grid'){
				        if($grid_total > $current_grid) $current_grid++;
				        $current = $current_grid-1;
				        $classes_col[] = 'grid-col';
				        if($grid[$current]['height']) $classes_col[] = 'grid-col-'.$grid[$current]['height'];

				        if($grid[$current]['span']) $classes_col[] = 'large-'.$grid[$current]['span'];
       					 if($grid[$current]['md']) $classes_col[] = 'medium-'.$grid[$current]['md'];
				        // Set image size
				        if($grid[$current]['size']) $image_size = $grid[$current]['size'];
				    }
	            	?>

	            	<div class="<?php echo implode(' ', $classes_col); ?>" <?php echo $animate;?>>
						<div class="col-inner">
						<?php woocommerce_show_product_loop_sale_flash(); ?>
						<div class="product-small <?php echo implode(' ', $classes_box); ?>">
							<div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
								<div class="<?php echo implode(' ', $classes_image); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
									<a href="<?php echo get_the_permalink(); ?>">
										<?php
											if($back_image) flatsome_woocommerce_get_alt_product_thumbnail($image_size);
											echo woocommerce_get_product_thumbnail($image_size);
										?>
									</a>
									<?php if($image_overlay){ ?><div class="overlay fill" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
									 <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
								</div>
								<div class="image-tools top right show-on-hover">
									<?php do_action('flatsome_product_box_tools_top'); ?>
								</div>
								<?php if($style !== 'shade' && $style !== 'overlay') { ?>
									<div class="image-tools <?php echo flatsome_product_box_actions_class(); ?>">
										<?php  do_action('flatsome_product_box_actions'); ?>
									</div>
								<?php } ?>
								<?php if($out_of_stock) { ?><div class="out-of-stock-label"><?php _e( 'Out of stock', 'woocommerce' ); ?></div><?php }?>
								<div class="showinfo">
									<a href="<?php echo get_the_permalink(); ?>"> <?php echo $product->get_short_description()?> </a>
								</div>
							</div><!-- box-image -->

							<div class="box-text <?php echo implode(' ', $classes_text); ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
								<?php
									do_action( 'woocommerce_before_shop_loop_item_title' );

									echo '<div class="title-wrapper">';
									do_action( 'woocommerce_shop_loop_item_title' );
									echo '</div>';

									echo '<div class="price-wrapper">';
									do_action( 'woocommerce_after_shop_loop_item_title' );
									echo '</div>';

									if($style == 'shade' || $style == 'overlay') {
									echo '<div class="overlay-tools">';
										do_action('flatsome_product_box_actions');
									echo '</div>';
									}

									do_action( 'flatsome_product_box_after' );

								?>
							</div><!-- box-text -->
						</div><!-- box -->
						</div><!-- .col-inner -->
					</div><!-- col -->
					<?php } ?>
	            <?php endwhile; // end of the loop. ?>

	        <?php
	        wp_reset_query();

	get_flatsome_repeater_end($repater);
	flatsome_box_item_toggle_end( $items );

	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
add_shortcode('product-custom', 'pttuan_ux_product_custom_shortcode');
/*Ux Builer Pttuan410  end */
function addjsgallery(){;?>
<script type="text/javascript">
		var _0xdac0=["\x73\x72\x63\x73\x65\x74","\x61\x74\x74\x72","\x2E\x69\x6D\x61\x67\x65\x2D\x63\x6F\x76\x65\x72\x20\x69\x6D\x67","\x66\x69\x6E\x64","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x6D\x61\x6C\x6C\x2E\x62\x6F\x78","\x70\x61\x72\x65\x6E\x74\x73","\x2E\x69\x6D\x61\x67\x65\x2D\x6E\x6F\x6E\x65\x20\x69\x6D\x67","\x68\x6F\x76\x65\x72","\x2E\x63\x61\x72\x6F\x75\x73\x65\x6C\x5F\x69\x74\x65\x6D\x20\x69\x6D\x67","\x72\x65\x61\x64\x79"];jQuery(document)[_0xdac0[9]](function(_0xefe8x1){_0xefe8x1(_0xdac0[8])[_0xdac0[7]](function(){srcset= _0xefe8x1(this)[_0xdac0[1]](_0xdac0[0]);_0xefe8x1(this)[_0xdac0[5]](_0xdac0[4])[_0xdac0[3]](_0xdac0[2])[_0xdac0[1]](_0xdac0[0],srcset);_0xefe8x1(this)[_0xdac0[5]](_0xdac0[4])[_0xdac0[3]](_0xdac0[6])[_0xdac0[1]](_0xdac0[0],srcset)})})
	</script>
<?php };
add_action('wp_footer','addjsgallery');

add_action('flatsome_after_header', function() {
	if (is_single() || is_category() || is_archive()) {
		echo do_shortcode('[block id="page-header"]');
	}
});


add_action('wp_footer','devvn_readmore_taxonomy_flatsome');
function devvn_readmore_taxonomy_flatsome(){
    if(is_woocommerce() && is_tax('product_cat')):
        ?>
        <style>
            .term-description {
                overflow: hidden;
                position: relative;
                margin-bottom: 20px;
                padding-bottom: 25px;
            }
            .devvn_readmore_taxonomy_flatsome {
                text-align: center;
                cursor: pointer;
                position: absolute;
                z-index: 10;
                bottom: 0;
                width: 100%;
                background: #fff;
            }
            .devvn_readmore_taxonomy_flatsome:before {
                height: 55px;
                margin-top: -45px;
                content: "";
                background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
                display: block;
            }
            .devvn_readmore_taxonomy_flatsome a {
                    display: block;
    background: var(--primary-color);
    width: 150px;
    margin: 5px auto;
    color: #fff;
    font-size: 14px;
    line-height: 36px;
    border-radius: 4px;
            }
            .devvn_readmore_taxonomy_flatsome a:after {
                content: '';
                width: 0;
                right: 0;
                border-top: 6px solid #fff;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                display: inline-block;
                vertical-align: middle;
                margin: -2px 0 0 5px;
            }
            .devvn_readmore_taxonomy_flatsome_less:before {
                display: none;
            }
            .devvn_readmore_taxonomy_flatsome_less a:after {
                border-top: 0;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid #318A00;
            }
        </style>
        <script>
            (function($){
                $(document).ready(function(){
                    $(window).on('load', function(){
                        if($('.term-description').length > 0){
                            var wrap = $('.term-description');
                            var current_height = wrap.height();
                            var your_height = 300;
                            if(current_height > your_height){
                                wrap.css('height', your_height+'px');
                                wrap.append(function(){
                                    return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_show"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                                });
                                wrap.append(function(){
                                    return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_less" style="display: none"><a title="Thu gọn" href="javascript:void(0);">Thu gọn</a></div>';
                                });
                                $('body').on('click','.devvn_readmore_taxonomy_flatsome_show', function(){
                                    wrap.removeAttr('style');
                                    $('body .devvn_readmore_taxonomy_flatsome_show').hide();
                                    $('body .devvn_readmore_taxonomy_flatsome_less').show();
                                });
                                $('body').on('click','.devvn_readmore_taxonomy_flatsome_less', function(){
                                    wrap.css('height', your_height+'px');
                                    $('body .devvn_readmore_taxonomy_flatsome_show').show();
                                    $('body .devvn_readmore_taxonomy_flatsome_less').hide();
                                });
                            }
                        }
                    });
                });
            })(jQuery);
        </script>
    <?php
    endif;
}
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );
add_filter('use_block_editor_for_post', '__return_false', 10);