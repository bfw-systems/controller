bfw-controller
=
Module Controller pour BFW

[![Build Status](https://travis-ci.org/bulton-fr/bfw-controller.svg?branch=3.0)](https://travis-ci.org/bulton-fr/bfw-controller) [![Coverage Status](https://coveralls.io/repos/bulton-fr/bfw-controller/badge.png?branch=3.0)](https://coveralls.io/r/bulton-fr/bfw-controller?branch=3.0) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bulton-fr/bfw-controller/badges/quality-score.png?b=3.0)](https://scrutinizer-ci.com/g/bulton-fr/bfw-controller/?branch=3.0) [![Latest Stable Version](https://poser.pugx.org/bulton-fr/bfw-controller/v/stable.svg)](https://packagist.org/packages/bulton-fr/bfw-controller) [![License](https://poser.pugx.org/bulton-fr/bfw-controller/license.svg)](https://packagist.org/packages/bulton-fr/bfw-controller)

---

__Install :__

You can use composer to get the module : `composer require bulton-fr/bfw-controller @stable`

And to install the module : `./vendor/bin/bfwInstallModules`

__Config :__

All config file for this module will be into `app/config/bfw-controller/`. There are one file to configure (manifest.json is for the module update system).

The file config.php
* `useClass` : Define if all controller will be classes (`true`) or procedural file (`false`).

__Use it :__

Create your controller files into the directory `/src/controllers`.

For an object controller, you can extends from the class `\BfwController\Controller`. This class adding properties `$app` and `$request` who are a direct access to the instance of the classes `\BFW\Application` and `\BFW\Request`. You can use the namespace `\Controller`, it's added by the framework and corresponding to the directory `/src/controllers`.

For a procedural controller, the file will be included into a closure who is into the method `\BfwController\BfwController::runProcedural()`. So you will have a direct access to `$this` of the class, and you will have variables `$routerLinker` and `$controllerFile` into the scope.

__Example :__

Extract from the [BFW wiki](https://bfw.bulton.fr/wiki/v3.0/fr/scripts-d-exemple#web), an exemple with an object controller.

```php
<?php

namespace Controller;

class Test extends \BfwController\Controller
{
    public function index()
    {
        var_dump($this->request->getRequest());
    }
}
```

__Router module :__

This module not manage the application routing. You need to add a router module too.

The route module have a config file to define each route. For each route, you should define a "target". With bfw-controller, the "target" value should have a specified format :
* For an object controller : An array, the first value should be the class name (with namespace), the second value the method name. Like a callable array.
* For a procedural controller : The filename with this extension. The path to the directory /src/controller should be omitted.
