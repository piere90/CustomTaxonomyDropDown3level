<?php

/*
Plugin Name: Custom Taxonomy DropDown
Author: Hameedullah Khan
Aurhot URI: http://hameedullah.com
 */

// change this to your taxonomy
$brand_taxonomy = 'brands';
$taxonomy_name = 'Brands';

/* registering taxonomy */
/* disabled assuming you already have regsitered taxonomy */
/*
add_action('init', 'my_taxonomy');
function my_taxonomy() {
    global $brand_taxonomy, $taxonomy_name;
    register_taxonomy($brand_taxonomy,array('post'),array('labels'=>array('name'=>$taxonomy_name),'public'=>true,'hierarchical'=>true));
}*/


add_action('add_meta_boxes', 'my_custom_metabox');
function my_custom_metabox() {
    add_meta_box('custom-taxonomy-dropdown','Brands','taxonomy_dropdowns_box','post','side','high');
}

function taxonomy_dropdowns_box( $post ) {
    global $brand_taxonomy, $taxonomy_name;
    wp_nonce_field('custom-dropdown', 'dropdown-nonce');
    $terms = get_terms( $brand_taxonomy, 'hide_empty=0');
    if ( is_a( $terms, 'WP_Error' ) ) {
        $terms = array();
    }

    $object_terms = wp_get_object_terms( $post->ID, $brand_taxonomy, array('fields'=>'ids'));
    if ( is_a( $object_terms, 'WP_Error' ) ) {
        $object_terms = array();
    }

    // you can move the below java script to admin_head
?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
                jQuery('#custombrandoptions').change(function() {
                    var custombrand = jQuery('#custombrandoptions').val();
                    if ( custombrand == '0') {
                        jQuery('#custommodeloptions').html('');
                            jQuery('#modelcontainer').css('display', 'none');
                    } else {
                        var data = {
                            'action':'get_brand_models',
                            'custombrand':custombrand,
                            'dropdown-nonce': jQuery('#dropdown-nonce').val()
                        };
                        jQuery.post(ajaxurl, data, function(response){
                            jQuery('#custommodeloptions').html(response);
                            jQuery('#modelcontainer').css('display', 'inline');
                        });
                    }
                });
        });
    </script>
    <?php
    echo "Brand:";
    echo "<select id='custombrandoptions' name='custombrands[]'>";
    echo "<option value='0'>None</option>";
    foreach ( $terms as $term ) {
        if ( $term->parent == 0) {
            if ( in_array($term->term_id, $object_terms) ) {
                $parent_id = $term->term_id;
                echo "<option value='{$term->term_id}' selected='selected'>{$term->name}</option>";
            } else {
                echo "<option value='{$term->term_id}'>{$term->name}</option>";
            }
        }
    }
    echo "</select><br />";
    echo "<div id='modelcontainer'";
    if ( !isset( $parent_id)) echo " style='display: none;'";
    echo ">";
    echo "Models:";
    echo "<select id='custommodeloptions' name='custombrands[]'>";
    if ( isset( $parent_id)) {
        $models = get_terms( $brand_taxonomy, 'hide_empty=0&child_of='.$parent_id);
        foreach ( $models as $model ) {
             if ( in_array($model->term_id, $object_terms) ) {
                echo "<option value='{$model->term_id}' selected='selected'>{$model->name}</option>";
            } else {
                echo "<option value='{$model->term_id}'>{$model->name}</option>";
            }
        }
    }
    echo "</select>";
    echo "</div>";
}

add_action('save_post','save_my_custom_taxonomy');
function save_my_custom_taxonomy( $post_id ) {
    global $brand_taxonomy, $taxonomy_name;
    if ( define('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return;

    if ( !wp_verify_nonce($_POST['dropdown-nonce'], 'custom-dropdown'))
        return;

    $brands = array_map('intval', $_POST['custombrands']);
    wp_set_object_terms($post_id, $brands, $brand_taxonomy);
}

add_action('wp_ajax_get_brand_models', 'get_brand_models');
function get_brand_models() {
    global $brand_taxonomy, $taxonomy_name;
    check_ajax_referer('custom-dropdown', 'dropdown-nonce');
    if (isset($_POST['custombrand'])) {
        $models = get_terms( $brand_taxonomy, 'hide_empty=0&child_of='. $_POST['custombrand']);
        echo "<option value='0'>Select one</option>";
        foreach ($models as $model) {
            echo "<option value='{$model->term_id}'>{$model->name}</option>";
        }
    }
    die();
}

?>
