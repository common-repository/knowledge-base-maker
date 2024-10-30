<?php
namespace ykb;

class Config {
	public static function addDefine($name, $value) {
		if(!defined($name)) {
			define($name, $value);
		}
	}
	
	public static function init() {
		self::addDefine('YKB_URL', plugins_url().'/'.YKB_FOLDER_NAME.'/');
		self::addDefine('YKB_POST_TYPE', 'ykbpost');
		self::addDefine('YKB_CATEGORY_TAXONOMY', 'ykb-knowledge-category');
		self::addDefine('YKB_ADMIN_URL', admin_url());
		self::addDefine('YKB_TEXT_DOMAIN', 'ykbKnowledge');
		self::addDefine('YKB_WP_ADMIN_POST_URL', admin_url('admin-post.php'));
		self::addDefine('YKB_PUBLIC_URL', YKB_URL.'public/');
		self::addDefine('YKB_CSS_URL', YKB_PUBLIC_URL.'css/');
		self::addDefine('YKB_ADMIN_CSS_URL', YKB_CSS_URL.'admin/');
		self::addDefine('YKB_FRONT_CSS_URL', YKB_CSS_URL.'front/');
		self::addDefine('YKB_JS_URL', YKB_PUBLIC_URL.'js/');
		self::addDefine('YKB_ADMIN_JS_URL', YKB_JS_URL.'admin/');
		self::addDefine('YKB_FRONT_JS_URL', YKB_JS_URL.'front/');
		self::addDefine('YKB_PATH', WP_PLUGIN_DIR.'/'.YKB_FOLDER_NAME.'/');
		
		self::addDefine('YKB_LAST_UPDATE', 'Jan 4');
		self::addDefine('YKB_NEXT_UPDATE', 'Jan 28');
		self::addDefine('YKB_VERSION_TEXT', '1.1.8');
		self::addDefine('YKB_VERSION', 1.18);
		self::addDefine('YKB_PKG_VERSION', '1');
		
		self::addDefine('YKB_COM_PATH', YKB_PATH.'com/');
		self::addDefine('YKB_PUBLIC_PATH', YKB_PATH.'public/');
		self::addDefine('YKB_VIEWS_PATH', YKB_PUBLIC_PATH.'views/');
		
		self::addDefine('YKB_COM_PATH', YKB_PATH.'com/');
		self::addDefine('YKB_PUBLIC_PATH', YKB_PATH.'public/');
		self::addDefine('YKB_VIEWS_PATH', YKB_PUBLIC_PATH.'views/');
		self::addDefine('YKB_ADMIN_VIEWS_PATH', YKB_VIEWS_PATH.'admin/');
		self::addDefine('YKB_FRONT_VIEWS_PATH', YKB_VIEWS_PATH.'front/');
		self::addDefine('YKB_PAGES_VIEWS_PATH', YKB_VIEWS_PATH.'pages/');
		self::addDefine('YKB_CLASS_PATH', YKB_COM_PATH.'classes/');
		self::addDefine('YKB_ADMIN_CLASS_PATH', YKB_CLASS_PATH.'admin/');
		self::addDefine('YKB_FRONT_CLASS_PATH', YKB_CLASS_PATH.'front/');
		self::addDefine('YKB_GLOBAL_CLASS_PATH', YKB_CLASS_PATH.'global/');
		self::addDefine('YKB_ADMIN_CLASS_PATH', YKB_CLASS_PATH.'admin/');
		self::addDefine('YKB_SUPPORT_URL', 'https://wordpress.org/support/plugin/knowledge-base-maker/');
		
		self::addDefine('YKB_MENU_TITLE', 'Knowledge Base');
		
		self::addDefine('YKB_TEXT_DOMAIN', 'ykbKnowledge');
		self::addDefine('YKB_SUPPORT_PAGE', 'ykbsupportpage');
		self::addDefine('YKB_IDEAS_PAGE', 'ykbIdeasPage');
		self::addDefine('YKB_CONFIG_PAGE', 'ykbConfigPage');
	}
	
	public static function optionsValues() {
		global $YKB_OPTIONS;
		$options = array();
		$options[] = array('name' => 'ykb-search-header', 'type' => 'array', 'defaultValue' => 'Search Knowledge Base by Keyword');
		$options[] = array('name' => 'ykb-search-button-label', 'type' => 'array', 'defaultValue' => 'SEARCH');
		$options[] = array('name' => 'ykb-search-button-progress-label', 'type' => 'array', 'defaultValue' => 'SEARCH...');
		$options[] = array('name' => 'ykb-search-input-placeholder', 'type' => 'text', 'defaultValue' => '');
		$options[] = array('name' => 'ykb-search-notfound-title', 'type' => 'text', 'defaultValue' => 'No data');
		$options[] = array('name' => 'ykb-search-for-text', 'type' => 'text', 'defaultValue' => 'Search Results for');
		
		$YKB_OPTIONS = apply_filters('ykbDefaultOptions', $options);
		
		return $YKB_OPTIONS;
	}
}

Config::init();