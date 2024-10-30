<?php
namespace ykb;

class Ajax {
	public function __construct() {
		$this->actions();
	}
	
	private function actions() {
		add_action('wp_ajax_ykb_search_data', array($this, 'search'));
		add_action('wp_ajax_ykb_search_data', array($this, 'search'));
	}
	
	public function search() {
		check_ajax_referer('YKB_NONCE', 'nonce');
		require_once YKB_FRONT_CLASS_PATH.'KnowledgeBaseSearch.php';
		echo KnowledgeBaseSearch::search($_POST['value']);
		wp_die();
	}
}

new Ajax();