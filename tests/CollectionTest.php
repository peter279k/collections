<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Vulcan\Collections\Collection;

class CollectionTest extends TestCase
{
    public function test_static_make_method()
    {
        $collection = Collection::make(['foo', 'bar', 'baz']);
        $this->assertSame(['foo', 'bar', 'baz'], $collection->all());
    }

    public function test_all_method()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);
        $this->assertSame(['foo', 'bar', 'baz'], $collection->all());
    }

    public function test_get_method()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);
        $this->assertSame('bar', $collection->get(1));

        $collection = new Collection(['foo' => 'bar', 'lorem' => 'ipsum']);
        $this->assertSame('ipsum', $collection->get('lorem'));
    }

    public function test_push_method()
    {
        $collection = new Collection('foo');
        $collection->push('bar');

        $this->assertSame(['foo', 'bar'], $collection->all());
    }

    public function test_put_method()
    {
        $collection = new Collection(['lorem' => 'bar']);
        $collection->put('lorem', 'ipsum');

        $this->assertSame(['lorem' => 'ipsum'], $collection->all());
    }

    public function test_remove_method()
    {
        $collection = new Collection(['foo' => 'bar', 'lorem' => 'ipsum']);
        $collection->remove('lorem');

        $this->assertSame(['foo' => 'bar'], $collection->all());
    }

    public function test_exists_method()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertTrue($collection->exists('foo'));
        $this->assertFalse($collection->exists('bar'));
    }

    public function test_count_method()
    {
        $collection = new Collection(['foo', 'bar', 'baz', 'lorem', 'ipsum']);

        $this->assertSame(5, $collection->count());
    }

    public function test_first_method()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $this->assertSame('foo', $collection->first());
    }

    public function test_last_method()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $this->assertSame('baz', $collection->last());
    }

    public function test_each_method()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $result = [];

        $collection->each(function($item, $key) use (&$result) {
            $result[$key] = $item;
        });

        $this->assertEquals($result, $collection->all());
    }

    public function test_map_method()
    {
        $collection = new Collection([1, 2, 3, 4, 5]);

        $mapped = $collection->map(function($item, $key) {
            return $item * 2;
        });

        $this->assertSame([2, 4, 6, 8, 10], $mapped->all());
    }

    public function test_filter_method()
    {
        $collection = new Collection([
            ['title' => 'Foo', 'price' => 86],
            ['title' => 'Bar', 'price' => 132],
            ['title' => 'Lorem', 'price' => 102],
            ['title' => 'Ipsum', 'price' => 13]
        ]);

        $expensiveItems = $collection->filter(function($item, $key) {
            return $item['price'] > 100;
        });

        $this->assertSame([
            ['title' => 'Bar', 'price' => 132],
            ['title' => 'Lorem', 'price' => 102]
        ], $expensiveItems->all());
    }

    public function test_reject_method()
    {
        $collection = new Collection([
            ['title' => 'Foo', 'price' => 86],
            ['title' => 'Bar', 'price' => 132],
            ['title' => 'Lorem', 'price' => 102],
            ['title' => 'Ipsum', 'price' => 13]
        ]);

        $affordableItems = $collection->reject(function($item, $key) {
            return $item['price'] > 100;
        });

        $this->assertSame([
            ['title' => 'Foo', 'price' => 86],
            ['title' => 'Ipsum', 'price' => 13]
        ], $affordableItems->all());
    }

    public function test_filter_map_methods()
    {
        $collection = new Collection([
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Alan Doe', 'email' => 'alan@example.com'],
            ['name' => 'Jane Doe', 'email' => null],
            ['name' => 'Zoe Doe', 'email' => null],
        ]);

        $userEmails = $collection->filter(function($item, $key) {
            return $item['email'] !== null;
        })->map(function($item, $key) {
            return $item['email'];
        });

        $this->assertSame([
            'john@example.com',
            'alan@example.com',
        ], $userEmails->all());
    }

    public function test_map_filter_methods_separately()
    {
        $employees = new Collection([
            ['name' => 'Mary', 'email' => 'mary@example.com', 'salaried' => true],
            ['name' => 'John', 'email' => 'john@example.com', 'salaried' => false],
            ['name' => 'Kelly', 'email' => 'kelly@example.com', 'salaried' => true],
        ]);

        $employeeEmails = $employees->map(function ($employee) {
            return $employee['email'];
        });

        $salariedEmployees = $employees->filter(function ($employee) {
            return $employee['salaried'];
        });

        $this->assertSame([
            'mary@example.com',
            'john@example.com',
            'kelly@example.com'
        ], $employeeEmails->all());

        $this->assertSame([
            ['name' => 'Mary', 'email' => 'mary@example.com', 'salaried' => true],
            ['name' => 'Kelly', 'email' => 'kelly@example.com', 'salaried' => true],
        ], $salariedEmployees->all());
    }

    public function test_array_access_implementation()
    {
        $collection = Collection::make([1, 2, 3]);

        $this->assertSame(3, $collection[2]);
    }
}
