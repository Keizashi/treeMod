<?php

class DirectoryTreeModificator extends DirectoryTree
{
    /**
     * Метод создает текстовый файл в рандомной директории дерева
     */
    public function createTextFile()
    {
        // Получаем список всех путей дерева
        $paths = $this->getPaths($this->tree);

        // Перемешиваем пути, чтобы выбрать случайный
        shuffle($paths);

        // Проходим по всем путям, пока не найдем первый путь-директорию (тот, у которого последний элемент не null)
        $targetPath = null;
        foreach ($paths as $path) {
            if ($path[count($path) - 1] !== null) {
                $targetPath = $path;
                break;
            }
        }

        // С помощью передачи по значению проходимся по пути и добавляем текстовый файл в дерево (https://stackoverflow.com/questions/9628176/using-a-string-path-to-set-nested-array-data)
        $item = &$this->tree;
        foreach ($targetPath as $key) {
            $item = &$item[$key];
        }
        $item['some_text_file.txt'] = null;
    }

    // Удалить случайный элемент дерева
    public function deleteItem()
    {
        // Получаем список всех путей дерева
        $paths = $this->getPaths($this->tree);

        // Перемешиваем пути, чтобы выбрать случайный
        shuffle($paths);

        // Первый путь - будет случайным
        $targetPath = $paths[0];

        // С помощью передачи по значению проходимся по пути и удаляем этот элемент из массива (https://stackoverflow.com/questions/9628176/using-a-string-path-to-set-nested-array-data)
        $item = &$this->tree;
        foreach ($targetPath as $index => $key) {
            // Если это последний элемент пути - удаляем ключ массива-дерева
            if ($index == (count($targetPath) - 1)) {
                unset($item[$key]);
            } else {
                $item = &$item[$key];
            }
        }
    }

    /**
     * Метод, который рекурсивно формирует список путей в виде массива
     * @param null $tree
     * @param array $currentPath
     * @return array
     */
    protected function getPaths($tree, $currentPath = [])
    {
        $paths = [];
        foreach ($tree as $directory => $subTree) {
            if ($subTree === null) {
                $paths[] = array_merge($currentPath, [$directory, null]);
            } else {
                $paths[] = array_merge($currentPath, [$directory]);
                $paths = array_merge($paths, $this->getPaths($subTree, array_merge($currentPath, [$directory])));
            }
        }

        return $paths;
    }
}