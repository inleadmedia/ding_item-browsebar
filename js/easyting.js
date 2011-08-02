(function ($) {
  $(document).ready(function() {
    $('#primary-nav ul li').mouseover(function() {
      $(this).addClass('active');
      $(this).find('img').css({'opacity':'0'});
    });

    $('#primary-nav ul li').mouseout(function() {
      $(this).parent().find('li').removeClass('active');
      $(this).removeClass('active');
      $(this).find('img').css({'opacity':'1'});
    });

    if ($('body').hasClass('front')) {
      $("#foo").carouFredSel({
        curcular: false,
        infinite: false,
        auto : false,
        items: 5,
        scroll: 1,
        prev : {
          button : "#prev"
        },
        next : {
          button : "#next"
        },
        pagination : "#carousel_pager"
      });
    }
    else {
      $('#carousel-wrapper').hide();
    }
    
  });
})(jQuery);
