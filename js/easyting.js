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
        height: 300,
        width: 850,
        prev : {
          button : '#prev',
          onBefore : function() {
            // Restore previously magnified item and show it's details
            var ele = $('#carousel .result-item:eq(3)');
            restore(ele);
            ele.children('p').fadeIn();
            ele.find('.item-overlay').hide();
            ele.find('.item-overlay-details').hide();

            // Magnify item in the middle and style it's details
            ele = $('#carousel .result-item:eq(2)');
            magnify(ele);
            ele.children('p').fadeOut();
            
          },
          onAfter : function() {
            var ele = $('#carousel .result-item:eq(2)');
            ele.find('.item-overlay').fadeIn('fast');
            ele.find('.item-overlay-details').fadeIn('fast');
          }
        },
        next : {
          button : '#next',
          onBefore : function() {
            // Restore previously magnified item and show it's details
            var ele = $('#carousel .result-item:eq(2)');
            restore(ele);
            ele.children('p').fadeIn();
            ele.find('.item-overlay').hide();
            ele.find('.item-overlay-details').hide();
            
            // Magnify item in the middle and style it's details
            ele = $('#carousel .result-item:eq(3)');
            magnify(ele);
            ele.children('p').fadeOut();
          },
          onAfter : function() {
            var ele = $('#carousel .result-item:eq(2)');
            ele.find('.item-overlay').fadeIn('fast');
            ele.find('.item-overlay-details').fadeIn('fast');
          }
        },
        scroll : {
          items: 1
        },
        pagination : {
          container : '#carousel-pager'
        }
      });

      $('#carousel-pager a').unbind('click').bind('click', function() {return false;});
      $('#carousel .active .item-overlay').show();
      $('#carousel .active .item-overlay-details').show();
    }
    else {
      $('#carousel-wrapper').hide();
    }
    
  });

  var magnify = function(ele) {
    ele.find('img').animate({
      'height' : '240',
      'width' : '170'
    }, 500, function() {
      ele.removeClass('inactive').addClass('active');
      
    });

    ele.animate({
      'margin-top' : '0'
    }, 500);
  }

  var restore = function(ele) {
    ele.find('img').animate({
      'height' : '160',
      'width' : '120'
    }, 500, function() {
      ele.removeClass('active').addClass('inactive');
      ele.find('p').fadeIn(500);
      
    });

    ele.animate({
      'margin-top' : '42'
    }, 500);
  }
})(jQuery);
