bfw-controller
=
Module Controller pour BFW


---

__Installation :__

Il est recommand� d'utiliser composer pour installer le framework :

Pour r�cup�rer composer:
```
curl -sS https://getcomposer.org/installer | php
```

Pour installer le framework, cr�ez un fichier "composer.json" � la racine de votre projet, et ajoutez-y ceci:
```
{
    "require": {
        "bulton-fr/bfw-controller": "@stable"
    }
}
```

Enfin, pour lancer l'installation, 2 �tapes sont n�cessaires :

R�cup�rer le module via composer :
```
php composer.phar install
```
Via un utilitaire du framework BFW, cr�er un lien vers le module dans le dossier module du projet :
```
sh vendor/bin/bfw_loadModules
```
