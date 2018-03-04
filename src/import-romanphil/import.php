<?php
/*
MAIN per importazione

Importa una categoria per volta,
quindi ogni prodotto della idCategoria
*/


require '../wordpress/wp-blog-header.php';
require('simple_html_dom.php');
require '.auth.php';
require 'postSlug.php';
require 'categories.php';
require 'products.php';
require 'images.php';


$pdo = new PDO($cnn, $user, $pass);
$site='http://www.romanphil.com/';
//$html = file_get_html($site . 'Lista_Prodotti.asp?idCategoria=23&style=1&page=1#');
$html = file_get_html($site);

getCategories($html);
