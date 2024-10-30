<?php
namespace ykb;

class ScriptsIncluder {
	/**
	 * Countdown register style
	 *
	 * @since 1.0.9
	 *
	 * @param string $fileName file address
	 * @param array $args wordpress register  style args dep|ver|media|dirUrl
	 *
	 * @return void
	 */
	public static function registerStyle($fileName, $args = array()) {
		if(empty($fileName)) {
			return;
		}
		
		$dep = array();
		$ver = YKB_VERSION;
		$media = 'all';
		$dirUrl = YKB_ADMIN_CSS_URL;
		
		if(!empty($args['dep'])) {
			$dep = $args['dep'];
		}
		
		if(!empty($args['ver'])) {
			$ver = $args['ver'];
		}
		
		if(!empty($args['media'])) {
			$media = $args['media'];
		}
		
		if(!empty($args['dirUrl'])) {
			$dirUrl = $args['dirUrl'];
		}
		
		wp_register_style($fileName, $dirUrl.''.$fileName, $dep, $ver, $media);
	}
	
	/**
	 * Countdown register style
	 *
	 * @since 1.0.0
	 *
	 * @param string $fileName file address
	 *
	 * @return void
	 */
	public static function enqueueStyle($fileName) {
		if(empty($fileName)) {
			return;
		}
		
		wp_enqueue_style($fileName);
	}
	
	
	public static function loadStyle($fileName, $args = array()) {

		self::registerStyle($fileName, $args);
		self::enqueueStyle($fileName);
	}
	
	/**
	 * Countdown register style
	 *
	 * @since 1.0.9
	 *
	 * @param string $fileName file address
	 * @param array $args wordpress register  script args dep|ver|inFooter|dirUrl
	 *
	 * @return void
	 */
	public static function registerScript($fileName, $args = array()) {
		if(empty($fileName)) {
			return;
		}
		
		$dep = array();
		$ver = YKB_VERSION;
		$inFooter = false;
		$dirUrl = YKB_ADMIN_JS_URL;
		
		if(!empty($args['dep'])) {
			$dep = $args['dep'];
		}
		
		if(!empty($args['ver'])) {
			$ver = $args['ver'];
		}
		
		if(!empty($args['inFooter'])) {
			$inFooter = $args['inFooter'];
		}
		
		if(!empty($args['dirUrl'])) {
			$dirUrl = $args['dirUrl'];
		}
		
		wp_register_script($fileName, $dirUrl.''.$fileName, $dep, $ver, $inFooter);
	}
	
	/**
	 * Countdown register style
	 *
	 * @since 1.0.9
	 *
	 * @param string $fileName file address
	 *
	 * @return void
	 */
	public static function enqueueScript($fileName) {
		if(empty($fileName)) {
			return;
		}
		
		wp_enqueue_script($fileName);
	}
	
	public static function localizeScript($handle, $name, $data) {
		wp_localize_script($handle, $name, $data);
	}
	
	public static function loadScript($scriptName, $args = array()) {
		self::registerScript($scriptName, $args);
		self::enqueueScript($scriptName);
	}
}