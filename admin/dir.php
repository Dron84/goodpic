<?php
define(ROOT, $_SERVER['DOCUMENT_ROOT']);

$structure=ROOT.'/uploads/';

if(!file_exists($structure)){
	if (!mkdir($structure, 0755, true)) {
    die('Не удалось создать директорю.');
	}
}else{echo 'Такой каталог уже есть';}
