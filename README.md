# PRODUCT-PARSER-CLI

 product csv parser app with unique combinations


## Installation & Setup

Composer is used for autoloading classes & tests

```bash
  cd project
  composer dump-autoload
```
    
## Command Reference

#### Get help

```http
  php parser.php --help
```

#### pass arguments

```http
  php parser.php [--file=<filename>] [--unique-combinations=<filename>]
  php parser.php --file="test.csv" --unique-combinations="test.csv"
  php cliapp.php -f="test.csv" -u="test.csv"
```


