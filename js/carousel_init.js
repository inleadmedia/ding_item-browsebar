(function ($) {
  var carouselItems = 5;
  $(document).ready(function() {
    // Shows the items hidden by details layer.
    $("#carousel-content").carouFredSel({
      curcular: false,
      infinite: false,
      auto : false,
      items: carouselItems,
      height: 300,
      width: 820,
      prev : {
        button : '#prev',
        onBefore : function() {
          // Restore previously magnified item and show it's details
          var ele = $('#carousel .result-item:eq(' + (window.selectedIndex != null ? carouselItems - window.selectedIndex - 1 : 3) + ')');
          restore(ele);
          
          // Magnify item in the middle and style it's details
          ele = $('#carousel .result-item:eq(2)');
          magnify(ele);
        },
        onAfter : afterScroll
      },
      next : {
        button : '#next',
        onBefore : function() {
          // Restore previously magnified item and show it's details
          var ele = $('#carousel .result-item:eq(2)');
          restore(ele);

          // Magnify item in the middle and style it's details
          ele = $('#carousel .result-item:eq(' + (window.selectedIndex != null ? window.selectedIndex : 3) + ')');
          magnify(ele);
        },
        onAfter : afterScroll
      },
      scroll : {
        items: 1
      },
      pagination : {
        container : '#carousel-pager'
      }
    })
    // Scroll to the selected item
    .find('div.result-item').click(function() {
      if ($(this).hasClass('active')) {
        return;
      }
      window.selectedIndex = $('div.result-item').index(this);
      if (window.selectedIndex > carouselItems / 2) {
        $("#carousel-content").trigger("next", [null, window.selectedIndex - Math.floor(carouselItems / 2)]);
      }
      else {
        $("#carousel-content").trigger("prev", [null, Math.floor(carouselItems / 2) - window.selectedIndex]);
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
      }, 500).addClass('show-me');
      $('#carousel .result-item:eq(4)').animate({
        'opacity' : 0
      }, 500).addClass('show-me');
    });

    // Handler for hiding the carousel
    $('#carousel .carousel-close').click(function() {
      $(this).parent().parent().hide('fast');
    });
  })
  
  // Magnification handler
  var magnify = function(ele) {
    ele.animate({
      'margin-top' : '0'
    }, 500).children('img').animate({
      'height' : '240',
      'width' : '170'
    }, 500, function() {
      ele.removeClass('inactive').addClass('active');
      window.selectedIndex = null;      
    });
    
    ele.children('p').fadeOut();
    
    ele.animate({
      'margin-top' : '0'
    }, 500);
  }

  // Restoration handler
  var restore = function(ele) {
    ele.animate({
      'margin-top' : '42'
    }, 500).children('img').animate({
      'height' : '160',
      'width' : '120'
    }, 500, function() {
      ele.removeClass('active').addClass('inactive');
      ele.children('p').fadeIn(500);      
    });
    
    ele.find('.item-overlay').hide();
    ele.find('.item-overlay-details').hide();
    ele.find('.result-item-details').fadeOut(100);    
    
    ele.animate({
      'margin-top' : '42'
    }, 500);
  }
  
  var afterScroll = function () {
    var ele = $('#carousel .result-item:eq(2)');
    ele.find('.item-overlay').fadeIn('fast');
    ele.find('.item-overlay-details').fadeIn('fast');

    $('#carousel .result-item.show-me').each(function() {
      $(this).animate({
        'opacity' : 1
      }, 100).removeClass('show-me');
    });
  }
  
  Drupal.ajax.prototype.commands['carousel_refresh'] = function (ajax, response, status) {
    alert(1);
    console.log(response);
  }
  
})(jQuery);
