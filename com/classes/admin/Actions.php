<?php
namespace ykb\admin;
use ykb\KnowledgeBase;

Class Actions {
	public function __construct() {
		$this->init();
	}
	
	public function init() {
		add_action('admin_head', array($this, 'adminHead'));
		add_action('add_meta_boxes', array($this, 'metaboxes'));
		add_action('manage_'.YKB_POST_TYPE.'_posts_custom_column' , array($this, 'tableColumnValues'), 10, 2);
		add_action('admin_post_ykb_save_configuration', array($this, 'saveConfiguration'));
		add_action('admin_action_ykb_duplicate_post_as_draft', array($this, 'duplicatePostSave'));
	}
	
	public function duplicatePostSave() {
		
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}
		/*
		 * Nonce verification
		 */
		if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], YKB_POST_TYPE))
			return;
		
		/*
		 * get the original post id
		 */
		$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		/*
		 * and all the original post data then
		 */
		$post = get_post( $post_id );
		
		/*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
		
		/*
		 * if post data exists, create the post duplicate
		 */
		if (isset( $post ) && $post != null) {
			
			/*
			 * new post data array
			 */
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'publish',
				'post_title'     => $post->post_title.'(clone)',
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
			
			/*
			 * insert the post by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );
			
			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
			
			/*
			 * duplicate all post meta just in two SQL queries
			 */
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
			
			
			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			wp_redirect(admin_url('edit.php?post_type=' . YKB_POST_TYPE));
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}
	
	public function saveConfiguration() {
		$safePost = filter_input_array(INPUT_POST);
		if (!empty($safePost)) {
			$saveConfig = array();
			$postData = KnowledgeBase::parseYplDataFromData($safePost);
			$postData = apply_filters('ykbSavedData', $postData);
			KnowledgeBase::create($postData);
		}
		wp_redirect(admin_url().'admin.php?page='.YKB_CONFIG_PAGE.'&saved=1');
	}
	
	public function tableColumnValues($column, $postId) {
		if ($column == 'shortcode') {
			echo '<input type="text" onfocus="this.select();" readonly="" value="[ykb_knowledge_base]" class="large-text code">';
		}
	}
	
	public function metaboxes() {
		add_meta_box('ykbSupport', __('Support', YKB_TEXT_DOMAIN), array($this, 'support'), YKB_POST_TYPE, 'side');
		add_meta_box('ykbShortcode', __('Shortcode', YKB_TEXT_DOMAIN), array($this, 'shortcode'), YKB_POST_TYPE, 'side');
	}
	
	public function adminHead() {
		echo "<script>jQuery(document).ready(function() {var supportPageMenuLink = jQuery('a[href*=\"".YKB_SUPPORT_PAGE."\"]'); supportPageMenuLink.css({color: 'yellow'});supportPageMenuLink.bind('click', function(e) {e.preventDefault(); window.open('".YKB_SUPPORT_URL."')}) });</script>";
		echo "<script>jQuery(document).ready(function() {var idemsMenuLink = jQuery('a[href*=\"".YKB_IDEAS_PAGE."\"]'); idemsMenuLink.css({color: 'rgb(85, 239, 195)'});idemsMenuLink.bind('click', function(e) {e.preventDefault(); window.open('".YKB_SUPPORT_URL."')}) });</script>";
	}
	
	public function support() {
		require_once(YKB_ADMIN_VIEWS_PATH.'supportMetabox.php');
	}
	
	public function shortcode() {
		require_once(YKB_ADMIN_VIEWS_PATH.'shortcodeMetabox.php');
	}
}

new Actions();