<?php
namespace ykb;

class KnowledgeModel {
	private static $data = array();
	
	private function __construct() {
	}
	
	public static function getDataById($postId) {
		if (!isset(self::$data[$postId])) {
			self::$data[$postId] = KnowledgeBase::getPostSavedData($postId);
		}
		
		return self::$data[$postId];
	}
}
