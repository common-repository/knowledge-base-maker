<?php
namespace YKB;

class PostType {
	public function __construct() {
		$this->register();
	}
	
	public function register() {
		$postType = YKB_POST_TYPE;
		
		$args = $this->getPostTypeArgs();
		
		register_post_type($postType, $args);
		$this->registerTaxonomy();
		Config::optionsValues();
	}
	
	public function getPostTypeArgs()
	{
		$labels = $this->getPostTypeLabels();
		
		$args = array(
			'labels'             => $labels,
			'description'        => __('Description.', YKB_TEXT_DOMAIN),
			//Exclude_from_search
			'public'             => true,
			'has_archive'        => true,
			//Where to show the post type in the admin menu
			'show_ui'            => true,
			'query_var'          => false,
			// post preview button
			'publicly_queryable' => true,
			'map_meta_cap'       => true,
			'menu_position'      => 10,
			'menu_icon'          => 'dashicons-welcome-learn-more'
		);
		
		return $args;
	}
	
	public function getPostTypeLabels()
	{
		$labels = array(
			'name'               => _x(YKB_MENU_TITLE, 'post type general name', YKB_TEXT_DOMAIN),
			'singular_name'      => _x(YKB_MENU_TITLE, 'post type singular name', YKB_TEXT_DOMAIN),
			'menu_name'          => _x(YKB_MENU_TITLE, 'admin menu', YKB_TEXT_DOMAIN),
			'name_admin_bar'     => _x('Countdown', 'add new on admin bar', YKB_TEXT_DOMAIN),
			'add_new'            => _x('Add New', 'Knowledge base', YKB_TEXT_DOMAIN),
			'add_new_item'       => __('Add New Knowledge base', YKB_TEXT_DOMAIN),
			'new_item'           => __('New Knowledge base', YKB_TEXT_DOMAIN),
			'edit_item'          => __('Edit Knowledge base', YKB_TEXT_DOMAIN),
			'view_item'          => __('View Knowledge base', YKB_TEXT_DOMAIN),
			'all_items'          => __('All '.YKB_MENU_TITLE, YKB_TEXT_DOMAIN),
			'search_items'       => __('Search '.YKB_MENU_TITLE, YKB_TEXT_DOMAIN),
			'parent_item_colon'  => __('Parent '.YKB_MENU_TITLE.':', YKB_TEXT_DOMAIN),
			'not_found'          => __('No '.YKB_MENU_TITLE.' found.', YKB_TEXT_DOMAIN),
			'not_found_in_trash' => __('No '.YKB_MENU_TITLE.' found in Trash.', YKB_TEXT_DOMAIN)
		);
		
		return $labels;
	}
	
	public function registerTaxonomy() {
		$labels = array(
			'name'                       => _x('Categories', 'taxonomy general name', YKB_TEXT_DOMAIN),
			'singular_name'              => _x('Categories', 'taxonomy singular name', YKB_TEXT_DOMAIN),
			'search_items'               => __('Search Categories', YKB_TEXT_DOMAIN),
			'popular_items'              => __('Popular Categories', YKB_TEXT_DOMAIN),
			'all_items'                  => __('All Categories', YKB_TEXT_DOMAIN),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __('Edit Category', YKB_TEXT_DOMAIN),
			'update_item'                => __('Update Category', YKB_TEXT_DOMAIN),
			'add_new_item'               => __('Add New Category', YKB_TEXT_DOMAIN),
			'new_item_name'              => __('New Category Name', YKB_TEXT_DOMAIN),
			'separate_items_with_commas' => __('Separate Categories with commas', YKB_TEXT_DOMAIN),
			'add_or_remove_items'        => __('Add or remove Categories', YKB_TEXT_DOMAIN),
			'choose_from_most_used'      => __('Choose from the most used Categories', YKB_TEXT_DOMAIN),
			'not_found'                  => __('No Categories found.', YKB_TEXT_DOMAIN),
			'menu_name'                  => __('Categories', YKB_TEXT_DOMAIN),
		);
		
		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'sort'                  => 12,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'capabilities' => array(
			)
		);
		
		register_taxonomy(YKB_CATEGORY_TAXONOMY, YKB_POST_TYPE, $args);
		register_taxonomy_for_object_type(YKB_CATEGORY_TAXONOMY, YKB_POST_TYPE);
	}
	
	public function submenuPage() {
		add_submenu_page(
			'edit.php?post_type='.YKB_POST_TYPE,
			__('Support', YKB_TEXT_DOMAIN),
			__('Support', YKB_TEXT_DOMAIN),
			'read',
			YKB_SUPPORT_PAGE,
			array($this, 'hiddenPageMethod')
		);
		add_submenu_page(
			'edit.php?post_type='.YKB_POST_TYPE,
			__('More Ideas?', YKB_TEXT_DOMAIN),
			__('More Ideas?', YKB_TEXT_DOMAIN),
			'read',
			YKB_IDEAS_PAGE,
			array($this, 'hiddenPageMethod')
		);
		add_submenu_page(
			'edit.php?post_type='.YKB_POST_TYPE,
			__('Configuration', YKB_TEXT_DOMAIN),
			__('Configuration', YKB_TEXT_DOMAIN),
			'read',
			YKB_CONFIG_PAGE,
			array($this, 'configuration')
		);
	}
	
	public function hiddenPageMethod() {
		
	}
	
	public function configuration() {
		$typeObj = new KnowledgeBase();
		require_once YKB_ADMIN_VIEWS_PATH.'configuration.php';
	}
}