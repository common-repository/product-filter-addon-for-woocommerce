<?php
/* protected */
if (!defined('ABSPATH'))
    exit;

//ajax hook
add_action('wp_ajax_nssProduct_ele_specfic_filter_addon', 'nssProduct_specfic_ajax_eleFilter');
add_action('wp_ajax_nopriv_nssProduct_ele_specfic_filter_addon', 'nssProduct_specfic_ajax_eleFilter');
function nssProduct_specfic_ajax_eleFilter()
{
    //all data are included here
    if (!DOING_AJAX || !check_ajax_referer('specfic_nonece_item', 'specficNonceVal'))
    {
        _e('Something went Wrong! ', 'nss-search-product');
    } 
    else
    {
        $selectFirstVal = sanitize_text_field($_GET['selectFirstVal']);
        $numberOfpage = sanitize_text_field($_GET['numberOfItem']);
        $args = array(
            'post_type' => 'product',
            'orderby'   => 'title',
            'order'   => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'id',
                    'terms'     => $selectFirstVal
                ),
            ),
            'posts_per_page' => $numberOfpage,
        );
        ?>
        <div class="nss-content-page-products">
            <ul class="products">
                <?php
                $search_query = new \WP_Query($args);
                if ($search_query->have_posts()) :
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
                                        if (function_exists('woocommerce_template_loop_add_to_cart')) :
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
            else :
                _e('No products found', 'nss-search-product');
            endif;
            wp_reset_query();
            ?>
        </div>
    <?php
    }
    die();
}