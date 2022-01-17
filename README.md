# cliapp-basic-php

 A basic shell for creating cli app in php



## Installation

Composer is used for autoloading classes & tests

```bash
  cd project
  composer dump-autoload
```
    
## Command Reference

#### Get help

```http
  php cliapp.php --help
```

#### pass arguments

```http
  php cliapp.php --filename="test.csv" --unique="test.csv"
  php cliapp.php -f="test.csv" -u="test.csv"
```


