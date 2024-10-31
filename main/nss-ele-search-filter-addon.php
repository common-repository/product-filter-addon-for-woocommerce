<?php
/*********************
****Elementor Widget**
**********************/
/* protected */

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 *
 * @since 1.0
 */

class nss_search_ele_Widget extends Widget_Base
{

	public function get_name()
	{
		return 'nss-elem-search';
	}

	public function get_title()
	{
		return esc_html__('Category Search', 'nss-search-product');
	}

	public function get_icon()
	{
		return ' eicon-search';
	}

	public function get_categories()
	{
		return ['nss_eleaddon_filter_category'];
	}

	/**
	 * Register Edu_Exp widget controls.
	 *
	 * @since 1.0
	 */
	protected function _register_controls()
	{

		$this->start_controls_section(
			'category_search_info',
			[
				'label' => esc_html__('Category Search Filter', 'nss-search-product'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'category_step',
			[
				'label' => __('Setp Selector', 'nss-search-product'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'one_step'  => __('One Step', 'nss-search-product'),
					'two_step' => __('Two Step', 'nss-search-product'),
					'three_step' => __('Three Step', 'nss-search-product'),
					'specfic_step' => __('Specfic Step', 'nss-search-product'),
				],
				'default' => ['one_step'],
			]
		);
		$this->add_control(
			'category_id',
			[
				'label' => __('Specfic ID', 'nss-search-product'),
				'description' => __('When you select "specfic step" than enter specfic category ID here. ', 'nss-search-product'),
				'type' => Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 5,
				'default' => 20,
			]
		);
		$this->add_control(
			'post_per_pages',
			[
				'label' => __('Post Per Page', 'nss-search-product'),
				'description' => __('How many Product do you went to show?', 'nss-search-product'),
				'type' => Controls_Manager::TEXT,
				'default' => 5,
			]
		);
		$this->add_control(
			'category_item',
			[
				'label' => __('Category Name', 'nss-search-product'),
				'description' => __('Enter select option name which you went', 'nss-search-product'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Select Product',
			]
		);
		$this->add_control(
			'category_sub_item',
			[
				'label' => __('Sub Cat Name', 'nss-search-product'),
				'description' => __('Enter select option name which you went', 'nss-search-product'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Select Product Category',
			]
		);
		$this->add_control(
			'category_sub_sub_item',
			[
				'label' => __('Sub Child Name', 'nss-search-product'),
				'description' => __('Enter select option name which you went', 'nss-search-product'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Select Product Sub Category',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render Edu_Exp widget output on the frontend.
	 *
	 * @since 1.0
	 * 
	 */

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$cat_step = $settings['category_step'];
		$cat_step_id = $settings['category_id'];
		$pps = $settings['post_per_pages'];
		$category_item = $settings['category_item'];
		$category_sub_item = $settings['category_sub_item'];
		$category_sub_sub_item = $settings['category_sub_sub_item'];
		?>
		<div class="nss-form-filter">
			<?php
			if (($cat_step == 'specfic_step') && $cat_step_id) 
			{
				?>
				<form id="search_specfic_form_ajax" method="GET">
					<?php
					$term_ID = get_term_by('id', $cat_step_id , 'product_cat');   
					$parent_terms = get_terms('product_cat', array('hide_empty' => 0, 'parent' => $term_ID->term_id, 'order' => 'ASC', 'orderby' => 'title'));
					?>
					<div class="nss-select-option-1">
						<select id="nss_specfic_select1">
							<option disabled selected="selected"><?php echo esc_html($category_item); ?></option>
							<?php
							if(is_array($parent_terms) && $parent_terms != '')
							{
								foreach ($parent_terms as $term) 
								{
								?>
									<option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
								<?php
								}
							}
							?>
						</select>
						<input id="postPerPage" type="hidden" value="<?php echo esc_attr($pps); ?>">
					</div>
					<!--select one-->
					<div class="nss-select-button">
						<input id="specfic_nonce_step" type="hidden" value="<?php echo esc_attr(wp_create_nonce('specfic_nonece_item')); ?>">
						<button id="loading_search_filter" type="submit"><?php _e('Search', 'nss-search-product'); ?></button>
					</div>
					<!--search button-->
				</form>
				<?php
			} elseif ($cat_step == 'three_step') {
				?>
				<form id="search_form_ajax" method="GET">
					<?php
						$parent_terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0));
					?>
					<div class="nss-select-option-1">
						<select name="select1" id="nss_select1">
							<option selected="selected"><?php echo esc_html($category_item); ?></option>
							<?php
							if(is_array($parent_terms) && $parent_terms !='')
							{
								foreach ($parent_terms as $term) 
								{
								?>
									<option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
								<?php
								}
							}
						?>
						</select>
					</div>
					<!--select one-->
					<div class="nss-select-option-2">
						<select name="select2" id="nss_select2"></select>
						<input id="nss_cat_item" type="hidden" value="<?php echo esc_attr($category_sub_item); ?>">
					</div>
					<!--select two-->
					<div class="nss-select-option-3">
						<select name="select3" id="nss_select3"></select>
						<input id="nss_cat_sub_item" type="hidden" value="<?php echo esc_attr($category_sub_sub_item); ?>">
					</div>
					<!--select three-->
					<div class="nss-select-button">
						<input id="nss_pps_id" type="hidden" value="<?php echo esc_attr($pps); ?>">
						<input id="three_nonce_field" type="hidden" value="<?php echo esc_attr(wp_create_nonce('threeStepNonceVal')); ?>">
						<button id="loading_search_filter" type="submit"><?php _e('Search', 'nss-search-product'); ?></button>
					</div>
					<!--search button-->
				</form>
				<?php
			} 
			elseif ($cat_step == 'two_step') 
			{
				?>
				<form id="search_two_step_form_ajax" method="GET">
					<?php
					$parent_terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0));
					?>
					<div class="nss-select-option-1">
						<select id="nss_two_step_select1">
							<option selected="selected"><?php echo esc_html($category_item); ?></option>
							<?php
							if (is_array($parent_terms) && $parent_terms != '') 
							{
								foreach ($parent_terms as $term) 
								{
								?>
									<option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
								<?php
								}
							}
							?>
						</select>
					</div>
					<!--select one-->
					<div class="nss-select-option-2">
						<select name="nss_two_step_select2" id="nss_two_step_select2"></select>
						<input type="hidden" id="nss_two_cat_name" value="<?php echo esc_attr($category_sub_item); ?>">
					</div>
					<!--select two-->
					<div class="nss-select-button">
						<input id="nss_two_pps_id" type="hidden" value="<?php echo esc_attr($pps); ?>">
						<input id="two_nonce_field" type="hidden" value="<?php echo esc_attr(wp_create_nonce('two_step_nonce')); ?>">	
						<button id="loading_search_filter" type="submit"><?php _e('Search', 'nss-search-product'); ?></button>
					</div>
					<!--search button-->
				</form>
				<?php
			} 
			else 
			{
				?>
				<form id="search_onestep_form_ajax" method="GET">
					<?php
					$parent_terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0));
					?>
					<div class="nss-select-option-1">
						<select id="nss_one_step_select1">
							<option disabled selected="selected"><?php echo esc_html($category_item); ?></option>
							<?php
							if(is_array($parent_terms) && $parent_terms != '')
							{
								foreach ($parent_terms as $term) 
								{
								?>
									<option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
								<?php
								}
							}
							?>
						</select>
					</div>
					<!--select one-->				
					<div class="nss-select-button">
						<input id="onePps" type="hidden" value="<?php echo esc_attr($pps); ?>">
						<input id="oneNonce" type="hidden" value="<?php echo esc_attr(wp_create_nonce('one_nonce_val')); ?>">
						<button id="loading_onestep_search_filter" type="submit"><?php _e('Search', 'nss-search-product'); ?></button>
					</div>
					<!--search button-->
				</form>
				<?php
			}
			?>
		</div>
		<!--form-->
		<div class="nssloading-zone">
			<div id="load_ajaxData"></div>
		</div>
		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type(new nss_search_ele_Widget());
