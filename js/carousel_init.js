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
    .find('div.result-item').live('click', function() {
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

    // Handler for clicking on carousel active item
    $('#carousel .active').live('click', function() {
      if ($(this).children('.result-item-details:visible').length > 0) {
        $(this).children('.result-item-details').fadeOut(500);
        $('#carousel .result-item:eq(3)').animate({
          'opacity' : 1
        }, 500).addClass('show-me');
        $('#carousel .result-item:eq(4)').animate({
          'opacity' : 1
        }, 500).addClass('show-me');
      } else {
        $(this).children('.result-item-details').fadeIn(500);
        $('#carousel .result-item:eq(3)').animate({
          'opacity' : 0
        }, 500).addClass('show-me');
        $('#carousel .result-item:eq(4)').animate({
          'opacity' : 0
        }, 500).addClass('show-me');
      }
    });

    // Make click on link prevent from hiding popup
    $('#carousel .active a').live('click', function(e) {
      e.stopPropagation();
    });

    // Handler for hiding the carousel
    $('#carousel .carousel-close').click(function() {
      $(this).parent().parent().hide('fast');
      $('#s-nav li').removeClass('current');
    });


    /**
     * Carousel filter popup menu
     */

    // Open popup
    $('#carousel-bar-filter .open').live('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var $this = $(this);
      var popup = $this.next().filter('.popup');
      try {
        popup.show();
      }
      catch (err) {
      }
    });

    // Close popup
    $('#carousel-bar-filter .close').live('click', function(e) {
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
    });

    // Select default filter param
    $('#carousel-bar-filter .popup li a.selected').click();

    // Show carousel only on front
    if (!$('body').hasClass('front')) {
      $('#carousel-wrapper').hide();
    }
  });
  
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
    // Check if something was found.
    if (!response.content) {
      alert(Drupal.t('Sorry, no items were found.'));
      $('#s-nav li').removeClass('current');
      return;
    }

    $('#carousel-wrapper:hidden').show('fast');

    // Safely remove items
    var l = $('#carousel-content .result-item').length;
    for (i = 0; i < l; i++) {
      $("#carousel-content").trigger('removeItem', [i]);
    }

    // Safely add new item list
    $(response.content).each(function(i, e) {
      $("#carousel-content").trigger('insertItem', e);
    });
  }

  Drupal.ajax.prototype.commands['carousel_update_facets'] = function (ajax, response, status) {
    if (!$(response.content).find('ul li').length) {
      return;
    }
    $('#carousel-wrapper:hidden').show('fast');
    $('#carousel-bar-filter').html(response.content);
    Drupal.attachBehaviors($('#carousel-bar-filter'));
  }
})(jQuery);
