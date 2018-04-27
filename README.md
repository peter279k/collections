# Axiom Collections
Collections is a simple and light-weight PHP collections class to help facilitate and ease the means of working with data arrays in an OOP oriented manner.

## Installing Axiom Collections
Axiom Collections requires PHP 7.0 or later. It is not tested against HHVM or older (supported) versions of PHP, but there is nothing in this package (other than PHPUnit) that should cause a failure. Keep in mind that support is not guaranteed in these situations.

It is recommended that you install the package using Composer.

```
$ composer require axiom/collections
```

This package is compliant with [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), and [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md). If you find any compliance oversights, please send a patch via pull request.

## Using Collections

### Creating Collections
You have a couple options for creating a new Collection instance.

One, by simply creating a new instance of the class directly:

```php
$collection = new \Axiom\Collections\Collection([1, 2, 3]);
```

Or two, but using the `make` static helper method:

```php
$collection = Collection::make([1, 2, 3]);
```

### Methods
For the remainder of this documentation, we will run through each of the available methods provided by the Collection class. All of these methods may be chained together to fluently manipulate the underlying array of data. And lastly, in almost every case, each method will return a new `Collections` instance, preserving the original copy of the collection where necessary.

#### `all()`
The `all` method retrieves all the items from the collection.

```php
Collection::make([1, 2, 3])->all();

// [1, 2, 3]
```

#### `count()`
The `count` method returns the total number of items in the collection:

```php
$collection = Collection::make([1, 2, 3, 4]);

$collection->count();

// 4
```

#### `each()`
The `each` method iterates over the items in the collection and passes each item through a callback:

```php
$collection = $collection->each(function($item, $key) {
    //
});
```

To stop iterating over the items and break out of the loop, simply return `false` from your callback:

```php
$collection = $collection->each(function($item, $key) {
    if ($someCondition === true) {
        return false;
    }
});
```

#### `exists()`
The `exists` method determines if the given key exists in the collection.

```php
$collection = Collection::make(['bot_id' => 1, 'name' => 'Loki']);

$collection->exists('name');

// true
```

#### `filter()`
The `filter` method filters the collection using the given callback, keeping only those items that pass a given truth test:

```php
$collection = Collection::make([1, 2, 3, 4]);

$filtered = $collection->filter(function($item, $key) {
    return $value > 2;
});

$filtered->all();

// [3, 4]
```

For the inverse of `filter`, see the `reject` method.

#### `first()`
The `first` method returns the first element in the collection.

```php
Collection::make([1, 2, 3, 4])->first();

// 1
```

#### `flatten()`
The `flatten` method returns a new Collection instance containing a flattened array of items.

```php
$collection = Collection::make([
    'name' => 'Kai',
    'profile' => [
        'age' => 28,
        'favorite_games' => ['Mass Effect', 'Oxygen Not Included', 'event[0]']
    ]
]);

$result = $collection->flatten();

$result->all();

// ['Kai', 28, 'Mass Effect', 'Oxygen Not Included', 'event[0]']
```

#### `get()`
The `get` method returns the item at a given key.

```php
$collection = Collection::make(['foo' => 'bar', 'lorem' => 'ipsum']);

$result = $collection->get('lorem');

// ipsum
```

#### `groupBy()`
The `groupBy` method returns a new Collection instance of items grouped an associative array using a callback.

```php
$collection = Collection::make([
    'foo' => ['type' => 'foobar'],
    'bar' => ['type' => 'foobar'],
    'lorem' => ['type' => 'lorem ipsum'],
    'ipsum' => ['type' => 'lorem ipsum']
]);

$result = $collection->groupBy(function($item) {
    return $item['type'];
});

$result->all();

//
[
    'foobar' => [
        'foo' => ['type' => 'foobar'],
        'bar' => ['type' => 'foobar'],
    ],
    'lorem ipsum' => [
        'lorem' => ['type' => 'lorem ipsum'],
        'ipsum' => ['type' => 'lorem ipsum']
    ]
]
```

#### `keys()`
The `keys` method returns a new Collection instance containing all the keys of the collection items.

```php
$collection = Collection::make(['foo' => 'bar', 'lorem' => 'ipsum']);

$result = $collection->keys();

$result->all();

// ['foo', 'lorem']
```

#### `last()`
The `last` method returns the last element in the collection.

```
Collection::make([1, 2, 3, 4])->last();

// 4
```

#### `map()`
The `map` method iterates through the collection and passes each valye and key to the given callback. The callback is free to modify the item and return it, thus forming a new collection of modified items:

```
$collection = Collection::make([1, 2, 3, 4, 5]);

$multiplied = $collection->map(function($item, $key) {
    return $item * 2;
});

$multiplied->all();

// [2, 4, 6, 8, 10]
```

#### `push()`
the `push` method appends an item to the end of the collection.

```php
$collection = Collection::make([1, 2, 3, 4]);

$collection->push(5);

$collection->all();

// [1, 2, 3, 4, 5]
```

#### `put()`
The `put` method sets the given key and value in the collection.

```php
$collection = Collection::make(['bot_id' => 1, 'name' => 'Odin']);

$collection->put('name', 'Loki');

$collection->all();

// ['bot_id' => 1, 'name' => 'Loki']
```

#### `reject()`
The `reject` method filters the collection using the given callback. The callback should return `true` is the items should be **removed** from the resulting collection.

```php
$collection = Collection::make([1, 2, 3, 4]);

$filtered = $collection->reject(function($item, $key) {
    return $value > 2;
});

$filtered->all();

// [1, 2]
```

#### `remove()`
The `remove` method removes an item rom the collection by its key.

```php
$collection = Collection::make([0, 1, 2, 3]);

$collection->remove(0);

$collection->all();

// [1, 2, 3]
```

#### `reverse()`
The `reverse` method reverses the collection items.

```php
$collection = Collection::make([4, 1, 2, 3, 5])->reverse()->values()->all();

// [5, 3, 2, 1, 4]
```

```php
$collection = Collection::make([4, 1, 2, 3, 5])->sort()->reverse()->values()->all();

// [5, 4, 3, 2, 1]
```

#### `sort()`
The `sort` method sorts the collection of items by their values in ascending order or optionally through a user-defined comparison function.

```php
$data = [4, 1, 2, 3, 5];
```

```php
$collection = Collection::make($data)->sort()->values()->all();

// [1, 2, 3, 4, 5]
```

```php
$collection = Collection::make($data)->sort(function($a, $b) {
    if ($a === $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
})->values()->all();

// [1, 2, 3, 4, 5]
```

#### `sortByKey()`
The `sortByKey` method sorts the collection of items by their keys in ascending order or optionally through a user-defined comparison function.

```php
$data = [
    'foo4' => 1,
    'foo2' => 2,
    'foo5' => 3,
    'foo3' => 4,
    'foo1' => 5
];
```

```php
$collection = Collection::make($data)->sortByKey()->values()->all();

// [5, 2, 4, 1, 3]
```

```php
$collection = Collection::make($data)->sortByKey(function($a, $b) {
    if ($a === $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
})->values()->all();

// [5, 2, 4, 1, 3]
```

#### `values()`
The `values` method returns a new Collection instance containing all the values of the collection items.

```php
$collection = Collection::make(['foo' => 'bar', 'lorem' => 'ipsum']);

$result = $collection->values();

$result->all();

// ['bar', 'ipsum']
```
