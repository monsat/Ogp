Ogp
===

CakePHP OGP Plugin

USAGE
-----

```php
# view
$this->Ogp->title('page title');
$this->Ogp->image($post['Post']['author_image_url']);
// the other property
$this->Ogp->set('description', "description is stripped \n and <b>tags</b>");

# layout
$this->fetch('meta');
```

INSTALL
-------

### Download this code

download this code. and put them your plugin directory.

```sh
cd your_app
ls Plugin

Ogp
```

or clone / submodule add

```sh
cd your_app
git clone git://github.com/monsat/Ogp.git Plugin/Ogp
```

### Load plugin
```php
# APP/Config/bootstrap.php
CakePlugin::load('Ogp');
```

```php
# APP/Controller/AppController.php
$helpers = array( 'Html', 'Form', 'Ogp.Ogp');
```

### Default settings

If you do not set values in views , default values are used.

```php
# APP/Config/bootstrap.php
Configure::write('Site', array(
  'site_name' => 'My Site',
  'description' => 'My Site is awesome',
  'image' => '/img/image.png',
  'type' => 'website',
  'separator' => ' - ',
));
```

### Settings

default settings

```php
Configure::write('Ogp.settings', array(
  'base' => 'Site.',
  'autoKeys' => array('type'), // set by beforeLayout
));
```