Sylius Payzen Bundle
===========

Sylius PayZen bundle via Payum


### Usage & install

1. Install this bundle:

```bash
$ composer require kiboko/sylius-payzen-bundle
```

2. Configure new payment method in Sylius Admin

### Complementary documentation

- [Sylius Payments](http://docs.sylius.org/en/latest/book/orders/payments.html)
- [Payum](https://github.com/Payum/Payum/blob/master/docs/index.md)
- [Ekyna/PayumPayzenBundle](https://github.com/ekyna/PayumPayzenBundle)


# Installation manuelle (old)

* Copie le contenu de `src` dans `src/Kiboko/Bundle/SyliusPayzenBundle`

* Déclarer le bundle dans `config/bundles.php` :

```
Kiboko\Bundle\SyliusPayzenBundle\KibokoSyliusPayzenBundle::class => ['all' => true],
```

 
* Ajouter dans le fichier `composer.json` dans la partie `psr-4` :
```
"Kiboko\\Bundle\\": "src/Kiboko/Bundle/",
```

### Build archive

Install `jq` package.

Run `make build`

In your project, you can add the plugin with 

```
    "repositories": {
        "payzen-integration": {
            "type": "package",
            "package": {
                "name": "kiboko/sylius-payzen-bundle",
                "version": "0.1.0",
                "dist": {
                    "url": "{PATH_TO_YOUR_ARCHIVE}/sylius-payzenbundle-0.1.0.tar",
                    "type": "tar"
                }
            }
        }
    }
```

And run `composer require kiboko/sylius-payzen-bundle`
