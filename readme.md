# COP - Cash Operation Processor #

Processes cash operations from specified csv file and outputs commissions.

[Full task objective](task.md)

## Environment requirements ##

* PHP 7.1.*
* Composer

## Installation ##

```
composer install
```

## Usage ##

```
php bin/console cop:process tests/Resources/input.csv
```

## Testing ##

```
php vendor/bin/simple-phpunit -c build/phpunit.xml tests
```

## CodeSniffer

```
php vendor/bin/phpcs --standard=build/phpcs.xml -s src tests
```

## Standards ##

* PSR-1, PSR-2, PSR-4, PSR-11
