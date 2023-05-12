<?php

class DataLoader
{
    const FILENAME_FOR_SAVED_TREE = "files/tree";
    public function loadDataFromJson(string $filename = "files/data.json"): array
    {
        $this->checkIfFileExists($filename);
        $data = file_get_contents($filename);
        return json_decode($data);
    }

    public function loadTreeFromFile(string $filename = self::FILENAME_FOR_SAVED_TREE): mixed
    {
        $this->checkIfFileExists($filename);
        return unserialize(file_get_contents($filename));
    }

    public function saveDataToFile($data, string $filename = self::FILENAME_FOR_SAVED_TREE): void
    {
        $file = fopen($filename, "w");
        fwrite($file, serialize($data));
    }

    protected function checkIfFileExists(string $filename): void
    {
        if (!file_exists($filename)) {
            throw new Exception("File {$filename} doesn't exist. Maybe you didn't build a tree\n");
        }
    }
}