/**
 * For filter pages
 * Edit meta value
 */
jQuery(function($){
    $('.target').click(function () {
        var el = $(this);
        var checked = el.prop( "checked") ? 1 : 0;
        console.log(checked);
        $.post(ajax_object.ajaxurl, {
            action: 'ajax_action',
            post_id: el.val(),
            checked: checked,
        }, function(data) {
            alert(data); // alerts 'ajax submitted'
        });
    });
});