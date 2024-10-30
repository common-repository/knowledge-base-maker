<?php
namespace ykb\admin;

class Helper {
	public static function getCurrentPostType() {
		global $post_type;
		global $post;
		$currentPostType = '';
		
		if (is_object($post)) {
			$currentPostType = @$post->post_type;
		}
		
		// in some themes global $post returns null
		if (empty($currentPostType)) {
			$currentPostType = $post_type;
		}
		
		if (empty($currentPostType) && !empty($_GET['post'])) {
			$currentPostType = get_post_type($_GET['post']);
		}
		
		return $currentPostType;
	}
}