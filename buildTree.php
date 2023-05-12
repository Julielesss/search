<?php

require "src/BinaryTree.php";
require "src/DataLoader.php";

$field = $argv[1];

$binary = new BinaryTree(new DataLoader());
try {
    $binary->createTree($field);
} catch (Exception $exception) {
    echo $exception->getMessage();
}