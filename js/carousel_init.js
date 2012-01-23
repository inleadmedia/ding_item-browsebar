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
    var layoutIndex = $('#omega-media-query-dummy').css('z-index');
    var layoutName  = Drupal.settings.omega.layouts.order[layoutIndex];
    if (Carousel.responsiveConfig[layoutName] == undefined) {
      layoutName = 'normal';
    }
    Carousel.defaultConfig = Carousel.responsiveConfig[layoutName];

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
      var activateItemIndex;
      // Hide item details.
      Carousel.toggleItemDetails(activeItem, 0, 300);
      if (direction == 'next') {
        activateItemIndex = window.selectedIndex != null ? window.selectedIndex : Carousel.getOption('centralIndex') + 1;
      }
      else {
        activateItemIndex = Carousel.getOption('centralIndex');
      }
      // Inactivate previous item.
      if (Carousel.getOption('items.visible') == 1 || activeItemIndex != activateItemIndex) {
        Carousel.setItemInactive(activeItem);

        // Activate item in the middle and style it's details.
        if (Carousel.getOption('items.visible') != 1) {
          var ele = $('#carousel .result-item').eq(activateItemIndex);
          Carousel.setItemActive(ele);
        }
      }
    }

    Carousel.scrollOnAfter = function() {
      var centralItemIndex = Carousel.getOption('centralIndex');
      var centralItem = $('#carousel .result-item').eq(centralItemIndex);
      Carousel.setItemActive(centralItem);
    }

    Carousel.toggleItemDetails = function(itemElem, show, delay) {
      var item = $(itemElem);
      var nextItemsOpacity;
      if (show) {
        item.children('.result-item-details').fadeIn(delay);
        nextItemsOpacity = 0;
      }
      else {
        item.children('.result-item-details').fadeOut(delay);
        nextItemsOpacity = 1;
      }
      item.next().animate({
        'opacity' : nextItemsOpacity
      }, delay)
      .next().animate({
        'opacity' : nextItemsOpacity
      }, delay);
    }

    Carousel.setItemActive = function(ele) {
      ele.removeClass('inactive').addClass('active');
      window.selectedIndex = null;
    }

    Carousel.setItemInactive = function(ele) {
      ele.removeClass('active').addClass('inactive');
    }

    // Set active central item.
    if (Carousel.defaultConfig.items != 1) {
      var centralIndex = Math.floor(Carousel.defaultConfig.items / 2);
      var centralItem = Carousel.find('.inactive').eq(centralIndex);
      Carousel.setItemActive(centralItem);
    }

    // Show item details or not.
    Carousel.find('.result-item').attr('showItemInfo', Carousel.defaultConfig.showItemInfo);

    // Carousel initialization.
    Carousel.carouFredSel({
      curcular: false,
      infinite: false,
      auto : false,
      items: Carousel.defaultConfig.items,
      prev : {
        button : '#prev',
        onBefore : function() { Carousel.scrollOnBefore('prev') }
      },
      next : {
        button : '#next',
        onBefore : function() { Carousel.scrollOnBefore('next') }
      },
      scroll : {
        items: 1,
        onBefore: Carousel.scrollOnBefore,
        onAfter:  Carousel.scrollOnAfter
      },
      pagination : {
        container : '#carousel-pager'
      }
    })
    // Scroll to the selected item.
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

    // Handler for clicking on carousel active item.
    $('#carousel .active').live('click', function() {
      if ($(this).children('.result-item-details:visible').length > 0) {
        Carousel.toggleItemDetails(this, 0, 500);
      } else {
        Carousel.toggleItemDetails(this, 1, 500);
      }
    });

    // Make click on link prevent from hiding popup.
    $('#carousel .active a').live('click', function(e) {
      e.stopPropagation();
    });

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
        // Layout width increases.
        slideEvent = 'prev';
      }
      else if ((layouts.from != 'mobile') && (layouts.to == 'narrow' || layouts.to == 'mobile')) {
        // Layout width decreases.
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
          Carousel.setItemActive(el);
        }
        // From any to Mobile.
        if (config.items == 1) {
          Carousel.setItemInactive(activeItem);
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


  // Ajax.
  Drupal.ajax.prototype.commands['carousel_refresh'] = function (ajax, response, status) {
    // Check if something was found.
    if (!response.content) {
      alert(Drupal.t('Sorry, no items were found.'));
      return;
    }

    $('#carousel-wrapper:hidden').show('fast');

    // Safely remove items.
    var l = $('#carousel-content .result-item').length;
    for (i = 0; i < l; i++) {
      $("#carousel-content").trigger('removeItem', [i]);
    }

    var responseItems = $(response.content).filter('.result-item');

    // Calculate item index, that should be activated.
    if (Carousel.defaultConfig.items != 1) {
      var itemsVisible = Carousel.getOption('items.visible');
      var itemsCount = (responseItems.length < itemsVisible) ? responseItems.length : itemsVisible;
      var centralIndex = Math.floor(itemsCount / 2);
    }

    // Safely add new item list.
    responseItems.each(function(i, e) {
      if (i == centralIndex) {
        Carousel.setItemActive(e);
      }
      $("#carousel-content").trigger('insertItem', e);
    });
  }
})(jQuery);
