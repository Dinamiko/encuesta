# encuesta
Ejemplo aplicación web en WordPress
https://speakerdeck.com/emili/creacion-de-aplicaciones-web-usando-wordpress-wordcamp-cantabria-2015

### run tests
IMPORTANT: don't run the tests in a production WordPress site, database is deleted and recreated on each test run.
Create a new database and a fresh WordPress installation to run the tests on.

suites: integration, functional, acceptance
* vendor/bin/wpcept run
* vendor/bin/wpcept run suite
* vendor/bin/wpcept run suite --steps --debug

### create new tests
suites: integration, functional, acceptance
* vendor/bin/wpcept generate:wpunit integration "Lorem"
* vendor/bin/wpcept generate:cept suite "Lorem"
* vendor/bin/wpcept generate:cest suite "Lorem"

### install WPBrowser, will install Codeception for you
* composer require lucatume/wp-browser --dev

### creates tests directory and scaffold acceptance, functional, integration and unit suites
* vendor/bin/wpcept bootstrap

### configure tests/suite-name.suite.yml files
* add your WordPress installation data like database name, url...

### build
If the actor classes are not created or updated as you expect,
try to generate them manually with the build command
* vendor/bin/wpcept build
