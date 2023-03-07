/**handles:mh-js**/
jQuery(document).ready(function () {
	var menufixed = false;
	if(jQuery('#link_ref').length){
jQuery('#link_ref').val(location.href);
}
		if(jQuery('#link_ref2').length){
jQuery('#link_ref2').val(location.href);
}
if(jQuery('#link_bds').length){
jQuery('#link_bds').val(location.href);
}
	if(jQuery('#link_bds_2').length){
jQuery('#link_bds_2').val(location.href);
}
jQuery("#floating-container").on("click",function(e){
	
	if(jQuery("#floating-container").hasClass("open")){
		
		jQuery(this).removeClass("open");
		jQuery(".dark-bg").remove();
	}
	else{
		jQuery(this).addClass("open");
		jQuery("body").append('<div class="dark-bg"></div>');
		
	}
});
jQuery("#btn_requestinfo").on("click",function(e){	
	var target = jQuery('#content_right_fixed');
    if (target.length) {
        jQuery('html,body').animate({
            scrollTop: target.offset().top - 90
        }, 1000);
        return false;
    }
});
		
				jQuery('.menuProductWrap').hide();
		       jQuery(".mnfixed_wrap").hide();
	if (jQuery('.MenuFixxed').length) {
			 jQuery(".MenuFixxed").mnfixed();
			
				jQuery('.menuProductWrap').show();
		      jQuery(".mnfixed_wrap").show();
		var tongquanoffset =  jQuery('#tong-quan').offset().top;
       var hT = jQuery('#tong-quan').offset().top,
       hH = jQuery('#tong-quan').height(),
       wH = jQuery(window).height();
        jQuery(window).scroll(function() {
            var $winOffset = jQuery(this).scrollTop();
			  //var   wS = jQuery(this).scrollTop(); 	

  
			if( (hT > $winOffset) && menufixed == false){
				menufixed = true;
		
				
				
			} 
            jQuery(".box-collapse").each(function() {
                var $ih = jQuery(this).innerHeight();
                var $io = jQuery(this).offset().top;
                var $ihref = jQuery(this).attr('id');
                var $iho = $ih + $io;
                var $ahref = ".menuProduct ul li a[href='#" + $ihref + "']";
                if (($io - 90) < $winOffset && ($iho - 85) > $winOffset) {
                    jQuery(".menuProduct ul li").removeClass("active");
                    jQuery($ahref).parents("li").addClass("active");
                }
            });
        });
		
        jQuery(".menuProduct ul li a").click(function() {
            jQuery(".menuProduct ul li").removeClass("active");
            jQuery(this).parents("li").addClass("active");
			var a_href = jQuery(this).attr('href');
			
    jQuery('html, body').animate({
        scrollTop: jQuery(a_href).offset().top - 55
    }, 1000);

            return false;
        });
    }
});