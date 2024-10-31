<?php
//Three Step fields
if (!defined('ABSPATH'))
    exit;
    
add_action('wp_ajax_nssProduct_ele_filter_addon', 'nssProduct_ajax_eleFilter');
add_action('wp_ajax_nopriv_nssProduct_ele_filter_addon', 'nssProduct_ajax_eleFilter');
function nssProduct_ajax_eleFilter()
{
    //parent data
    $parents_terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0));
    $parentVal = sanitize_text_field($_GET['parentVal']);
    $catItem = sanitize_text_field($_GET['nssCatItem']);
    if (isset($parentVal) && $parentVal != '') 
    {
        ?>
            <option disabled selected="selected"><?php echo esc_html($catItem); ?></option>
        <?php
        foreach ($parents_terms as $parent_product_cat) 
        {
            $child_args = array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent'   => $parent_product_cat->term_id
            );
            $child_product_cats = get_terms($child_args);
            if ($parent_product_cat->term_id == $parentVal) :
                foreach ($child_product_cats as $child_product_cat) {
            ?>
                <option value="<?php echo esc_attr($child_product_cat->term_id); ?>"><?php echo esc_html($child_product_cat->name); ?></option>
            <?php
            }
            endif;
        }
    }
    //child data
    $childVal = sanitize_text_field($_GET['childVal']);
    $catItem_sub = sanitize_text_field($_GET['nss_cat_sub_item']);
    if (isset($childVal) && $childVal != '') 
    {
        ?>
        <option selected="selected" disabled><?php echo esc_html($catItem_sub); ?></option>
        <?php
        foreach ($parents_terms as $parent_product_cat) {
            $child_args = array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent'   => $parent_product_cat->term_id
            );
            $child_product_cats = get_terms($child_args);
            $child_id = "";
            foreach ($child_product_cats as $child_product_cat) {
                $sschild_args = array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                    'parent'   => $child_product_cat->term_id
                );
                $sschild_product_cats = get_terms($sschild_args);
                $child_id = $child_product_cat->term_id;
                if ($child_id == $childVal) :
                    foreach ($sschild_product_cats as $sscat) 
                    {
                    ?>
                        <option value="<?php echo esc_attr($sscat->term_id); ?>"><?php echo esc_html($sscat->name); ?></option>
                    <?php
                    }
                endif;
            }
        }
    }
    //all data are included here
    if (DOING_AJAX || check_ajax_referer('threeStepNonceVal', 'nonceThreeStep')) 
    {
        $selectFirstItem = sanitize_text_field($_GET['selectFirstItem']);
        $selectSecondItem = sanitize_text_field($_GET['selectSecondItem']);
        $selectThirdItem = sanitize_text_field($_GET['selectThirdItem']);
        $ppsData = sanitize_text_field($_GET['numberOfPage']);

        foreach ($parents_terms as $parent_product_cat) {
            $child_args = array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent'   => $selectFirstItem
            );
            $child_product_cats = get_terms($child_args);
            foreach ($child_product_cats as $child_product_cat) {
                $sschild_args = array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                    'parent'   => $selectSecondItem
                );
                $sschild_product_cats = get_terms($sschild_args);
                $ssCid = '';
                foreach ($sschild_product_cats as $sscat) {
                    $ssCid = $sscat->term_id;
                    if ($ssCid == $selectThirdItem) :
                        $cc = $ssCid;
                    endif;
                }
            }
        }
        $args = array(
            'post_type' => 'product',
            'orderby'   => 'title',
            'order'   => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'id',
                    'terms'     => $cc
                ),
            ),
            'posts_per_page' => $ppsData
        );
        ?>        
        <div class="nss-content-page-products">
            <ul class="products">
                <?php
                $search_query = new \WP_Query($args);
                if($search_query->have_posts()):
                    while ($search_query->have_posts()) :
                    $search_query->the_post();
                    ?>
                    <li class="product-warp-item">
                        <div class="wow fadeInUp product-item animated">
                            <div class="product-inner">
                                <div class="product-img-wrap">
                                    <div class="product-img-wrap-inner">
                                        <?php do_action('woocommerce_before_shop_loop_item_title'); ?>
                                    </div>
                                </div>
                                <div class="product-info-wrap">
                                    <div class="info">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo substr(get_the_title(),0,15).'..'; ?>
                                        </a>
                                        <?php do_action('woocommerce_after_shop_loop_item_title'); ?>
                                    </div>
                                    <div class="addtoCart">
                                        <?php
                                        if(function_exists('woocommerce_template_loop_add_to_cart')):
                                            woocommerce_template_loop_add_to_cart();
                                        endif;
                                        ?>  
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </li>
                    <?php
                    endwhile;
                    ?>
            </ul>
            <?php
            else:
                _e('No products found', 'nss-search-product');
            endif;
            wp_reset_query();
            ?>
        </div>
    <?php
    }
    else {
        _e('Something went wrong!', 'nss-search-product');
    }
    die();
}


