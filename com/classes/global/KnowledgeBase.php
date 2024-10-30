<?php
namespace ykb;

class KnowledgeBase {
	private $id;
	private $sanitizedData = array();
	private $savedData = array();
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setSavedData($savedData) {
		$this->savedData = $savedData;
	}
	
	public function getSavedData() {
		return $this->savedData;
	}
	
	public function getSanitizedData() {
		return $this->sanitizedData;
	}
	
	public function insertIntoSanitizedData($sanitizedData) {
		if (!empty($sanitizedData)) {
			$this->sanitizedData[$sanitizedData['name']] = $sanitizedData['value'];
		}
	}
	
	private function includeFrontMediaData() {
		$this->includeFrontCSS();
		$this->includeFrontJs();
	}
	
	public static function create($data = array()) {
		$obj = new static();
		$id = $data['ykb-post-id'];
		$obj->setId($id);
		// set up apply filter
		Config::optionsValues();
		
		foreach ($data as $name => $value) {
			$defaultData = $obj->getDefaultDataByName($name);
			if (empty($defaultData['type'])) {
				$defaultData['type'] = 'string';
			}
			$sanitizedValue = $obj->sanitizeValueByType($value, $defaultData['type']);
			$obj->insertIntoSanitizedData(array('name' => $name,'value' => $sanitizedValue));
		}
		
		$obj->save();
	}
	
	private function save() {
		$options = $this->getSanitizedData();
		update_option('ykb_save_config', $options);
	}
	
	public function sanitizeValueByType($value, $type) {
		switch ($type) {
			case 'string':
			case 'number':
				$sanitizedValue = sanitize_text_field($value);
				break;
			case 'html':
				$sanitizedValue = $value;
				break;
			case 'array':
				$sanitizedValue = $this->recursiveSanitizeTextField($value);
				break;
			case 'ypl':
				$sanitizedValue = $value;
				break;
			case 'email':
				$sanitizedValue = sanitize_email($value);
				break;
			case "checkbox":
				$sanitizedValue = sanitize_text_field($value);
				break;
			default:
				$sanitizedValue = sanitize_text_field($value);
				break;
		}
		
		return $sanitizedValue;
	}
	
	public function recursiveSanitizeTextField($array) {
		if (!is_array($array)) {
			return $array;
		}
		
		foreach ($array as $key => &$value) {
			if (is_array($value)) {
				$value = $this->recursiveSanitizeTextField($value);
			}
			else {
				/*get simple field type and do sensitization*/
				$defaultData = $this->getDefaultDataByName($key);
				if (empty($defaultData['type'])) {
					$defaultData['type'] = 'string';
				}
				$value = $this->sanitizeValueByType($value, $defaultData['type']);
			}
		}
		
		return $array;
	}
	
	public function getDefaultDataByName($optionName) {
		global $YKB_OPTIONS;
		
		if (empty($YKB_OPTIONS)) {
			return array();
		}
		
		foreach ($YKB_OPTIONS as $option) {
			if ($option['name'] == $optionName) {
				return $option;
			}
		}
		
		return array();
	}
	
	public static function parseYplDataFromData($data) {
		$cdData = array();
		
		if(empty($data)) {
			return $cdData;
		}
		
		foreach ($data as $key => $value) {
			if (strpos($key, 'ykb') === 0) {
				$cdData[$key] = $value;
			}
		}
		
		return $cdData;
	}
	
	public function getOptionValue($optionName, $forceDefaultValue = false) {
		
		$savedData = KnowledgeModel::getDataById(0);
		$this->setSavedData($savedData);

		return $this->getOptionValueFromSavedData($optionName, $forceDefaultValue);
	}
	
	public function getOptionValueFromSavedData($optionName, $forceDefaultValue = false) {
		
		$defaultData = $this->getDefaultDataByName($optionName);
		$savedData = $this->getSavedData();
		
		$optionValue = null;
		
		if (empty($defaultData['type'])) {
			$defaultData['type'] = 'string';
		}
		
		if (!empty($savedData)) { //edit mode
			if (isset($savedData[$optionName])) { //option exists in the database
				$optionValue = $savedData[$optionName];
			}
			/* if it's a checkbox, it may not exist in the db
			 * if we don't care about it's existence, return empty string
			 * otherwise, go for it's default value
			 */
			else if ($defaultData['type'] == 'checkbox' && !$forceDefaultValue) {
				$optionValue = '';
			}
		}
		
		if (($optionValue === null && !empty($defaultData['defaultValue'])) || ($defaultData['type'] == 'number' && !isset($optionValue))) {
			$optionValue = $defaultData['defaultValue'];
		}
		
		if ($defaultData['type'] == 'checkbox') {
			$optionValue = $this->boolToChecked($optionValue);
		}
		
		if(isset($defaultData['ver']) && $defaultData['ver'] > YKB_PKG_VERSION) {
			if (empty($defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
			else if (!in_array($optionValue, $defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
		}
		
		return $optionValue;
	}
	
	public function boolToChecked($var) {
		return ($var ? 'checked' : '');
	}
	
	public static function getPostSavedData($postId) {
		$savedData = get_option('ykb_save_config');
		
		if (empty($savedData)) {
			return array();
		}
		
		return $savedData;
	}
	
	public function includeFrontCSS() {
		wp_register_style('KnowledgeBase.css', YKB_FRONT_CSS_URL.'knowledgeBase.css');
		wp_enqueue_style('KnowledgeBase.css');
	}
	
	public function includeFrontJs() {
		wp_register_script('searchBar.js', YKB_FRONT_JS_URL.'searchBar.js');
		wp_localize_script('searchBar.js', 'YKB_ARGS', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('YKB_NONCE')
		));
		wp_enqueue_script('searchBar.js');
	}
	
	public function searchBar() {
		$this->includeFrontMediaData();
		ob_start();
		require_once YKB_FRONT_VIEWS_PATH.'searchBar.php';
		$contnet = ob_get_contents();
		ob_end_clean();
		
		return $contnet;
	}
}