<?php

//this function is used to pass the variables between PHP and JS
function do_scripts()
{

    $version = 2;
    wp_enqueue_script('localize-js',
      get_stylesheet_directory_uri() . '/script/localize.js', array(), $version,
      true);
    $script_vars = array(
      'ajax_url' => admin_url( 'admin-ajax.php' ) //you will see here that ajax url will be used in main.js
    );

    /* actually enqueue jquery (that ships with WP) and your custom script */
    wp_enqueue_script('jquery');
    wp_enqueue_script('localize-js');

    /* Localize the vairables */
    wp_localize_script('localize-js', 'script_vars', $script_vars);
}

add_action('save_post', 'save_my_custom_taxonomy');


function save_my_custom_taxonomy($post_id)
{
    $brand_taxonomy = 'indirizzo';
    $taxonomy_name = 'indirizzo';
    if (define('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!wp_verify_nonce($_POST['dropdown-nonce'], 'custom-dropdown')) {
        return;
    }
    $brands = array_map('intval', $_POST['custombrands']);
    wp_set_object_terms($post_id, $brands, $brand_taxonomy);
}

add_action('wp_ajax_get_brand_models', 'get_brand_models');
function get_brand_models()
{
    $brand_taxonomy = 'indirizzo';
    $taxonomy_name = 'indirizzo';
    check_ajax_referer('custom-dropdown', 'dropdown-nonce');
    if (isset($_POST['custombrand'])) {
        $models = get_terms($brand_taxonomy,
          'hide_empty=0&parent=' . $_POST['custombrand']);
        echo "<option value='0'>Select one</option>";
        foreach ($models as $model) {
            echo "<option value='{$model->term_id}'>{$model->name}</option>";
        }
    }
    die();
}

add_action('wp_ajax_get_brand_models1', 'get_brand_models1');
function get_brand_models1()
{
    $brand_taxonomy = 'indirizzo';
    $taxonomy_name = 'indirizzo';
    check_ajax_referer('custom-dropdown', 'dropdown-nonce');
    if (isset($_POST['custombrand1'])) {
        $models = get_terms($brand_taxonomy,
          'hide_empty=0&parent=' . $_POST['custombrand1']);
        echo "<option value='0'>Select one</option>";
        foreach ($models as $model) {
            echo "<option value='{$model->term_id}'>{$model->name}</option>";
        }
    }
    die();
}