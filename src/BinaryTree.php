<?php

require "Node.php";
class BinaryTree
{
    public ?Node $root = null;
    protected array $dataFromJson = [];
    protected ?string $fieldToCompare = null;

    protected DataLoader $dataLoader;

    public function __construct(DataLoader $dataLoader)
    {
        $this->dataLoader = $dataLoader;
    }

    public function createTree(string $fieldToSortBy): void
    {
        $this->dataFromJson = $this->dataLoader->loadDataFromJson();
        $sortedDataForTree = $this->sortDataFromJson($fieldToSortBy);
        $this->root = $this->createBalancedTree($sortedDataForTree, 0, count($sortedDataForTree) - 1);
        $this->dataLoader->saveDataToFile($this->root);
        echo "Created tree: \n";
        $this->printTree($this->root);
    }

    public function search(string $searchKey, string $searchValue): array
    {
        if ($this->root->fieldToSort !== $searchKey) {
            throw new Exception("The tree was created by '{$this->root->fieldToSort}' key\n");
        }
        return $this->searchInTree($this->root, $searchValue);
    }

    protected function searchInTree(?Node $root, $value, $countOfComparisons = 0): array
    {
        if ($root === null) {
            return ["node" => null, "countOfComparisons" => ++$countOfComparisons];
        }

        if ($root->value->{$root->fieldToSort} === $value) {
            return ["node" => $root->value, "countOfComparisons" => ++$countOfComparisons];
        } elseif ($root->value->{$root->fieldToSort} > $value) {
            return $this->searchInTree($root->left, $value, ++$countOfComparisons);
        } else {
            return $this->searchInTree($root->right, $value, ++$countOfComparisons);
        }
    }

    public function printTree(?Node $root, int $depth = 1): void
    {
        if ($root == null) {
            return;
        }

        echo "(depth {$depth})\n";
        echo $root->value->{$this->fieldToCompare};
        echo "\nLeft: ";
        $this->printTree($root->left, $depth + 1);
        echo "\nRight: ";
        $this->printTree($root->right, $depth + 1);
    }

    public function sortDataFromJson(string $field): array
    {
        $this->fieldToCompare = $field;
        $this->dataFromJson = array_filter($this->dataFromJson, fn($elem) => isset($elem->{$field}));
        if (empty($this->dataFromJson)) {
            throw new Exception("Didn't find data by '{$field}' key\n");
        }
        usort($this->dataFromJson, fn($a, $b) => ($a->{$field} <=> $b->{$field}));
        return $this->dataFromJson;
    }

    protected function createBalancedTree(array $array, int $start, int $end): ?Node
    {
        if ($end < $start) {
            return null;
        }

        $middleElement = floor(($start + $end) / 2);
        $currentRootNode = new Node($array[$middleElement], $this->fieldToCompare);

        $currentRootNode->left = $this->createBalancedTree($array, $start, $middleElement - 1);
        $currentRootNode->right = $this->createBalancedTree($array, $middleElement + 1, $end);
        return $currentRootNode;
    }
}
