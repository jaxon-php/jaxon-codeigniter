Jaxon Library for CodeIgniter
=============================

This package integrates the [Jaxon library](https://github.com/jaxon-php/jaxon-core) into the CodeIgniter 3 framework.

Features
--------

- Read Jaxon options from a file in CodeIgniter config format.
- Automatically register Jaxon classes from a preset directory.

Installation
------------

First install CodeIgniter version 3.

Create the `composer.json` file into the installation dir with the following content.

```json
{
    "require": {
        "jaxon-php/jaxon-codeigniter": "~2.0",
    }
}
```

Copy the content of the `app/` directory of this repo to the `application/` dir of the CodeIgniter application.
This will install the Jaxon library for CodeIgniter, as well as the controller to process Jaxon requests and a default config file.

The version 3 of the CodeIgniter framework does not natively support Composer.
The Composer `vendor/autoload.php` file must therefore be manually included in the application.

Configuration
------------

The settings in the jaxon.php config file are separated into two sections.
The options in the `lib` section are those of the Jaxon core library, while the options in the `app` sections are those of the CodeIgniter application.

The following options can be defined in the `app` section of the config file.

| Name | Default value | Description |
|------|---------------|-------------|
| controllers.directory | APPPATH . 'jaxon/controllers' | The directory of the Jaxon classes |
| controllers.namespace | \Jaxon\App  | The namespace of the Jaxon classes |
| controllers.separator | .           | The separator in Jaxon class names |
| controllers.protected | empty array | Prevent Jaxon from exporting some methods |
| | | |

Usage
-----

This is an example of a CodeIgniter controller using the Jaxon library.
```php

class Demo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the Jaxon library
        $this->load->library('jaxon');
    }

    public function index()
    {
        // Register the Jaxon classes
        $this->jaxon->register();

        // Print the page
        $this->load->view('index', array(
            'JaxonCss' => $this->jaxon->css(),
            'JaxonJs' => $this->jaxon->js(),
            'JaxonScript' => $this->jaxon->script()
        ));
    }
}
```

The controller must inherit from the `Jaxon_Controller` provided in this package, and call its contructor.

Before it prints the page, the controller makes a call to `$this->jaxon->register()` to export the Jaxon classes.
Then it calls the `$this->jaxon->css()`, `$this->jaxon->js()` and `$this->jaxon->script()` functions to get the CSS and javascript codes generated by Jaxon, which it inserts in the page.

### The Jaxon classes

The Jaxon classes must inherit from `\Jaxon\Module\Controller`.

The Jaxon classes of the application must all be located in the directory indicated by the `app.controllers.directory` option in the `jaxon.php` config file.
If there is a namespace associated, the `app.controllers.namespace` option should be set accordingly.

By default, the Jaxon classes are located in the `APPPATH/jaxon/controllers` dir of the CodeIgniter application, and the associated namespace is `\Jaxon\App`.

This is a simple example of a Jaxon class, defined in the `APPPATH/jaxon/controllers/HelloWorld.php` file.

```php
namespace Jaxon\App;

class HelloWorld extends \Jaxon\Module\Controller
{
    public function sayHello()
    {
        $this->response->assign('div2', 'innerHTML', 'Hello World!');
        return $this->response;
    }
}
```

Check the [jaxon-examples](https://github.com/jaxon-php/jaxon-examples/tree/master/frameworks/codeigniter) package for more examples.

Contribute
----------

- Issue Tracker: github.com/jaxon-php/jaxon-codeigniter/issues
- Source Code: github.com/jaxon-php/jaxon-codeigniter

License
-------

The package is licensed under the BSD license.
