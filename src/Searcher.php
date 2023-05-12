<?php

require "BinaryTree.php";
require "DataLoader.php";

class Searcher
{
    protected DataLoader $dataLoader;
    public function __construct(DataLoader $dataLoader)
    {
        $this->dataLoader = $dataLoader;
    }

    public function runSearches(string $searchKey, string $searchValue): void
    {
        $data = $this->dataLoader->loadDataFromJson();
        $this->findElementsWithTree($searchKey, $searchValue);
        $this->findElementsWithoutTree($data, $searchKey, $searchValue);
    }
    public function findElementsWithTree(string $searchKey, string $searchValue): void
    {
        $binary = new BinaryTree($this->dataLoader);
        $binary->root = $this->dataLoader->loadTreeFromFile();
        $result = $binary->search($searchKey, $searchValue);
        echo "Binary search: \n";
        echo "Count of comparisons: {$result['countOfComparisons']}\n";
        if ($result['node']) {
            echo "Element found: \n";
            var_dump($result['node']);
        } else {
            echo "Not found";
        }
    }

    public function findElementsWithoutTree(array $data, string $searchKey, string $searchValue): void
    {
        echo "\n\nLinear search: \n";
        $countOfComparisons = 0;
        $result = null;
        foreach ($data as $item) {
            ++$countOfComparisons;
            if ($item->{$searchKey} === $searchValue) {
                $result = $item;
                break;
            }
        }
        echo "Count of comparisons: {$countOfComparisons}\n";
        if ($result !== null) {
            echo "Element found: \n";
            var_dump($result);
        } else {
            echo "Not found\n";
        }
    }
}