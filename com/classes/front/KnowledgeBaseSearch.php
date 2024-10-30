<?php
namespace ykb;
use \WP_Query;

class KnowledgeBaseSearch extends KnowledgeBase{
	private $title;
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public static function search($text) {
		
		$obj = new self();
		if (empty($text)) {
			return $obj->emptyData();
		}
		$obj->setTitle($text);
		$posts = $obj->searchPostByText($text);
		
		return $obj->renderSearchPreviewPosts($posts);
	}
	
	private function renderSearchPreviewPosts($posts) {
		if (empty($posts)) {
			return $this->emptyData();
		}
		$searchForText = $this->getOptionValue('ykb-search-for-text');
		$title = $this->getTitle();
		$str = '<h3>'.$searchForText.' '.$title.'</h3>';
		$str .= '<ul class="ykb-search-ul">';
		
		foreach ($posts as $post) {
			$postId = $post->ID;
			$postTitle = $post->post_title;
			$link = get_permalink($postId);
			$str .= '<li><a href="'.esc_attr($link).'">'.esc_attr($postTitle).'</a></li>';
		}
		$str .= '</ul>';
		return $str;
	}
	
	private function emptyData() {
		return $this->getOptionValue('ykb-search-notfound-title');
	}
	
	private function searchPostByText($text) {
		$args      = array(
			's'              => $text,
			'posts_per_page' => 100,
			'post_type'      => YKB_POST_TYPE
		);
		$query = new WP_Query($args);
		if (empty($query)) {
			return array();
		}
		
		return $query->posts;
	}
}