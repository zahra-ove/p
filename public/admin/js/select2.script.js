(function ($) {
    "use strict";
   $('.select2').each(function () {
    $(this).select2({
      theme: 'bootstrap4',
      width: 'style',
      dir: "rtl",
      placeholder: $(this).attr('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
  });

})(jQuery);
