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
      $("#coverflow").carouFredSel({
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
            ele.find('.result-item-details').fadeOut(100);

            // Magnify item in the middle and style it's details
            ele = $('#carousel .result-item:eq(2)');
            magnify(ele);
            ele.children('p').fadeOut();
          },
          onAfter : function() {
            var ele = $('#carousel .result-item:eq(2)');
            ele.find('.item-overlay').fadeIn('fast');
            ele.find('.item-overlay-details').fadeIn('fast');

            $('#carousel .inactive').each(function() {
              $(this).animate({
                'opacity' : 1
              }, 100);
            });
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
            ele.find('.result-item-details').fadeOut(100);


            // Magnify item in the middle and style it's details
            ele = $('#carousel .result-item:eq(3)');
            magnify(ele);
            ele.children('p').fadeOut();
          },
          onAfter : function() {
            var ele = $('#carousel .result-item:eq(2)');
            ele.find('.item-overlay').fadeIn('fast');
            ele.find('.item-overlay-details').fadeIn('fast');

            $('#carousel .result-item').each(function() {
              $(this).animate({
                'opacity' : 1
              }, 100);
            });
          }
        },
        scroll : {
          items: 1
        },
        pagination : {
          container : '#carousel-pager'
        }
      });

      // Disable the pager, as it is laggy
      $('#carousel-pager a').unbind('click').bind('click', function() {return false;});
      $('#carousel .active .item-overlay').show();
      $('#carousel .active .item-overlay-details').show();

      // Animation for carousel menu
      $('#carousel-menu ul li a').click(function() {
        $(this).parent().parent().find('a').removeClass('active');
        $(this).addClass('active');

        return false;
      });

      // Handler for clicking on carousel active item
      $('#carousel .active').live('click', function() {
        $(this).children('.result-item-details').fadeIn(500);
        $('#carousel .result-item:eq(3)').animate({
          'opacity' : 0
        }, 500)
        $('#carousel .result-item:eq(4)').animate({
          'opacity' : 0
        }, 500)
      });

      // Handler for hiding the carousel
      $('#carousel .carousel-close').click(function() {
        $(this).parent().parent().hide('fast');
      });


      /**
       * Carousel filter popup menu
       */

      // Open popup
      $('#carousel-bar-filter .open').live('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $this = $(this);
        var popup = $this.prev().filter('.popup');
        try {
          popup.show();
        }
        catch (err) {
        }
      });

      // Close popup
      $('body, #carousel-bar-filter .close').live('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $this = $(this);

        if ($this.hasClass('close')) {
          var popup = $this.parents('.popup:first');
          popup.hide();
        }
        else {
          $('#carousel-bar-filter .close').click();
        }
      });

      // Select filter param from popup
      $('#carousel-bar-filter .popup li a').live('click', function(e) {
        e.preventDefault();
        var $this = $(this);

        $this.parents('ul:first').find('a').removeClass('selected');
        $this.addClass('selected');

        var selectedText = $(this).text();
        var openButtonTextWrapper = $('#carousel-bar-filter .open .text');
        openButtonTextWrapper.text(selectedText);
        $('body').click();
      });

      // Select default filter param
      $('#carousel-bar-filter .popup li a.selected').click();

    }
  });

  var magnify = function(ele) {
    ele.children('img').animate({
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
    ele.children('img').animate({
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
