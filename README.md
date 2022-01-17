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

```bash
  php parser.php --help
```

#### pass arguments

```bash
  php parser.php [--file=<filename>] [--unique-combinations=<filename>]
  php parser.php --file="test.csv" --unique-combinations="test.csv"
  php parser.php -f="test.csv" -u="test.csv"
```


