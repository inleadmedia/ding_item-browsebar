(function ($) {
  $(document).ready(function() {
    $('#block-system-main-menu li').hover(
      function(){
        $('ul:first', $(this)).show();
      },
      function(){
        $('ul', $(this)).hide();
      }
    );

    // Header navigation subnav popup
    $('.subnav-trigger').click(function(e){
      e.preventDefault();
      e.stopPropagation();

      var popupId = $(this).attr('href');
      var popup = $(popupId);
      if (popup.is(':visible')) {
        // Hide all popups
        $(document).click();
      }
      else {
        // Hide all popups
        $(document).click();
        // Show popup
        $(popupId).show();
      }
    });
    // Hide all subnav popups on all document clicks
    $(document).click(function(){
      $('.subnav-popup').hide();
    });

  });
})(jQuery);
