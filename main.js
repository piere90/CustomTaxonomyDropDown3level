jQuery(document).ready(function ($) {

    jQuery('#custombrandoptions').change(function () {
        var custombrand = jQuery('#custombrandoptions').val();
        if (custombrand == '0') {
            jQuery('#custommodeloptions2').html('');
            jQuery('#custommodeloptions').html('');
            jQuery('#modelcontainer').css('display', 'none');
            jQuery('#modelcontainer1').css('display', 'none');
        } else if (custombrand != '0') {
            jQuery('#ctd-custom-taxonomy-terms-loading').css('display', 'inline');
            jQuery('#modelcontainer').css('display', 'none');
            var data = {
                'action': 'get_brand_models',
                'custombrand': custombrand,
                'dropdown-nonce': jQuery('#dropdown-nonce').val()
            };
            jQuery.post(script_vars.ajax_url, data, function (response) {
                jQuery('#custommodeloptions').html(response);
                jQuery('#ctd-custom-taxonomy-terms-loading').css('display', 'none');
                jQuery('#modelcontainer').css('display', 'inline');
            });
        }
    });

    jQuery('#custommodeloptions').change(function () {
        var custombrand1 = jQuery('#custommodeloptions').val();
        if (custombrand1 == '0') {
            jQuery('#custommodeloptions2').html('');
            jQuery('#modelcontainer1').css('display', 'none');
        } else if (custombrand1 != '0') {
            jQuery('#ctd-custom-taxonomy-terms-loading2').css('display', 'inline');
            jQuery('#modelcontainer1').css('display', 'none');
            var data = {
                'action': 'get_brand_models1',
                'custombrand1': custombrand1,
                'dropdown-nonce': jQuery('#dropdown-nonce').val()
            };
            jQuery.post(script_vars.ajax_url, data, function (response) {
                jQuery('#custommodeloptions2').html(response);
                jQuery('#ctd-custom-taxonomy-terms-loading2').css('display', 'none');
                jQuery('#modelcontainer1').css('display', 'inline');
            });
        }
    });

});