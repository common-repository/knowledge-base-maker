<?php
namespace ykb\admin;
use ykb\ScriptsIncluder;

class Css {
	
	public function __construct() {
		$this->init();
	}
	
	public function init() {
		add_action('admin_enqueue_scripts', array($this, 'adminEenqueScripts'));
	}
	
	public function allowedPages() {
		$pages = array(
			YKB_POST_TYPE.'_page_'.YKB_CONFIG_PAGE
		);
		
		return $pages;
	}
	
	public function adminEenqueScripts($hook) {
		$currentPostType = Helper::getCurrentPostType();

		$pages = $this->allowedPages();
		if (empty($currentPostType) && !in_array($hook, $pages)) {
			return '';
		}

		if(!empty($currentPostType) && $currentPostType != YKB_POST_TYPE) {
			return '';
		}

		ScriptsIncluder::loadStyle('YkbBootstrap.css');
		ScriptsIncluder::loadStyle('YkbCSS.css');
	}
}

new Css();