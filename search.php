<?php

require "src/Searcher.php";

$fieldToSearch = $argv[1];
$valueToSearch = $argv[2];

$searcher = new Searcher(new DataLoader());

try {
    $searcher->runSearches($fieldToSearch, $valueToSearch);
} catch (Exception $exception) {
    echo $exception->getMessage();
}