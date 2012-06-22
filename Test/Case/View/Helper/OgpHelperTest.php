<?php
App::uses('View', 'View');
App::uses('OgpHelper', 'Ogp.View/Helper');

/**
 * OgpHelper Test Case
 *
 */
class OgpHelperTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->View = new View(null);
		$this->Ogp = new OgpHelper($this->View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ogp);

		parent::tearDown();
	}

	public function testSet() {
		$name = 'foo';
		$content = 'bar"&"baz';
		$expected = '<meta property="og:foo" content="bar&quot;&amp;&quot;baz" />';
		$this->Ogp->set($name, $content);
		$result = $this->View->fetch('meta');
		$this->assertSame($expected, $result);
	}

	public function testSetWitMeta() {
		$name = 'foo';
		$content = 'bar';
		$options = array('meta' => true);
		$expected = '<meta property="og:foo" content="bar" /><meta name="foo" content="bar" />';
		$this->Ogp->set($name, $content, $options);
		$result = $this->View->fetch('meta');
		$this->assertSame($expected, $result);
	}

	public function testSetWithStripTags() {
		$name = 'foo';
		$content = "bar\n <strong>b\taz</strong>";
		$expected = '<meta property="og:foo" content="bar baz" />';
		$this->Ogp->set($name, $content);
		$result = $this->View->fetch('meta');
		$this->assertSame($expected, $result);
	}

	public function testTitle() {
		$this->_setConfigure();
		$this->Ogp->title('page title');
		$_expected = 'page title - My Site';
		$expected = '<meta property="og:title" content="' . $_expected . '" /><meta property="og:site_name" content="My Site" />';
		$this->assertSame($expected, $this->View->fetch('meta'));
		$this->assertSame($_expected, $this->View->viewVars['title_for_layout']);
	}

	protected function _setConfigure() {
		Configure::write('Site.site_name', 'My Site');
		Configure::write('Site.type', 'website');
		Configure::write('Site.dummy', 'website');
		Configure::write('Site.separator', ' - ');
		Configure::write('Ogp.settings.base', 'Site.');
		Configure::write('Ogp.settings.autoKeys', array('type', 'dummy'));
	}

	public function testBeforeLayout() {
		$this->_setConfigure();
		$expected = '<meta property="og:dummy" content="dummy" /><meta property="og:type" content="website" />';
		$this->Ogp->set('dummy', 'dummy');
		$this->Ogp->beforeLayout();
		$this->assertSame($expected, $this->View->fetch('meta'));
	}

	public function testImage() {
		$url = '/img/test.png';
		$fullurl = Router::url($url, true);
		$expected = '<meta property="og:image" content="' . $fullurl . '" />';
	}

}
