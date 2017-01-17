# Vulcan Collections
A simple PHP collection implementation to simplify the means of working with arrays of data.

## Installation
Install using Composer:

```
composer require vulcan/collection
```

## Usage
```php
$array      = ['lorem', 'ipsum', 'dolor'];
$collection = new \Vulcan\Collections\Collection($array);

var_dump($collection->all());
```

## Methods

### all
The `all` method retrieves all the items from the collection.

```php
$collection = new Collection(['lorem', 'ipsum', 'dolor'])->all();

// ['lorem', 'ipsum', 'dolor']
```

### get
The `get` method retrieves the specified item from the collection.

```php
$collection = new Collection(['foo' => 'bar', 'lorem' => 'ipsum'])->get('lorem');

// ipsum
```
