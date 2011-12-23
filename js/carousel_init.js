(function ($) {
  $(document).ready(function() {
    // Create carousel jQuery object.
    Carousel = $("#carousel-content");

    // Responsivity.
    Carousel.responsiveConfig = {
      mobile: {
        items: 1,
        showItemInfo: 0
      },
      narrow: {
        items: 3,
        showItemInfo: 0
      },
      normal: {
        items: 5,
        showItemInfo: 1
      }
    }

    // Select default config for first init.
    var carouselWidth = Carousel.width();
    if (carouselWidth < 480) {
      Carousel.defaultConfig = Carousel.responsiveConfig.mobile;
    }
    else if (carouselWidth < 960) {
      Carousel.defaultConfig = Carousel.responsiveConfig.narrow;
    }
    else {
      Carousel.defaultConfig = Carousel.responsiveConfig.normal;
    }

    // Add custom function for getting carousel config options.
    Carousel.getOption = function(opt){
      var val;
      if (opt == 'centralIndex') {
        var items = this.getOption('items.visible');
        return Math.floor(items / 2);
      }
      // Get carousel config option.
      else {
        this.trigger('configuration', [opt, function(value){
          val = value;
        }]);
      }
      return val;
    }

    Carousel.scrollOnBefore = function(direction) {
      var items = Carousel.find('.result-item');
      var activeItem = items.filter('.active');
      var activeItemIndex = items.index(activeItem);
      var magnifyItemIndex;
      if (direction == 'prev') {
        magnifyItemIndex = Carousel.getOption('centralIndex');
      }
      else {
        magnifyItemIndex = window.selectedIndex != null ? window.selectedIndex : Carousel.getOption('centralIndex') + 1;
      }
      // Restore previously magnified item and show it's details.
      if (Carousel.getOption('items.visible') == 1 || activeItemIndex != magnifyItemIndex) {
        restore(activeItem);

        // Magnify item in the middle and style it's details.
        if (Carousel.getOption('items.visible') != 1) {
          var ele = $('#carousel .result-item').eq(magnifyItemIndex);
          magnify(ele);
        }
      }
    }

    // Set active central item.
    if (Carousel.defaultConfig.items != 1) {
      var centralIndex = Math.floor(Carousel.defaultConfig.items / 2);
      Carousel.find('.inactive').eq(centralIndex).removeClass('inactive').addClass('active');
    }

    // Show item details or not.
    Carousel.find('.result-item').attr('showItemInfo', Carousel.defaultConfig.showItemInfo);

    // Shows the items hidden by details layer.
    Carousel.carouFredSel({
      curcular: false,
      infinite: false,
      auto : false,
      items: Carousel.defaultConfig.items,
      height: 315,
      prev : {
        button : '#prev',
        onBefore : function() { Carousel.scrollOnBefore('prev') },
        onAfter : afterScroll
      },
      next : {
        button : '#next',
        onBefore : function() { Carousel.scrollOnBefore('next') },
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
      if ($(this).hasClass('active') || Carousel.getOption('items.visible') == 1) {
        return;
      }
      window.selectedIndex = $('div.result-item').index(this);
      var centralIndex = Carousel.getOption('centralIndex');
      if (window.selectedIndex > Carousel.defaultConfig.items / 2) {
        $("#carousel-content").trigger("next", window.selectedIndex - centralIndex);
      }
      else {
        $("#carousel-content").trigger("prev", centralIndex - window.selectedIndex);
      }
    });

    // Disable the pager, as it is laggy
    $('#carousel-pager a').unbind('click').bind('click', function() {return false;});
    $('#carousel .active .item-overlay').show();
    $('#carousel .active .item-overlay-details').show();

    // Handler for clicking on carousel active item
    $('#carousel .active').live('click', function() {
      var centralIndex = Carousel.getOption('centralIndex');
      if ($(this).children('.result-item-details:visible').length > 0) {
        $(this).children('.result-item-details').fadeOut(500);
        $('#carousel .result-item').eq(centralIndex + 1).animate({
          'opacity' : 1
        }, 500).addClass('show-me');
        $('#carousel .result-item').eq(centralIndex + 2).animate({
          'opacity' : 1
        }, 500).addClass('show-me');
      } else {
        $(this).children('.result-item-details').fadeIn(500);
        $('#carousel .result-item').eq(centralIndex + 1).animate({
          'opacity' : 0
        }, 500).addClass('show-me');
        $('#carousel .result-item').eq(centralIndex + 2).animate({
          'opacity' : 0
        }, 500).addClass('show-me');
      }
    });

    // Make click on link prevent from hiding popup
    $('#carousel .active a').live('click', function(e) {
      e.stopPropagation();
    });

    // Handler for hiding the carousel
    $('#carousel .carousel-display').toggle(function() {
      $('.caroufredsel_wrapper').animate({
        'height':'0px'
      }, 500);
      $('.carousel-header').hide('fast');
      $('.search-controller').hide('fast');
      $('.scroll').hide();
      $(this).removeClass('close').addClass('open');
    }, function() {
      $('.caroufredsel_wrapper').animate({
        'height':'315px'
      }, 500, function() { $('.scroll').show('fast'); });
      $('.carousel-header').show('fast');
      $('.search-controller').show('fast');
      $(this).removeClass('open').addClass('close');
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

    Carousel.bind('responsivelayout', function(event, layouts) {
      if ($.browser.msie && $.browser.version < 9) return;

      var config;
      var slideEvent;
      if (layouts.to == 'mobile') {
        config = Carousel.responsiveConfig.mobile;
      }
      else if (layouts.to == 'narrow') {
        config = Carousel.responsiveConfig.narrow;
      }
      else {
        config = Carousel.responsiveConfig.normal;
      }
      // Centralize active item direction.
      if ((layouts.from == 'mobile') || (layouts.from == 'narrow' && layouts.to != 'mobile')) {
        // Layout width increases
        slideEvent = 'prev';
      }
      else if ((layouts.from != 'mobile') && (layouts.to == 'narrow' || layouts.to == 'mobile')) {
        // Layout width decreases
        slideEvent = 'next';
      }
      // Avoid meaningless carousel reinit.
      if (Carousel.getOption('items.visible') != config.items) {
        // Items counst from previous carousel init.
        var prevItems = Carousel.getOption('items.visible');
        var activeItem = Carousel.find('.result-item.active');
        // From Mobile to any.
        if (prevItems == 1) {
          var el = Carousel.find('.result-item').eq(Math.floor(config.items / 2))
          magnify(el, 0);
        }
        // From any to Mobile.
        if (config.items == 1) {
          restore(activeItem, 0);
        }
        // Show item details or not.
        Carousel.find('.result-item').attr('showItemInfo', config.showItemInfo);
        // View items.
        Carousel.trigger('configuration', ['items.visible', config.items]);
        // Correct pager.
        Carousel.trigger('updatePageStatus', [true]);
        // Centralize active item.
        var qty = Math.abs((prevItems - config.items) / 2);
        Carousel.trigger(slideEvent, qty);
      }
    });

    // On click go to item landing page, if needed.
    Carousel.find('.result-item').bind('click', function(){
      var item = $(this);
      var showItemInfo = item.attr('showItemInfo');
      if (showItemInfo == '0') {
        if (item.hasClass('active')) {
          // Prevent item popup will be visible.
          item.find('.result-item-details').show().find('*').hide();
        }
        // Go tp item page.
        if (item.hasClass('active') || Carousel.getOption('items.visible') == 1) {
          var href = item.find('h1 a').attr('href');
          window.location = href;
        }
      }
      else {
        item.find('.result-item-details *').show();
      }
    });

    // Touchwipe.
    Carousel.touchwipe({
      wipeLeft: function() {
        Carousel.trigger('next');
      },
      wipeRight: function() {
        Carousel.trigger('prev');
      }
    });
  });


  // Magnification handler
  var magnify = function(ele, duration) {
    if (duration == undefined) {
      duration = 500;
    }
    ele.animate({
      'margin-top' : '0'
    }, duration).children('img').animate({
      'height' : '240',
      'width' : '170'
    }, duration, function() {
      ele.removeClass('inactive').addClass('active');
      window.selectedIndex = null;      
    });
    
    ele.children('p').fadeOut();
    
    ele.animate({
      'margin-top' : '0'
    }, duration);
  }

  // Restoration handler
  var restore = function(ele, duration) {
    if (duration == undefined) {
      duration = 500;
    }
    ele.animate({
      'margin-top' : '42'
    }, duration).children('img').animate({
      'height' : '160',
      'width' : '120'
    }, duration, function() {
      ele.removeClass('active').addClass('inactive');
      ele.children('p').fadeIn(duration);
    });
    
    ele.find('.item-overlay').hide();
    ele.find('.item-overlay-details').hide();
    ele.find('.result-item-details').fadeOut(duration / 5);
    
    ele.animate({
      'margin-top' : '42'
    }, duration);
  }
  
  var afterScroll = function () {
    var items = Carousel.getOption('items.visible');
    if (items > 1) {
      var centralIndex = Carousel.getOption('centralIndex');
      var ele = $('#carousel .result-item').eq(centralIndex);
      ele.find('.item-overlay').fadeIn('fast');
      ele.find('.item-overlay-details').fadeIn('fast');
    }

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
      return;
    }

    $('#carousel-wrapper:hidden').show('fast');

    // Safely remove items
    var l = $('#carousel-content .result-item').length;
    for (i = 0; i < l; i++) {
      $("#carousel-content").trigger('removeItem', [i]);
    }

    var responseItems = $(response.content).filter('.result-item');

    // Set active central item.
    if (Carousel.defaultConfig.items != 1) {
      var itemsVisible = Carousel.getOption('items.visible');
      var itemsCount = (responseItems.length < itemsVisible) ? responseItems.length : itemsVisible;
      var centralIndex = Math.floor(itemsCount / 2);
    }

    // Safely add new item list
    responseItems.each(function(i, e) {
      if (i == centralIndex) {
        $(e).removeClass('inactive').addClass('active');
      }
      $("#carousel-content").trigger('insertItem', e);
    });

    $('#carousel .active .item-overlay').show();
    $('#carousel .active .item-overlay-details').show();
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
