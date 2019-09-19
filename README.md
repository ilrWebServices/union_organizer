# Union Organizer

A lightweight custom Drupal module that creates Twig namespacing and dynamic library loader to integrate with the [Union Component System](https://github.com/ilrWebServices/union).

## Installation and Usage

### 1. Add the [Union Component System](https://github.com/ilrWebServices/union)

There are two ways to do this.

1. Download a zipped file and install the contents to the `libraries/cornell_ilr--union/` directory in your webroot.
2. Use Composer via [Asset Packagist](https://asset-packagist.org).

To use Composer, ensure that you have the asset-packageist repository added to your `composer.json` file:

```
    "repositories": [
        ...
        {
            "type": "composer",
            "url": "https://asset-packagist.org"
        }
    ...
```

To get the package installed to `web/libraries/`, use [Composer installers extender](https://github.com/oomphinc/composer-installers-extender):

```
$ composer require oomphinc/composer-installers-extender
```

And ensure that `npm-asset`s are configured in the `extra` section of your `composer.json` file:

```
    "extra": {
        "installer-types": ["npm-asset"],
        "installer-paths": {
            "web/libraries/{$name}": ["type:drupal-library", "type:npm-asset"],
        }
    }
```

The above steps only need to happen once. To include the Union Component System in your Drupal site:

```
$ composer require npm-asset/cornell_ilr--union
```

### 2. Add this module to your Drupal Installation

For example, if you are using Composer, you would add the following to your project level `composer.json`:

```
    "repositories": [
        ...,
        {
            "type": "vcs",
            "url": "https://github.com/ilrWebServices/union_organizer.git"
        }
```

Then add the package via:

```
$ composer require drupal/union_organizer:dev-master`
```


### 3. Enable the module

For example, using Drush:

```
$ drush en union_organizer
```

### 4. Add components to Drupal templates

Union component templates are available in the `@union` twig namespace. Union component styles and js are available in individual libraries named after the component.

```
{{ attach_library('union_organizer/union.[COMPONENT_NAME]') }}
{% include "@union/[COMPONENT_NAME].twig" with {
  var: 'value'
} only %}
```

For example:

```
{{ attach_library('union_organizer/union.button') }}
{% include "@union/button.twig" with {
  text: content.field_cta.value
} only %}
```
