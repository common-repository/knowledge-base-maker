<?php
namespace ykb;

Class Actions {
	public function __construct() {
		$this->init();
	}
	
	public function init() {
		add_action('init', array($this, 'postTypeInit'));
		add_shortcode('ykb_knowledge_base', array($this, 'shortcode'));
		add_action('admin_menu', array($this, 'addSubMenu'));
	}
	
	public function shortcode() {
		$knowledgeBase = new KnowledgeBase();
		
		return $knowledgeBase->searchBar();
	}
	
	public function postTypeInit() {
		$this->registerPostType = new PostType();
	}
	
	public function addSubMenu() {
		$this->registerPostType->submenuPage();
	}
}

new Actions();