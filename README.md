# PRODUCT-PARSER-CLI

 product csv parser app with unique combinations


## Installation & Setup

Composer is used for autoloading classes & tests

```bash
  cd project
  composer dump-autoload
```
Two csv file in included in the project root folder.You can also put your csv into the root folder as well.then run the parser to generate combination count output csv.Output csv will also be generated into the project root folder.
    
## Command Reference

#### Get help

```bash
  php parser.php --help
```

#### pass arguments

```bash
  php parser.php [--file=<filename>] [--unique-combinations=<filename>]
  php parser.php --file="products.csv" --unique-combinations="combination_count.csv"
```


