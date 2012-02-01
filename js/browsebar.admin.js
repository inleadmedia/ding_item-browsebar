(function ($) {
  Drupal.behaviors.tingSearchCarousel = {
    attach: function(context) {
      $('.search-browsebar-query .remove').click(function () {
        $(this).parents('tr').remove();

        return false;
      });
    }
  }
})(jQuery);
