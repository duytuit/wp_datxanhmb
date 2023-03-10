<?php 
global $product;
$content_schema['@type']= 'Product';
$content_schema['@id']= get_permalink( $product->get_id() ).'#product';
$content_schema['name']= wp_kses_post( $product->get_name() );
$content_schema['url']= get_permalink( $product->get_id() );
$content_schema['description']= wp_strip_all_tags( $product->get_short_description());
$content_schema['image']= wp_get_attachment_url( $product->get_image_id() );
$content_schema['offers']= [
	  '@type'=>'Offer',
	  'availability'  => 'http://schema.org/' . ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
	  'price'=> wc_format_decimal( $product->get_price(), wc_get_price_decimals() ),
	  'priceCurrency'=>'VND',
];
$content_schema;
if( $GLOBALS['schema_website']) {
	$schema_website = $GLOBALS['schema_website'];
	$schema_website['@graph'][]=$content_schema;
	if(\is_array( $schema_website )){
		$output = WPSEO_Utils::format_json_encode( $schema_website );
		$output = \str_replace( "\n", \PHP_EOL . "\t", $output );
		$schema_product = '<script type="application/ld+json">' . $output . '</script>';
		echo $schema_product;
	}
}
$kieu_hien_thi = get_field('kieu_hien_thi');
$la_du_an = get_field('la_du_an');
if ($la_du_an == true) {
$ten_loai_bds = '';
$link_loai_bds = '';
$ten_chu_dau_tu = '';
$ten_chu_dau_tu_short = '';
$link_chu_dau_tu = '';
$logo_chu_dau_tu = '';
$mota_chu_dau_tu = '';
$cta_text_du_an = get_field('cta_text_du_an', 'option');
$cta_text_nha_dat = get_field('cta_text_nha_dat', 'option');
$terms_cat =  get_the_terms( $product->get_id(), 'product_cat' );
$product_cat = null;
if ( $terms_cat && ! is_wp_error( $terms_cat ) ) {
    $product_cat = $terms_cat[0];
}
$terms_bds = get_the_terms($product->get_id(), 'bat-dong-san');

$terms_khu_vuc = get_the_terms( $product->get_id(), 'khu-vuc' );

$terms_khu_vuc_parent = null;
$terms_khu_vuc_child = null;
$link_khuvuc_parent =  '';
$link_khuvuc_parent =  '';
if ( ! empty( $terms_khu_vuc ) && ! is_wp_error( $terms_khu_vuc ) ) {
foreach ( $terms_khu_vuc as $term ){
    if ( $term->parent == 0) {
		
		$terms_khu_vuc_parent = $term;
		
	}
	else{$terms_khu_vuc_child = $term;}
	
	
}
	$link_khuvuc_parent =  '/?khu-vuc='. $terms_khu_vuc_parent->slug . ($product_cat!=null?'&product_cat='.$product_cat->slug:'') ; 
	$link_khuvuc_child =  '/?khu-vuc='. $terms_khu_vuc_child->slug . ($product_cat!=null?'&product_cat='.$product_cat->slug:'') ; 
}
if ( ! empty( $terms_bds ) && ! is_wp_error( $terms_bds ) ) {
	
	$term_bds = $terms_bds[0];
	$ten_loai_bds = $term_bds->name;
	$link_loai_bds = get_term_link( $term_bds->slug, 'bat-dong-san' );
	
}
 if($la_du_an == true)
 {
	  $terms_cdt = get_the_terms($product->get_id(), 'chu-dau-tu');
	 if ( ! empty( $terms_cdt ) && ! is_wp_error( $terms_cdt ) ) {
		 $term_cdt = $terms_cdt[0];
		 $ten_chu_dau_tu = $term_cdt->name;
		 $link_chu_dau_tu= get_term_link( $term_cdt->slug, 'chu-dau-tu' );
		 $ten_chu_dau_tu_short = get_term_meta($term_cdt->term_id,'ten_chu_dau_tu_ngan', true);
		 $logo_chu_dau_tu = get_term_meta($term_cdt->term_id,'logo_chudautu', true);
		 $mota_chu_dau_tu = term_description($term_cdt->term_id);
	 }
 }
$contact_img = (get_field('hinh_anh_dai_dien_p')?get_field('hinh_anh_dai_dien_p'):get_field('hinh_anh_dai_dien', 'option'));	
		  $contact_title = (get_field('tieu_de_chinh_p')?get_field('tieu_de_chinh_p'):get_field('tieu_de_chinh', 'option'));
		  $contact_subtitle = (get_field('tieu_de_phu_p')?get_field('tieu_de_phu_p'):get_field('tieu_de_phu', 'option'));
		  $contact_hotline = (get_field('hotline_number_p')?get_field('hotline_number_p'):get_field('hotline_number', 'option'));
		  $contact_hotline_link = str_replace('.','',$contact_hotline);
			$contact_hotline_link = str_replace(' ','',$contact_hotline_link);
?>
<div class="product-container">
	
	<div class="product-header">

	<div class="container">
   
	<section class="project-header">
		
	<div class="project-name width1140 padding-0-15" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <div class="address">
                    <h1 id="title-project" class="title-project" data-type="<?php echo ($la_du_an == true?"1":"2"); ?>"><?php echo $product->get_title(); ?></h1>
					<h4 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="1">
                                <a itemprop="item" href="<?php echo home_url( '/' ); ?>" title="Trang ch???">
                                    <meta itemprop="name" content="Trang ch???">
                                    Trang ch???&nbsp;</a>
                            </h4>
					<h4 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="2">
                                <a itemprop="item" href="<?php echo get_term_link( $product_cat->slug, 'product_cat' ); ?>" title="<?php echo $product_cat->name; ?>">
                                    <meta itemprop="name" content="<?php echo $product_cat->name; ?>">
                                   ??? <?php echo $product_cat->name; ?>&nbsp;</a>
                            </h4>
					
					        <?php
					if(! empty( $terms_khu_vuc_parent ) && ! is_wp_error( $terms_khu_vuc_parent )) { ?>
                            <h4 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="3">
                                <a itemprop="item" href="<?php echo $link_khuvuc_parent; ?>" title="<?php echo $terms_khu_vuc_parent->name; ?>">
                                    <meta itemprop="name" content="<?php echo $terms_khu_vuc_parent->name; ?>">
                                    ??? <?php echo $terms_khu_vuc_parent->name; ?>&nbsp;</a>
                            </h4>
					
					
					
					<?php 
					
					
					 if(! empty( $terms_khu_vuc_child ) && ! is_wp_error( $terms_khu_vuc_child )) { ?>
						    <h4 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="4">
                                <a itemprop="item" href="<?php echo $link_khuvuc_child; ?>" title="<?php echo $terms_khu_vuc_child->name; ?>">
                                    <meta itemprop="name" content="<?php echo $terms_khu_vuc_child->name; ?>">
                                    ??? <?php echo $terms_khu_vuc_child->name; ?></a>
                            </h4>
					<?php }
					}
					?>
                           
                    <input type="hidden" name="alias" value="verosa-park-1">
                </div>
                <div class="social-share">
                   <span>Gi??:</span> <span class="price-redRV"> <?php the_field('gia_tuy_chinh'); ?></span>
					<?php if(get_field('trang_thai_sp')){
					echo '<div class="trangthainoibat">'. get_field('trang_thai_sp') .'</div>';	
					} ?>
                </div>
            </div>
		</section>
	
		</div>
</div>
<div class="product-main">
	
	<?php 
    $dem_hinh = 1;
	//only for desktop: hide-for-medium
	//only for mobile : show-for-small
	//only for tabet : show-for-medium hide-for-small
	//hide for desktop: show-for-medium
	//hide for mobile: hide-for-small
	$galerry = '[row style="collapse" width="full-width" class="show_to_1024"][col span__sm="12"][ux_slider style="container" slide_width="33.33333%"  nav_style="simple" bullet_style="dashes-spaced"]';
	$galerry .= '[ux_image id="'. $product->get_image_id().'" height="56.25%" lightbox="true" lightbox_image_size="original"]';
	$prod = new WC_product($product->get_id());
    $attachment_ids = $prod->get_gallery_image_ids();
foreach( $attachment_ids as $attachment_id ) 
    {
       $galerry .= '[ux_image id="'. $attachment_id.'" height="56.25%"  image_size="original" lightbox="true" lightbox_image_size="original"]';
       $dem_hinh++;
    }
	
$galerry .= '[/ux_slider][/col][/row]';
	if($dem_hinh >=4){
	echo do_shortcode( $galerry);
	}


 ?>
		<?php
	if($la_du_an == true)
 { ?>
	<section class="section menuProductWrap MenuFixxed">
		<div class="bg section-bg fill bg-fill  bg-loaded" >

			
			
			

		</div>

		<div class="section-content relative">
			

<div class="row row-small" >


	<div class="col pb-0 small-12 large-12" style="top: 0px !important; margin-top: -20px;" >
		<div class="col-inner" >
			
		<div class="">
<div class="menuProduct">
<div class="wrapper">
<ul>
<li class="active"><a href="#tong-quan">T???ng quan</a></li>
<li><a href="#tien-ich">Ti???n ??ch</a></li>
<li><a href="#vi-tri">V??? tr??</a></li>
<li><a href="#mat-bang">M???t b???ng</a></li>
<li><a href="#thiet-ke">Thi???t k???</a></li>
<li><a href="#nha-mau">Nh?? m???u</a></li>
<li><a href="#thanh-toan">Thanh to??n</a></li>
<li><a href="#tien-do">Ti???n ?????</a></li>
<li><a href="#tai-lieu">T??i li???u</a></li>
<li><a href="#chu-dau-tu">Ch??? ?????u t??</a></li>
</ul>
</div>
</div>
</div>
		</div>
	</div>
	</div>
			</div>
	</section>
<?php	}?>
	<section class="project-sumary  show_to_1024 width1140 padding-0-15">
		<div class="container">
			<?php  if($la_du_an == true)
 { ?>
            <div class="project-name">
                <div class="listing-detail">
                    <div class="listing-item">
                        <div class="item-left">Tr???ng th??i:</div>
                        <div class="item-right"><?php the_field('trang_thai'); ?></div>
                    </div>
                        <div class="listing-item">
                            <div class="item-left">Ch??? ?????u t??:</div>
                            <div class="item-right">
                                        <a title="<?php echo $ten_chu_dau_tu; ?>" href="<?php echo $link_chu_dau_tu; ?>"><?php echo $ten_chu_dau_tu_short; ?></a>

                            </div>
                        </div>
                        <div class="listing-item">
                            <div class="item-left">Lo???i h??nh:</div>
                            <div class="item-right">
                                    <span class="color slash"> <a href="<?php echo $link_loai_bds; ?>"><?php echo $ten_loai_bds;?></a></span>
                            </div>
                        </div>
                        <div class="listing-item">
                            <div class="item-left">S??? block:</div>
                            <div class="item-right"><?php the_field('so_block'); ?></div>
                        </div>
                        <div class="listing-item">
                            <div class="item-left">S??? t???ng:</div>
                            <div class="item-right"><?php the_field('so_tang'); ?></div>
                        </div>
                        <div class="listing-item">
                            <div class="item-left">S??? c??n:</div>
                            <div class="item-right"><?php the_field('so_can_ho'); ?></div>
                        </div>
					    <div class="listing-item">
                            <div class="item-left">Quy m??:</div>
                            <div class="item-right"><?php the_field('quy_mo_du_an'); ?></div>
                        </div>
					     <div class="listing-item">
                            <div class="item-left">M???t ????? x??y d???ng:</div>
                            <div class="item-right"><?php the_field('mat_do_xay_dung'); ?></div>
                        </div>

                </div>
                        

            </div>
			<?php } else {
			?>
			<section class="content-detail-house">
    <div class="width1140">
      <header class="detail-house">
          <!--
        <h1><?php echo $product->get_title(); ?></h1>
		  <div class="address">
			              <h2 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="1">
                                <a itemprop="item" href="<?php echo home_url( '/' ); ?>" title="Trang ch???">
                                    <meta itemprop="name" content="Trang ch???">
                                    Trang ch??? </a>
                            </h2>
			              <h2 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="2">
                                <a itemprop="item" href="<?php echo get_term_link( $product_cat->slug, 'product_cat' ); ?>" title="<?php echo $product_cat->name; ?>">
                                    <meta itemprop="name" content="<?php echo $product_cat->name; ?>">
                                   ??? <?php echo $product_cat->name; ?> </a>
                            </h2>
			     <?php
					if(! empty( $terms_khu_vuc_parent ) && ! is_wp_error( $terms_khu_vuc_parent )) { ?>
                            <h2 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="2">
                                <a itemprop="item" href="<?php echo $link_khuvuc_parent; ?>" title="<?php echo $terms_khu_vuc_parent->name; ?>">
                                    <meta itemprop="name" content="<?php echo $terms_khu_vuc_parent->name; ?>">
                                   ??? <?php echo $terms_khu_vuc_parent->name; ?> </a>
                            </h2>
					
					
					
					<?php 
					
					
					 if(! empty( $terms_khu_vuc_child ) && ! is_wp_error( $terms_khu_vuc_child )) { ?>
						    <h2 itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <meta itemprop="position" content="3">
                                <a itemprop="item" href="<?php echo $link_khuvuc_child; ?>" title="<?php echo $terms_khu_vuc_child->name; ?>">
                                    <meta itemprop="name" content="<?php echo $terms_khu_vuc_child->name; ?>">
                                    ??? <?php echo $terms_khu_vuc_child->name; ?> </a>
                            </h2>
					<?php }
					}
					?>
            
          </div>-->
        <div class="detail-row">
          <ul class="detailroom">
            <li title="Ph??ng ng???"><span class="font-icon bedroom"></span> <?php the_field('so_phong_ngu'); ?></li>
            <li title="Ph??ng t???m"><span class="font-icon bathroom"></span> <?php the_field('phong_wc'); ?></li>
              <li title="H?????ng nh??"><span class="font-icon direction"></span><span> <?php the_field('huong_ban_cong'); ?></span>
              </li>          
			  <li title="Di???n t??ch"><span class="font-icon area"></span> <?php the_field('dien_tich'); ?></li>
              <li title="T???ng"><span class="font-icon apartment-icon"></span> <?php the_field('tang_sp'); ?></li>
			  <li title="T??a/Block/L??"><span class="font-icon unitsbuilding-icon"></span> <?php the_field('toa_nha'); ?></li>
                
              
          </ul>
          
        </div>

      </header>
     
    </div>
  </section>
			
			<?php }?>
		</div>
        </section>
<div class="row content-row mb-0 <?php echo ($dem_hinh >=4?'hide_to_1024':''); ?>">
	<div class="product-gallery large-<?php echo flatsome_option('product_image_width'); ?> col">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		
	?>
		
	</div>

	<div class="product-info summary col-fit col entry-summary <?php flatsome_product_summary_classes();?>">
	<!-- thong tin sp -->
		
	<div class="box-lineHeight box-infomation-bds view_pc_info">
  
		 <?php
		 if($la_du_an == true){
			 ?>
	   <table class="tbl-info desktop">
        <tbody>
		<?php
			 if( $ten_chu_dau_tu !=''){
				
		?>
		
		   <tr>
			  <td><?php if($logo_chu_dau_tu=='') { echo 'Ch??? ?????u t??:' ;} else{
			
			    echo  '<a href="'. esc_url( $link_chu_dau_tu ) .'" title="'. esc_attr($ten_chu_dau_tu). '"><img class="logo_chudautu" alt="'. esc_attr($ten_chu_dau_tu). '" src="'. wp_get_attachment_url($logo_chu_dau_tu).'" /></a>';
		}
				?>
				</td>
			  <td colspan="3">
				 <?php
				 echo '<a href="'. esc_url( $link_chu_dau_tu ) .'" title="'. esc_attr($ten_chu_dau_tu). '">'. $ten_chu_dau_tu .'</a>';
				?>
				 </td>	
			</tr>	   
			<?php } ?>
		  <tr>
			  <td>Lo???i:</td>
			  <td><strong>
			<?php

	echo '<strong><a href="'. esc_url( $link_loai_bds ) .'" title="'. esc_attr($ten_loai_bds). '">'. $ten_loai_bds .'</a></strong>';

			 ?>
			 
			 </strong>
			  </td>
			  <td>Tr???ng th??i:</td><td><strong><?php the_field('trang_thai'); ?></strong></td>
			  
		  </tr>
		  <tr>
			  <td>S??? Block:</td><td><strong><?php the_field('so_block'); ?></strong></td>
			  <td>S??? t???ng:</td><td><strong><?php the_field('so_tang'); ?></strong></td>
			  
			  
		  </tr>	
			<tr>
			  <td>Quy m??:</td><td><strong><?php the_field('quy_mo_du_an'); ?></strong></td>
			  <td>M???t ????? x??y d???ng:</td><td><strong><?php the_field('mat_do_xay_dung'); ?></strong></td>
			  
			  
		  </tr>
		   <tr>
			  <td>S??? c??n h???:</td><td><strong><?php the_field('so_can_ho'); ?></strong></td>
			  <td>Ng??y ho??n th??nh:</td><td><strong><?php the_field('ngay_hoan_thanh'); ?></strong></td>
			  
			  
		  </tr>
			</tbody>
		</table>
		<table class="tbl-info mobile">
        <tbody>
				<?php
			 if( $ten_chu_dau_tu !=''){
				
		?>
		
		   <tr>
			  <td><?php if($logo_chu_dau_tu=='') { echo 'Ch??? ?????u t??:' ;} else{
			
			    echo  '<a href="'. esc_url( $link_chu_dau_tu ) .'" title="'. esc_attr($ten_chu_dau_tu). '"><img class="logo_chudautu" alt="'. esc_attr($ten_chu_dau_tu). '" src="'. wp_get_attachment_url($logo_chu_dau_tu).'" /></a>';
		}
				?>
				</td>
			  <td colspan="3">
				 <?php
				 echo '<a href="'. esc_url( $link_chu_dau_tu ) .'" title="'. esc_attr($ten_chu_dau_tu). '">'. $ten_chu_dau_tu .'</a>';
				?>
				 </td>	
			</tr>	   
			<?php } ?>
		  <tr>
			  <td colspan="2">Lo???i:</td>
			  <td colspan="2"><strong>
			<?php

	echo '<strong><a href="'. esc_url( $link_loai_bds ) .'" title="'. esc_attr($ten_loai_bds). '">'. $ten_loai_bds .'</a></strong>';

			 ?>
			 
			 </strong>
			  </td>
			 
			  
		  </tr>
			<tr><td colspan="2">Tr???ng th??i:</td><td colspan="2"><strong><?php the_field('trang_thai'); ?></strong></td></tr>
		  <tr>
			 <td colspan="2">S??? Block:</td><td colspan="2"><strong><?php the_field('so_block'); ?></strong></td>
			 
			  
			  
		  </tr>	
			<tr><td colspan="2">S??? t???ng:</td><td colspan="2"><strong><?php the_field('so_tang'); ?></strong></td>
			</tr>
			<tr>
			  <td colspan="2">Quy m??:</td><td colspan="2"><strong><?php the_field('quy_mo_du_an'); ?></strong></td>
			 
			  
			  
		  </tr>
		   <tr><td colspan="2">M???t ????? x??y d???ng:</td><td colspan="2"><strong><?php the_field('mat_do_xay_dung'); ?></strong></td></tr>
		   <tr>
			  <td colspan="2">S??? c??n h???:</td><td colspan="2"><strong><?php the_field('so_can_ho'); ?></strong></td>
			 
			  
			  
		  </tr>
			<tr><td colspan="2">Ng??y ho??n th??nh:</td><td colspan="2"><strong><?php the_field('ngay_hoan_thanh'); ?></strong></td></tr>
		</tbody>
		</table>	
	<?php	 }
			else {
		 ?>
		<table class="tbl-info desktop">
			<tbody>
		
            <tr>
                <td><span class="font-icon bedroom"></span><span class="span_info"> Ph??ng ng???:</span></td>
                <td><strong><?php the_field('so_phong_ngu'); ?></strong></td>
                <td><img src="/wp-content/themes/flatsome-child/image/ic_information06.svg"><span class="span_info"> Ph??p l??:</span></td>
                <td><strong><?php the_field('phap_ly'); ?></strong></td>
            </tr>
            <tr>
				 <td><img src="/wp-content/themes/flatsome-child/image/ic_information05.svg" ><span class="span_info"> Nhu c???u:</span></td>
				 <td><strong><?php global $product; 
echo $product->get_categories( ', ', ' ' . _n( ' ', '  ', $cat_count, 'woocommerce' ) . ' ', ' ' ); ?></strong></td>
                <td><img src="/wp-content/themes/flatsome-child/image/ic_information05.svg" ><span class="span_info"> Lo???i:</span></td>
                <td><?php

	echo '<strong><a href="'. esc_url( $link_loai_bds ) .'" title="'. esc_attr($ten_loai_bds). '">'. $ten_loai_bds .'</a></strong>';

			 ?></td>
                
            </tr>
            <tr>
                <td><span class="font-icon apartment-icon"></span><span class="span_info"> T???ng:</span></td>
                <td><strong><?php the_field('tang_sp'); ?></strong></td>
                <td><span class="font-icon apartment-icon"></span><span class="span_info"> T??a:</span></td>
                <td><strong><?php the_field('toa_nha'); ?></strong></td>
            </tr>
            <tr>
                <td><span class="font-icon direction"></span><span class="span_info"> H?????ng ban c??ng:</span></td>
                <td><strong><?php the_field('huong_ban_cong'); ?></strong></td>
				<td><span class="font-icon bathroom"></span><span class="span_info"> Ph??ng wc:</span></td>
                <td><strong><?php the_field('phong_wc'); ?></strong></td>
            </tr>
			 <tr><td colspan="2"><span class="font-icon area"></span><span class="span_info"> Di???n t??ch:</span></td><td colspan="2"><strong><?php the_field('dien_tich'); ?></strong></td>
			
			</tr>
			<?php if(get_field('trang_thai')) { ?>
           
			
            <tr><td colspan="2"><span class="span_info"> Tr???ng th??i:</span></td><td colspan="2"><strong><?php the_field('trang_thai'); ?></strong></td>
			
			</tr>
			<?php } ?>
            <tr><td colspan="4" rowspan="" headers=""><b style="color:red;">(*) Vui l??ng Click v??o ???nh ????? xem r?? nh???t</b></td></tr>
		 </tbody>
    </table>
		<table class="tbl-info mobile">
        <tbody>
			 <tr>
				<td colspan="2"><span class="font-icon area"></span><span class="span_info"> Di???n t??ch:</span></td>
				<td colspan="2"><strong><?php the_field('dien_tich'); ?></strong></td>
			
			</tr>
            <tr>
                <td colspan="2"><span class="font-icon bedroom"></span><span class="span_info"> Ph??ng ng???:</span></td>
                <td colspan="2"><strong><?php the_field('so_phong_ngu'); ?></strong></td>
                
            </tr>
			 <tr>
            	<td colspan="2"><span class="font-icon bathroom"></span><span class="span_info"> Ph??ng wc:</span></td>
                <td colspan="2"><strong><?php the_field('phong_wc'); ?></strong></td>
            </tr>
            <tr>
                <td colspan="2"><span class="font-icon apartment-icon"></span><span class="span_info"> T???ng:</span></td>
                <td colspan="2"><strong><?php the_field('tang_sp'); ?></strong></td>
                
            </tr>
            <tr>
            	<td colspan="2"><img src="/wp-content/themes/flatsome-child/image/ic_information06.svg"><span class="span_info"> Ph??p l??:</span></td>
                <td colspan="2"><strong><?php the_field('phap_ly'); ?></strong></td>
            </tr>
            <tr>
                <td colspan="2"><img src="/wp-content/themes/flatsome-child/image/ic_information05.svg" ><span class="span_info"> Nhu c???u:</span></td>
                <td colspan="2"><strong><?php global $product; 
echo $product->get_categories( ', ', ' ' . _n( ' ', '  ', $cat_count, 'woocommerce' ) . ' ', ' ' ); ?></strong></td>
                
            </tr>
			 <tr>
                <td colspan="2"><img src="/wp-content/themes/flatsome-child/image/ic_information05.svg" ><span class="span_info"> Lo???i:</span></td>
                <td colspan="2"><?php

	echo '<strong><a href="'. esc_url( $link_loai_bds ) .'" title="'. esc_attr($ten_loai_bds). '">'. $ten_loai_bds .'</a></strong>';

			 ?></td>
                
            </tr>
			
			
           
			<?php if(get_field('toa_nha')) { ?>
            <tr>
            	<td colspan="2"><span class="font-icon unitsbuilding-icon"></span><span class="span_info"> T??a:</span></td>
                <td colspan="2"><strong><?php the_field('toa_nha'); ?></strong></td>
            </tr>
			<?php } ?>
			<?php if(get_field('huong_ban_cong')) { ?>
            <tr>
                <td colspan="2"><span class="font-icon direction"></span><span class="span_info"> H?????ng ban c??ng:</span></td>
                <td colspan="2"><strong><?php the_field('huong_ban_cong'); ?></strong></td>
            </tr>
			<?php } ?>
			<?php if(get_field('trang_thai')) { ?>
            <tr><td colspan="2"><span class="span_info"> Tr???ng th??i:</span></td><td colspan="2"><strong><?php the_field('trang_thai'); ?></strong></td></tr>
			<?php } ?>
           
        </tbody>
    </table>
            <?php } ?>
		
   
</div>
		

	</div><!-- .summary -->

	<div id="product-sidebar" class="mfp-hide">
		<div class="sidebar-inner">
			<?php
				do_action('flatsome_before_product_sidebar');
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				if (is_active_sidebar( 'product-sidebar' ) ) {
					dynamic_sidebar('product-sidebar');
				} else if(is_active_sidebar( 'shop-sidebar' )) {
					dynamic_sidebar('shop-sidebar');
				}
			?>
		</div><!-- .sidebar-inner -->
	</div>

</div><!-- .row -->
</div><!-- .product-main -->
<?php if($kieu_hien_thi!=2) { ?>
		
       <div class="cta-bottom-wrapper <?php echo ($dem_hinh <4?'show_on_desktop':''); ?>">
            <div class="cta-bottom-inner">
                <div class="phone"><a class="cta-hotline" href="tel:<?php echo $contact_hotline_link ?>"><i class="fas fa-phone-alt"></i><strong><?php echo $contact_hotline; ?></strong></a></div>
                <div><a id="btn_requestinfo" data-target="contact-agent" class="cta-form request-info" href="javascript:void(0);"><?php echo ($la_du_an == true?$cta_text_du_an:$cta_text_nha_dat) ?></a>
                </div>
            </div>
       </div>
		<?php } else { 
		 echo do_shortcode('[lightbox id="mobile-property-form" width="600px" padding="20px"][block id="form-lien-he-chi-tiet-san-pham"][/lightbox]');
		
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
			
		
		<a class="btn-icon-envelop" href="#mobile-property-form">
			<i class="far fa-comment"></i>
		</a>
			</div>
		<div class="div-icon-phone">
				<a class="btn-icon-phone" href="tel:<?php echo $contact_hotline; ?>">
	         <i class="far fa-phone-alt"></i>
	     </a>
	 	</div>		
	</div><!-- d-flex -->
</div>
		<?php } ?>
<div class="product-footer">

	<div class="container">
	<div class="row">
	<div class="content_left large-8 small-12 col">
	<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			//do_action( 'woocommerce_single_product_summary' );
		?>
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			//do_action( 'woocommerce_after_single_product_summary' );
			?>
			<div id="tong-quan" class="box-collapse">
                    <h2 class="heading-02">T???ng quan</h2>
			   	    <div class="collapse" id="tab-description">
					    
							<?php  
				                 the_content();
				            ?>
							
					</div>
		        </div>	
		    <?php
		    if( have_rows('cac_tien_ich') ){
				?>
		        <div id="tien-ich" class="box-collapse">
                    <h2 class="heading-02">Ti???n ??ch</h2>
			   	    <div class="collapse">
					    <ul class="detail-commodities">
							<?php  
				                   while( have_rows('cac_tien_ich') ): the_row(); 
				                      echo '<li>'. get_sub_field('tien_ich') .'</li>'; 
				                   endwhile;
				            ?>
						</ul>	
					</div>
		        </div>		
			<?php
			}
		     if( have_rows('cac_noi_that') ){
				?>
		        <div id="noi-that" class="box-collapse">
                    <h2 class="heading-02">N???i th???t</h2>
			   	    <div class="collapse">
					    <ul class="detail-commodities">
							<?php  
				                   while( have_rows('cac_noi_that') ): the_row(); 
				                      echo '<li>'. get_sub_field('noi_that') .'</li>'; 
				                   endwhile;
				            ?>
						</ul>	
					</div>
		        </div>		
			
		 <?php 
				
			}
		  if(get_field('ban_do')) 
		   {
		   ?>
			  
		     <div id="vi-tri" class="box-collapse">
    <h2 class="heading-02">B???n ?????</h2>
    <div class="collapse">
		<?php  echo get_field('ban_do');  ?>
				 </div>
		</div>
		<!-- -->
        <?php 
				
			}
		  if(get_field('mat_bang')) 
		   {
		   ?>
			  
		     <div id="mat-bang" class="box-collapse">
    <h2 class="heading-02">M???t b???ng</h2>
    <div class="collapse">
		<?php  echo get_field('mat_bang');  ?>
				 </div>
		</div>
		  <!-- -->
		  <?php 
				
			}
		  if(get_field('thiet_ke')) 
		   {
		   ?>
			  
		     <div id="thiet-ke" class="box-collapse">
    <h2 class="heading-02">Thi???t k???</h2>
    <div class="collapse">
		<?php  echo get_field('thiet_ke');  ?>
				 </div>
		</div>
		  <!-- -->
		  <?php 
				
			}
		  if(get_field('nha_mau')) 
		   {
		   ?>
			  
		     <div id="nha-mau" class="box-collapse">
    <h2 class="heading-02">Nh?? m???u</h2>
    <div class="collapse">
		<?php  echo get_field('nha_mau');  ?>
				 </div>
		</div>
		
		<!-- -->
		<?php 
				
			}
		  if(get_field('thanh_toan')) 
		   {
		   ?>
			  
		     <div id="thanh-toan" class="box-collapse">
    <h2 class="heading-02">Thanh to??n</h2>
    <div class="collapse">
		<?php  echo get_field('thanh_toan');  ?>
				 </div>
		</div>
		<?php 
				
			}
		  if(get_field('tien_do')) 
		   {
		   ?>
			  
		     <div id="tien-do" class="box-collapse">
    <h2 class="heading-02">Ti???n ?????</h2>
    <div class="collapse">
		<?php  echo get_field('tien_do');  ?>
				 </div>
		</div>
		<!-- -->
		  <?php   } 
		
		   if(get_field('cac_tai_lieu') && have_rows('cac_tai_lieu')) 
		   { ?>
		   		  
		     <div id="tai-lieu" class="box-collapse">
    <h2 class="heading-02">T??i li???u</h2>
    <div class="collapse">
		<?php   if( have_rows('cac_tai_lieu') ){
			  echo '<ul class="content-document">';
				                   while( have_rows('cac_tai_lieu') ): the_row(); 
				                      echo '<li><div class="p-doc-relative-wrapper">'; 
			                          echo '<div class="img"><img src="'. get_sub_field('hinh_anh_tai_lieu') .'"/></div>';
			                          echo '<div class="info">';
			                          echo '<h4>'. get_sub_field('ten_tai_lieu') .'</h4>';
			                          echo '<div class="content-document-de"><p><strong>B???n nh???n ???????c g??:</strong></p>';
			                          echo get_sub_field('tl_mo_ta_ngan_gon');
			                          echo '</div>';
			                          echo '<div class="button-down"><a href="'. get_sub_field('tl_link_download') .'"  class="cta_button red-bnt" title="T???i t??i li???u" target="_blank">T???I T??I LI???U</a></div>';
			                          echo '</div>';
			                          echo '</div></li>';  
				                   endwhile;
			 echo '</ul>';	
			   
		   }  ?>
				 
	</div></div>
	<?php
			}
		    if($ten_chu_dau_tu!='' && $logo_chu_dau_tu !='' && $link_chu_dau_tu !=''){
		    ?>
		    <div id="chu-dau-tu" class="box-collapse">
                    <h2 class="heading-02">Ch??? ?????u t??</h2>
			   	    <div class="collapse">
						
                                    <div class="owner-project">
										<div class="image-owner-project">
											
										
                                            <a  href="<?php echo $link_chu_dau_tu; ?>">
                                              <img class="" alt="<?php echo $ten_chu_dau_tu; ?>" title="<?php echo $ten_chu_dau_tu; ?>" src="<?php echo wp_get_attachment_url($logo_chu_dau_tu);?>">
                                            </a>
											</div>
                                        <div class="info-owner-project">
                                            <p class="title">
                                                    <a href="<?php echo $link_chu_dau_tu; ?>"><strong><?php echo $ten_chu_dau_tu; ?></strong></a>
                                            </p>
                                            <div>
                                              <?php echo $mota_chu_dau_tu; ?>

                                                        <p><a style="color:#337588" href="<?php echo $link_chu_dau_tu; ?>">Xem th??m</a></p>
                                            </div>
                                        </div>
                                    </div>
                             
				    </div>
		    </div>
		    <!-- -->
		
		
		 <?php  
		   }
		    $bang_tinh_lai =  get_field('show_bang_tinh_lai_vay');
$gia_tri_nha_dat = get_field('gia_tri_nha_dat');
		  // echo $bang_tinh_lai;
		    if(get_field('show_bang_tinh_lai_vay') == 1 || get_field('show_bang_tinh_lai_vay') == true){
			?>
		    <div id="bang-tinh" class="box-collapse">
    <h2 class="heading-02">T??nh vay mua nh??</h2>
    <div class="collapse">
        <?php
			if($gia_tri_nha_dat == 0 & !get_field('gia_tri_nha_dat'))
			{
				
				echo  do_shortcode('[MortgageCalc /]');
			}
			else{
				
				echo do_shortcode('[MortgageCalc gia="'. $gia_tri_nha_dat .'" /]');
			}
			  ?>
				</div></div>
		<?php	}
		?>
		</div>
		<div class="content_right large-4 small-12 col">
			<div  id="content_right_fixed"  class="col-inner">
	
	   
		<div class="user-owner-list"> <img class="ava-user" src="<?php echo $contact_img; ?>" alt="<?php echo esc_attr($contact_title. ' - '. $contact_subtitle) ?>" title="<?php echo esc_attr($contact_title. ' - '. $contact_subtitle) ?>" style="height: 52px; object-fit: cover"><div class="name-us"> <?php echo $contact_title; ?></div><p class="user_title_pos"><?php echo $contact_subtitle; ?></p></div>
		<div class="text-center hotline">Hotline (24/7) <a href="tel:<?php echo $contact_hotline_link; ?>"><strong><?php echo $contact_hotline; ?></strong></a></div>
				<div class="text-center">
					ho???c
				</div>
		<?php 
				if($la_du_an == true){
				echo do_shortcode('[block id="form-lien-he-chi-tiet-san-pham"]'); 
				}
				else{
					echo do_shortcode('[block id="from-lien-he-xem-nha-dat"]'); 
					
				}
				?>
		
		</div>
		</div>
		</div>
		<!-- them sp lien quan -->
		<div id="sp_lienquan">
			
		
		<?php
	

if( ! is_a( $product, 'WC_Product' ) ){
    $product = wc_get_product(get_the_id());
}
$custom_taxterms = wp_get_object_terms( $product->get_id(), 'product_cat', array('fields' => 'ids') );
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 12,
    'columns'        => 3,
    'orderby'        => 'rand',
    'order'          => 'desc',
    'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $custom_taxterms
                )
            ),
);

$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

// Set global loop values.
wc_set_loop_prop( 'name', 'related' );
wc_set_loop_prop( 'columns', $args['columns'] );

wc_get_template( 'single-product/related.php', $args );
		 ?>
		</div>
	</div><!-- container -->
</div><!-- product-footer -->
</div><!-- .product-container -->
<?php } else {
	include(__DIR__ . '/khong_la_du_an.php');
}