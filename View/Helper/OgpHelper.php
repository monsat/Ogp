<?php
App::uses('AppHelper', 'View/Helper');

class OgpHelper extends AppHelper {

	public $helpers = array('Html', 'Form', 'Text');
	public $actual = array();

	public function beforeLayout() {
		$keys = Configure::read('Ogp.settings.autoKeys');
		if (is_array($keys)) {
			foreach ($keys as $name) {
				if (!in_array($name, $this->actual)) {
					$this->set($name);
				}
			}
		}
	}

	public function set($name, $content = '', $options = array()) {
		$options += array(
			'meta' => false,
			'stripTags' => true,
			'url' => true,
		);
		if (empty($content)) {
			if($name == 'url' && $options['url']) {
				$content = Router::url("", true);
			} else {
				$content = $this->_configure($name);
			}
		}
		if (!empty($options['stripTags'])) {
			$content = strip_tags($content);
			$content = str_replace(array("\t", "\r", "\n"), '', $content);
		}
		$prefix = 'og:';
		$property = $prefix . $name;
		$this->_View->append('meta', $this->Html->meta(compact('property', 'content')));
		$this->actual[] = $name;
		if (!empty($options['meta'])) {
			$this->_View->append('meta', $this->Html->meta(compact('name', 'content')));
		}
	}

	public function title($title = '', $options = array()) {
		$options += array(
			'site_name' => true,
			'title_for_layout' => true, 
		);
		$site_name = $this->_configure('site_name');
		if (empty($title)) {
			$title = $site_name;
		} else {
			$title .= $this->_configure('separator') . $site_name;
		}
		$this->set('title', $title);
		if (!empty($options['site_name'])) {
			$this->set('site_name', $site_name);
		}
		if (!empty($options['title_for_layout'])) {
			$this->_View->set('title_for_layout', $title);
		}
	}

	public function image($url, $options = array()) {
		$this->set('image', Router::url($url, true));
	}

	public function _configure($key) {
		$base = Configure::read('Ogp.settings.base');
		return Configure::read($base . $key);
	}

}
