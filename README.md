Jaxon integration for CodeIgniter 4
===================================

This package integrates the [Jaxon library](https://github.com/jaxon-php/jaxon-core) into the CodeIgniter 4 framework.

Installation
------------

The version 4 of the package requires CodeIgniter version 4.

Install the package with `Composer`.

```bash
composer require jaxon-php/jaxon-codeigniter ^4.0
```
Or
```json
{
    "require": {
        "jaxon-php/jaxon-codeigniter": "^4.0",
    }
}
```
And run `composer install`.

Filter
------

This package provides a filter that must be attached to the routes to all the pages where the Jaxon features are enabled.

In the `app/Config/Routes.php` file, a route must be defined for Jaxon requests.

```php
// Add the Jaxon filter to Jaxon-enabled routes.
$routes->get('/', 'Demo::index', ['filter' => JaxonConfigFilter::class]);

// Jaxon request processing route.
$routes->post('/jaxon', 'Demo::jaxon', ['filter' => JaxonConfigFilter::class]);
```

This is an example of a CodeIgniter controller using the Jaxon library.

```php
namespace App\Controllers;

use Jaxon\Demo\Ajax\Bts;
use Jaxon\Demo\Ajax\Pgw;

use function view;

class Demo extends BaseController
{
    public function index()
    {
        $jaxon = jaxon()->app();

        // Print the page
        return view('demo/index', [
            'jaxonCss' => $jaxon->css(),
            'jaxonJs' => $jaxon->js(),
            'jaxonScript' => $jaxon->script(),
            'pageTitle' => "CodeIgniter Framework",
            // Jaxon request to the Bts Jaxon class
            'bts' => $jaxon->request(Bts::class),
            // Jaxon request to the Pgw Jaxon class
            'pgw' => $jaxon->request(Pgw::class),
        ]);
    }

    public function jaxon()
    {
        $jaxon = jaxon()->app();
        if(!$jaxon->canProcessRequest())
        {
            // Jaxon failed to find a plugin to process the request
            return; // Todo: return an error message
        }

        $jaxon->processRequest();
        return $jaxon->httpResponse();
    }
}
```

Configuration
------------

Copy the `config/Jaxon.php` file in this package to the `app/Config` dir of the CodeIgniter app.

The settings in the `config/Jaxon.php` config file are separated into two sections.
The options in the `lib` section are those of the Jaxon core library, while the options in the `app` sections are those of the CodeIgniter application.

The following options can be defined in the `app` section of the config file.

| Name | Description |
|------|---------------|
| directories | An array of directory containing Jaxon application classes |
| views   | An array of directory containing Jaxon application views |
| | | |

By default, the `views` array is empty. Views are rendered from the framework default location.
There's a single entry in the `directories` array with the following values.

| Name | Default value | Description |
|------|---------------|-------------|
| directory | 'jaxon/ajax' | The directory of the Jaxon classes |
| namespace | \Jaxon\Ajax  | The namespace of the Jaxon classes |
| separator | .           | The separator in Jaxon class names |
| protected | empty array | Prevent Jaxon from exporting some methods |
| | | |

Usage
-----

### The Jaxon classes

The Jaxon classes can inherit from `\Jaxon\App\CallableClass`.
By default, they are located in the `jaxon/app` dir of the CodeIgniter application, and the associated namespace is `\Jaxon\Ajax`.

This is a simple example of a Jaxon class, defined in the `jaxon/ajax/HelloWorld.php` file.

```php
namespace Jaxon\Ajax;

class HelloWorld extends \Jaxon\App\CallableClass
{
    public function sayHello()
    {
        $this->response->assign('div2', 'innerHTML', 'Hello World!');
        return $this->response;
    }
}
```

Contribute
----------

- Issue Tracker: github.com/jaxon-php/jaxon-codeigniter/issues
- Source Code: github.com/jaxon-php/jaxon-codeigniter

License
-------

The package is licensed under the BSD license.
