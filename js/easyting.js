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
      //var ele = $('#carousel .result-item:eq(2)');
      //magnify(ele);
      
      $("#foo").carouFredSel({
        curcular: false,
        infinite: false,
        auto : false,
        items: 5,
        scroll: 1,
        height: 300,
        width: 850,
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

  var magnify = function(ele) {
    ele.find('img').animate({
      'height' : 240,
      'margin-top' : '-60',
      'width' : 170
    }, 500);
  }

  var restore = function(ele) {
    
  }
})(jQuery);
