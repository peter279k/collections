<?php

require('./vendor/autoload.php');

$collection = new \Vulcan\Collections\Collection(['lorem' => ['ipsum' => 'baz']]);

// var_dump($collection->all());
var_dump($collection->get('lorem'));
