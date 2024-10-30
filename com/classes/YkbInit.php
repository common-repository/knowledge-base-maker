<?php
class YkbInit {

	public function __construct() {

		$this->init();
	}

	public function init() {
	    $this->includeData();
	    $this->hooks();
	}
	
	public function hooks() {
		register_deactivation_hook(YKB_FILE_NAME, array($this, 'deactivate'));
		add_action('admin_init', array($this, 'pluginRedirect'));
	}
	
	private function includeData() {
	    require_once YKB_ADMIN_CLASS_PATH.'PostType.php';
	    require_once YKB_GLOBAL_CLASS_PATH.'Ajax.php';
	    require_once YKB_GLOBAL_CLASS_PATH.'ScriptsIncluder.php';
	    require_once YKB_GLOBAL_CLASS_PATH.'KnowledgeModel.php';
	    require_once YKB_GLOBAL_CLASS_PATH.'KnowledgeBase.php';
	    require_once YKB_GLOBAL_CLASS_PATH.'Actions.php';
	    require_once YKB_ADMIN_CLASS_PATH.'Actions.php';
	    require_once YKB_ADMIN_CLASS_PATH.'Filters.php';
	    require_once YKB_ADMIN_CLASS_PATH.'Helper.php';
	    require_once YKB_ADMIN_CLASS_PATH.'CSS.php';
    }
	
	public function pluginRedirect() {
		if (!get_option('ykb_redirect')) {
			update_option('ykb_redirect', 1);
			exit(wp_redirect(admin_url('edit.php?post_type='.YKB_POST_TYPE)));
		}
	}
	
	public function deactivate() {
		delete_option('ykb_redirect');
	}
}