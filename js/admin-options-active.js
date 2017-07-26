var targetradio1 = jQuery('input[type="radio"][name="gl_scrollbar_show"]:checked').val() == "hide";
var targetradio2 = jQuery('input[type="radio"][name="gl_scrollbar_autohide"]:checked').val() == "false";
var targetHide1 = jQuery('.scrollbar-option-table tr:not(".show")');
var targetHide2 = jQuery('.auto-hide-delay');

if (targetradio1) {
    targetHide1.hide();
}
if (targetradio2) {
    targetHide2.hide();
}
jQuery(document).ready(function ($) {
    jQuery('#gl_scrollbar_bgcolor, #gl_scrollbar_cursor_color').wpColorPicker();

    jQuery('input[type="radio"][name="gl_scrollbar_show"]').change(function () {
        if (this.value == "hide") {
            targetHide1.stop(true, true).hide(400);
        } else {
            targetHide1.stop(true, true).show(400);
        }
    });

    jQuery('input[type="radio"][name="gl_scrollbar_autohide"]').change(function () {
        if (this.value == "false") {
            targetHide2.stop(true, true).hide(400);
        } else {
            targetHide2.stop(true, true).show(400);
        }
    });


});