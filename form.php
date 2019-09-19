<?php
// change this to your taxonomy
$brand_taxonomy = 'indirizzo';
$taxonomy_name = 'indirizzo';

global $post;
wp_nonce_field('custom-dropdown', 'dropdown-nonce');
$terms = get_terms($brand_taxonomy, 'hide_empty=0');
if (is_a($terms, 'WP_Error')) {
    $terms = array();
}
$object_terms = wp_get_object_terms($post->ID, $brand_taxonomy,
  array('fields' => 'ids'));
if (is_a($object_terms, 'WP_Error')) {
    $object_terms = array();
}
// you can move the below java script to admin_head
?>
<h5>Paese</h5>
<select id='custombrandoptions' name='custombrands[]'>
    <option value='0'>None</option>
    <?php
    foreach ($terms as $term) {
        if ($term->parent == 0) {
            if (in_array($term->term_id, $object_terms)) {
                $parent_id = $term->term_id;
                echo "<option value='{$term->term_id}' selected='selected'>{$term->name}</option>";
            } else {
                echo "<option value='{$term->term_id}'>{$term->name}</option>";
            }
        }
    }
    ?>
</select><br/>
<div id='ctd-custom-taxonomy-terms-loading' style='display:none;'>
    Loading...
</div>
<div id='modelcontainer'<?php if (!isset($parent_id)) echo " style='display: none;'" ?>>
    <h5>Regione</h5>
    <select id='custommodeloptions' name='custombrands[]'>
        <?php
        if (isset($parent_id)) {
            $models = get_terms($brand_taxonomy, 'hide_empty=0&child_of=' . $parent_id);
            foreach ($models as $model) {
                if (in_array($model->term_id, $object_terms)) {
                    echo "<option value='{$model->term_id}' selected='selected'>{$model->name}</option>";
                } else {
                    echo "<option value='{$model->term_id}'>{$model->name}</option>";
                }
            }
        }
        ?>
    </select>
</div>
<br/>
<div id='ctd-custom-taxonomy-terms-loading2' style='display:none;'>
    Loading...
</div>
<div id='modelcontainer1'<?php if (!isset($parent_id)) echo " style='display: none;'" ?>>
    <h5>Provincia</h5>
    <select id='custommodeloptions2' name='custombrands[]'>
        <?php
        if (isset($parent_id)) {
            $models = get_terms($brand_taxonomy, 'hide_empty=0&child_of=' . $parent_id);
            foreach ($models as $model) {
                if (in_array($model->term_id, $object_terms)) {
                    echo "<option value='{$model->term_id}' selected='selected'>{$model->name}</option>";
                } else {
                    echo "<option value='{$model->term_id}'>{$model->name}</option>";
                }
            }
        }
        ?>
    </select>
</div>