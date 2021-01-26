<?php
// Подключаем файл класса в память, чтобы можно было к нему обратиться.
require_once __DIR__ . '/DirectoryTree.php';
require_once __DIR__ . '/DirectoryTreeModificator.php';

// Создаем объект класса DirectoryTree. При создании создается дерево
$directoryTree = new DirectoryTreeModificator( __DIR__ );

// Выведем дерево
$directoryTree->printTree();

// Создадим текстовый файл
$directoryTree->createTextFile();

// Удалим случайный элемент дерева
$directoryTree->deleteItem();

// Выведем дерево снова
$directoryTree->printTree();
