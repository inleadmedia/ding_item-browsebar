(function ($) {
  $(document).ready(function() {
    // Create carousel jQuery object.
    Browsebar = $("#browsebar-content");

    // Responsivity.
    Browsebar.responsiveConfig = {
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
    var layoutIndex = $('#omega-media-query-dummy').css('z-index');
    Browsebar.initLayout  = (layoutIndex == '-1') ? 'mobile' : Drupal.settings.omega.layouts.order[layoutIndex];
    if (Browsebar.responsiveConfig[Browsebar.initLayout] == undefined) {
      Browsebar.initLayout = 'normal';
    }
    Browsebar.defaultConfig = Browsebar.responsiveConfig[Browsebar.initLayout];

    // Add custom function for getting carousel config options.
    Browsebar.getOption = function(opt){
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

    Browsebar.scrollOnBefore = function(direction) {
      var items = Browsebar.find('.result-item');
      var activeItem = items.filter('.active');
      var activeItemIndex = items.index(activeItem);
      var magnifyItemIndex;
      if (direction == 'prev') {
        magnifyItemIndex = Browsebar.getOption('centralIndex');
      }
      else {
        magnifyItemIndex = window.selectedIndex != null ? window.selectedIndex : Browsebar.getOption('centralIndex') + 1;
      }
      // Restore previously magnified item and show it's details.
      if (Browsebar.getOption('items.visible') == 1 || activeItemIndex != magnifyItemIndex) {
        restore(activeItem);

        // Magnify item in the middle and style it's details.
        if (Browsebar.getOption('items.visible') != 1) {
          var ele = $('#browsebar .result-item').eq(magnifyItemIndex);
          magnify(ele);
        }
      }
    }

    // Set active central item.
    if (Browsebar.defaultConfig.items != 1) {
      var centralIndex = Math.floor(Browsebar.defaultConfig.items / 2);
      Browsebar.find('.inactive').eq(centralIndex).removeClass('inactive').addClass('active');
    }

    // Show item details or not.
    Browsebar.find('.result-item').attr('showItemInfo', Browsebar.defaultConfig.showItemInfo);

    // Shows the items hidden by details layer.
    Browsebar.carouFredSel({
      curcular: false,
      infinite: false,
      auto : false,
      items: Browsebar.defaultConfig.items,
      height: 315,
      prev : {
        button : '#prev',
        onBefore : function() { Browsebar.scrollOnBefore('prev') },
        onAfter : afterScroll
      },
      next : {
        button : '#next',
        onBefore : function() { Browsebar.scrollOnBefore('next') },
        onAfter : afterScroll
      },
      scroll : {
        items: 1
      },
      pagination : {
        container : '#browsebar-pager'
      }
    })
    // Scroll to the selected item
    .find('div.result-item').live('click', function() {
      if ($(this).hasClass('active') || Browsebar.getOption('items.visible') == 1) {
        return;
      }
      window.selectedIndex = Browsebar.find('div.result-item').index(this);
      var centralIndex = Browsebar.getOption('centralIndex');
      if (window.selectedIndex > Browsebar.defaultConfig.items / 2) {
        $("#browsebar-content").trigger("next", window.selectedIndex - centralIndex);
      }
      else {
        $("#browsebar-content").trigger("prev", centralIndex - window.selectedIndex);
      }
    });

    $('#browsebar .active .item-overlay').show();
    $('#browsebar .active .item-overlay-details').show();

    // Handler for clicking on carousel active item
    $('#browsebar .active').live('click', function() {
      var centralIndex = Browsebar.getOption('centralIndex');
      if ($(this).children('.result-item-details:visible').length > 0) {
        $(this).children('.result-item-details').fadeOut(500);
        $('#browsebar .result-item').eq(centralIndex + 1).animate({
          'opacity' : 1
        }, 500).addClass('show-me');
        $('#browsebar .result-item').eq(centralIndex + 2).animate({
          'opacity' : 1
        }, 500).addClass('show-me');
      } else {
        $(this).children('.result-item-details').fadeIn(500);
        $('#browsebar .result-item').eq(centralIndex + 1).animate({
          'opacity' : 0
        }, 500).addClass('show-me');
        $('#browsebar .result-item').eq(centralIndex + 2).animate({
          'opacity' : 0
        }, 500).addClass('show-me');
      }
    });

    // Make click on link prevent from hiding popup
    $('#browsebar .active a').live('click', function(e) {
      e.stopPropagation();
    });

    // Handler for hiding the carousel
    $('#browsebar-wrapper .browsebar-display').toggle(function() {
      $('#browsebar-wrapper').find('.caroufredsel_wrapper').animate({
        'height':'0px'
      }, 500);
      $('.browsebar-header').hide('fast');
      $('.search-controller').hide('fast');
      $('.scroll').hide();
      $(this).removeClass('close').addClass('open');
    }, function() {
      $('#browsebar-wrapper').find('.caroufredsel_wrapper').animate({
        'height':'315px'
      }, 500, function() { $('.scroll').show('fast'); });
      $('.browsebar-header').show('fast');
      $('.search-controller').show('fast');
      $(this).removeClass('open').addClass('close');
    });


    /**
     * Carousel filter popup menu
     */

    // Open popup
    $('#browsebar-bar-filter .open').live('click', function(e) {
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
    $('#browsebar-bar-filter .close').live('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var $this = $(this);

      if ($this.hasClass('close')) {
        var popup = $this.parents('.popup:first');
        popup.hide();
      }
      else {
        $('#browsebar-bar-filter .close').click();
      }
    });

    // Collapse carousel if page is not front.
    if (!$('body').hasClass('front') || Browsebar.initLayout == 'mobile') {
      $('#browsebar .caroufredsel_wrapper').hide();
      $('#browsebar-wrapper .close').click();
      setTimeout(function(){ $('#browsebar .caroufredsel_wrapper').show(); }, 500);
    }

    Browsebar.bind('responsivelayout', function(event, layouts) {
      var carouselIsClosed = $('#browsebar-wrapper .browsebar-display').hasClass('open');
      if (carouselIsClosed) return;
      if ($.browser.msie && $.browser.version < 9) return;

      var config;
      var slideEvent;
      if (layouts.to == 'mobile') {
        config = Browsebar.responsiveConfig.mobile;
      }
      else if (layouts.to == 'narrow') {
        config = Browsebar.responsiveConfig.narrow;
      }
      else {
        config = Browsebar.responsiveConfig.normal;
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
      if (Browsebar.getOption('items.visible') != config.items) {
        // Items counst from previous carousel init.
        var prevItems = Browsebar.getOption('items.visible');
        var activeItem = Browsebar.find('.result-item.active');
        // From Mobile to any.
        if (prevItems == 1) {
          var el = Browsebar.find('.result-item').eq(Math.floor(config.items / 2))
          magnify(el, 0);
        }
        // From any to Mobile.
        if (config.items == 1) {
          restore(activeItem, 0);
        }
        // Show item details or not.
        Browsebar.find('.result-item').attr('showItemInfo', config.showItemInfo);
        // View items.
        Browsebar.trigger('configuration', ['items.visible', config.items]);
        // Correct pager.
        Browsebar.trigger('updatePageStatus', [true]);
        // Centralize active item.
        var qty = Math.abs((prevItems - config.items) / 2);
        Browsebar.trigger(slideEvent, qty);
      }
    });

    // On click go to item landing page, if needed.
    Browsebar.find('.result-item').bind('click', function(){
      var item = $(this);
      var showItemInfo = item.attr('showItemInfo');
      if (showItemInfo == '0') {
        if (item.hasClass('active')) {
          // Prevent item popup will be visible.
          item.find('.result-item-details').show().find('*').hide();
        }
        // Go tp item page.
        if (item.hasClass('active') || Browsebar.getOption('items.visible') == 1) {
          var href = item.find('h1 a').attr('href');
          window.location = href;
        }
      }
      else {
        item.find('.result-item-details *').show();
      }
    });

    // Touchwipe.
    Browsebar.touchwipe({
      wipeLeft: function() {
        Browsebar.trigger('next');
      },
      wipeRight: function() {
        Browsebar.trigger('prev');
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
    var items = Browsebar.getOption('items.visible');
    if (items > 1) {
      var centralIndex = Browsebar.getOption('centralIndex');
      var ele = $('#browsebar .result-item').eq(centralIndex);
      ele.find('.item-overlay').fadeIn('fast');
      ele.find('.item-overlay-details').fadeIn('fast');
    }

    $('#browsebar .result-item.show-me').each(function() {
      $(this).animate({
        'opacity' : 1
      }, 100).removeClass('show-me');
    });
  }
  
  Drupal.ajax.prototype.commands['browsebar_refresh'] = function (ajax, response, status) {
    // Check if something was found.
    if (!response.content) {
      alert(Drupal.t('Sorry, no items were found.'));
      return;
    }

    $('#browsebar-wrapper:hidden').show('fast');

    // Safely remove items
    var l = $('#browsebar-content .result-item').length;
    for (i = 0; i < l; i++) {
      $("#browsebar-content").trigger('removeItem', [i]);
    }

    var responseItems = $(response.content).filter('.result-item');

    // Set active central item.
    if (Browsebar.defaultConfig.items != 1) {
      var itemsVisible = Browsebar.getOption('items.visible');
      var itemsCount = (responseItems.length < itemsVisible) ? responseItems.length : itemsVisible;
      var centralIndex = Math.floor(itemsCount / 2);
    }

    // Safely add new item list
    responseItems.each(function(i, e) {
      if (i == centralIndex) {
        $(e).removeClass('inactive').addClass('active');
      }
      $("#browsebar-content").trigger('insertItem', e);
    });

    $('#browsebar .active .item-overlay').show();
    $('#browsebar .active .item-overlay-details').show();
  }

  Drupal.ajax.prototype.commands['browsebar_update_facets'] = function (ajax, response, status) {
    if (!$(response.content).find('ul li').length) {
      return;
    }
    $('#browsebar-wrapper:hidden').show('fast');
    $('#browsebar-bar-filter').html(response.content);
    Drupal.attachBehaviors($('#browsebar-bar-filter'));
  }
})(jQuery);
