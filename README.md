Sylius Payzen Bundle
===========

Sylius PayZen bundle via Payum


## Installation pour Sylius

* Copie le contenu de `src` dans `src/Kiboko/Bundle/SyliusPayzenBundle`

* Déclarer le bundle dans `config/bundles.php` :

```
Kiboko\Bundle\SyliusPayzenBundle\KibokoSyliusPayzenBundle::class => ['all' => true],
```

 
* Ajouter dans le fichier `composer.json` dans la partie `psr-4` :
```
"Kiboko\\Bundle\\": "src/Kiboko/Bundle/",
```