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

    if ($.browser.msie && $.browser.version < 9) {
      Browsebar.defaultConfig = Browsebar.responsiveConfig['normal'];
    }

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
      activeItem.find('.result-item-details').fadeOut(500);
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
        container : '#browsebar-pager',
        onBefore : function() {
          restore(Browsebar.find('.result-item.active'));
        },
        onAfter : function() {
          magnify(Browsebar.find('.result-item').eq(2));
          setTimeout(function(){ afterScroll() }, 500);
        }
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

    setTimeout(function(){ $('#browsebar').css({'visibility':'visible'}); }, 1000);

    $('#browsebar .active .item-overlay').show();
    $('#browsebar .active .item-overlay-details').show();

    // Handler for clicking on carousel active item
    $('#browsebar .active').live('click', function() {
      var centralIndex = Browsebar.getOption('centralIndex');
      if ($(this).children('.result-item-details:visible').length > 0) {
        $(this).children('.result-item-details').fadeOut(500);
      } else {
        $(this).children('.result-item-details').fadeIn(500);
      }
    });

    // Make click on link prevent from hiding popup
    $('#browsebar .active a').live('click', function(e) {
      e.stopPropagation();
    });

    // Handler for hiding the carousel
    var collapseElement = $('#browsebar-wrapper').find('#browsebar');
    var collapseElementHeight = collapseElement.height();
    $('#browsebar-wrapper .browsebar-display').toggle(function() {
      collapseElementHeight = collapseElement.height();
      collapseElement.animate({
        'height': '0px'
      }, 500).find('.caroufredsel_wrapper').hide();
      $('.browsebar-header').hide('fast');
      $('.search-controller').hide('fast');
      $('.scroll').hide();
      $(this).removeClass('close').addClass('open');
      // Store browsebar state
      $.cookie('browsebar-status', 'off');
    }, function() {
      collapseElement.animate({
        'height': collapseElementHeight + 'px'
      }, 500, function() { $('.scroll').show('fast'); }).find('.caroufredsel_wrapper').show().css('visibility', 'visible');
      $('.browsebar-header').show('fast');
      $('.search-controller').show('fast');
      $(this).removeClass('open').addClass('close');
      // Store browsebar state
      $.cookie('browsebar-status', 'on');
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

    // Collapse carousel.
    var browsebarStatusCollapsed = $.cookie('browsebar-status') == 'off';
    var noBrowsebarStatus = $.cookie('browsebar-status') == null;
    var isFrontPage = $('body').hasClass('front');
    var browserIsIEgt8 = $.browser.msie && $.browser.version > 8;
    if (
        browsebarStatusCollapsed && !isFrontPage || // Status collapsed from cookies and is not front page.
        !isFrontPage || // Not front page.
        Browsebar.initLayout == 'mobile' && browserIsIEgt8 // Layout mobile and browser is IE9+
      ) {
      $('#browsebar .caroufredsel_wrapper').hide();
      $('#browsebar-wrapper .close').click();
      setTimeout(function () {
        $('#browsebar .caroufredsel_wrapper').show().css('visibility', 'hidden');
      }, 500);
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
    ele.removeClass('inactive').addClass('active');
    window.selectedIndex = null;
  }

  // Restoration handler
  var restore = function(ele, duration) {
    ele.removeClass('active').addClass('inactive');
    ele.find('.result-item-details').fadeOut(duration / 5);
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
