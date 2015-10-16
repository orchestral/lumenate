Orchestra Platform Lumenate Installer
==============

[![Join the chat at https://gitter.im/orchestral/lumenate](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/orchestral/lumenate?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Lumenate is an experimental project primarily intended for extending API functionality on Orchestra Platform by adding Lumen on the same codebase as your primary application.

## Installation

First, install the Lumenate installer and make sure that the global Composer `bin` directory is within your system's `$PATH`:

    composer global require "orchestra/lumenate=^0.1"

Next, create a new Laravel application and install Lumen:

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
