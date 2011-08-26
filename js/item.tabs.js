  jQuery(document).ready(function() {
    jQuery('.tab-container .description-tab-header').click(function() {
      jQuery('.tab-container .details-tab-header').removeClass('active');
      jQuery(this).addClass('active');
      jQuery('.ting-object-additional .description').css({display: ''});
      jQuery('.ting-object-additional .details').css({display: 'none'});
    });    
    jQuery('.tab-container .details-tab-header').click(function() {
      jQuery('.tab-container .description-tab-header').removeClass('active');
      jQuery(this).addClass('active');
      jQuery('.ting-object-additional .details').css({display: ''});
      jQuery('.ting-object-additional .description').css({display: 'none'});
    });    
  });