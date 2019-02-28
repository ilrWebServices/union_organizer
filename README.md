# Union Organizer

A lightweight custom Drupal module that creates Twig namespacing and dynamic library loader to integrate with the [Union Component System](https://github.com/ilrWebServices/union).

## Installation and Usage

### 1. Add the [Union Component System](https://github.com/ilrWebServices/union)

There are a few ways to do this. You could download a zipped file and install in the `libraries/` directory in your webroot. Or, using Composer, you can use [Composer installers extender](https://github.com/oomphinc/composer-installers-extender).

```
$ composer require oomphinc/composer-installers-extender
```

Then, add or edit the following sections of your `composer.json` file:

```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ilrWebServices/union.git"
        },
    ...
    "extra": {
        "installer-types": ["library"],
        "installer-paths": {
            "web/libraries/{$name}": ["type:drupal-library", "cornell/union"],
        }
    }
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
{% include "@union/[COMPONENT_NAME]/[COMPONENT_NAME].twig" with {
  var: 'value'
} only %}
```

For example:

```
{{ attach_library('union_organizer/union.button') }}
{% include "@union/button/button.twig" with {
  text: content.field_cta.value
} only %}
```
