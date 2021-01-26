<?php

class DirectoryTree
{
    /**
     * @var array|array[] Дерево каталога
     */
    protected $tree = [];

    /**
     * Конструктор, который вызывается при создании класса
     * @param $folder
     */
    public function __construct($folder)
    {
        $this->tree = $this->getTree($folder);
    }

    /**
     * Метод, который рекурсивно строит дерево
     * @param $path
     * @return array
     */
    protected function getTree($path)
    {
        $tree = [];
        /* Получаем полный список файлов и каталогов внутри $folder */
        $files = scandir($path);
        foreach ($files as $file) {
            /* Отбрасываем текущий и родительский каталог */
            if (($file == '.') || ($file == '..')) {
               continue;
            }

            $fullPath = $path . '/' . $file; //Получаем полный путь к файлу
            /* Если это директория */
            if (is_dir($fullPath)) {
                /* С помощью рекурсии выводим содержимое полученной директории. Рекурсия - вызов метода своего объекта через $this */
                $tree[$file] = $this->getTree($fullPath);
            } /* Если это файл, то просто выводим название файла */
            else {
                $tree[$file] = null;
            }
        }

        return $tree;
    }

    /**
     * Метод, который рекурсивно выводит содержимое дерева
     * @param null $tree
     * @param string $parentPath
     */
    public function printTree($tree = null, $parentPath = '')
    {
        if ($tree === null) {
            $tree = $this->tree;
        }
        foreach ($tree as $directory => $subTree) {
            if ($subTree === null) {
                echo $parentPath . $directory . "\n";
            } else {
                $this->printTree($subTree, $parentPath . $directory . '/');
            }
        }
    }
}