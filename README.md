bfw-controller
=
Module Controller pour BFW

[![Build Status](https://travis-ci.org/bulton-fr/bfw-controller.svg?branch=1.0)](https://travis-ci.org/bulton-fr/bfw-controller) [![Coverage Status](https://coveralls.io/repos/bulton-fr/bfw-controller/badge.png?branch=1.0)](https://coveralls.io/r/bulton-fr/bfw-controller?branch=1.0) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bulton-fr/bfw-controller/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/bulton-fr/bfw-controller/?branch=1.0) [![Dependency Status](https://www.versioneye.com/user/projects/54273dcd82006713d0000016/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54273dcd82006713d0000016)

[![Latest Stable Version](https://poser.pugx.org/bulton-fr/bfw-controller/v/stable.svg)](https://packagist.org/packages/bulton-fr/bfw-controller) [![Latest Unstable Version](https://poser.pugx.org/bulton-fr/bfw-controller/v/unstable.svg)](https://packagist.org/packages/bulton-fr/bfw-controller) [![License](https://poser.pugx.org/bulton-fr/bfw-controller/license.svg)](https://packagist.org/packages/bulton-fr/bfw-controller)



---

__Installation :__

Il est recommandé d'utiliser composer pour installer le framework :

Pour récupérer composer:
```
curl -sS https://getcomposer.org/installer | php
```

Pour installer le framework, créez un fichier "composer.json" à la racine de votre projet, et ajoutez-y ceci:
```
{
    "require": {
        "bulton-fr/bfw-controller": "@stable"
    }
}
```

Enfin, pour lancer l'installation, 2 étapes sont nécessaires :

Récupérer le module via composer :
```
php composer.phar install
```
Via un utilitaire du framework BFW, créer un lien vers le module dans le dossier module du projet :
```
./vendor/bin/bfw_loadModules
```
