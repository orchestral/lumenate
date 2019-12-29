Orchestra Platform Lumenate Installer
==============

Lumenate is an experimental project primarily intended for extending API functionality on Orchestra Platform by adding Lumen on the same codebase as your primary application.

[![Latest Stable Version](https://poser.pugx.org/orchestra/lumenate/version)](https://packagist.org/packages/orchestra/lumenate)
[![Total Downloads](https://poser.pugx.org/orchestra/lumenate/downloads)](https://packagist.org/packages/orchestra/lumenate)
[![Latest Unstable Version](https://poser.pugx.org/orchestra/lumenate/v/unstable)](//packagist.org/packages/orchestra/lumenate)
[![License](https://poser.pugx.org/orchestra/lumenate/license)](https://packagist.org/packages/orchestra/lumenate)

## Installation

First, install the Lumenate installer and make sure that the global Composer `bin` directory is within your system's `$PATH`:

    composer global require "orchestra/lumenate=^1.0"

Next, create a new Orchestra Platform application and install Lumen:

    composer create-project orchestra/platform application
    cd application
    lumenate install

After installing Lumen, you can also opt to add the base Lumen application skeleton under `lumen` folder, you can do this by running:

    lumenate make

You can also choose to add new path to autoload to detect `lumen/app` using PSR-4 or use a single `app` directory.

```json
{
    "autoload": {
        "psr-4": {
            "App\\Lumen\\": "lumen/app/",
            "App\\": "app/",
        }
    },
    "autoload-dev": {
        "classmap": [
            "lumen/tests/LumenTestCase.php",
            "tests/TestCase.php"
        ]
    },
}
```
