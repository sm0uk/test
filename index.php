<?php
include 'include/config.php';
require_once PATH_AUTOLOAD;

include 'include/helper.php';

$fields = initFields();

$error = [];
$message = [];
$lang = $_COOKIE['lang'] ?? 'ru';
$dictionary = $dictionaryList[$lang];
if (!empty($_GET['lang'])) {
    $lang = htmlspecialchars($_GET['lang']);
    setcookie('lang', $lang, time()+3600, '/');
}

if (!empty($_POST)) {
    $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($mysqli->connect_errno) {
        throw new RuntimeException('mysqli: ' . $mysqli->connect_error);
    }
    foreach ($fields as $key => $input) {
           $check = validate($key, $_POST[$key]);
           if (!empty($check)) {
               $error[] = replaceKeyMsg($key, $check, $dictionary);
           } else {
               $fields[$key] = trim(htmlspecialchars($_POST[$key]));
           }
    }
    if (empty($error)) {
        $sql =  sprintf("SELECT `email`, `phone` FROM `result` WHERE  `email`='%s' OR `phone`='%s'", $fields['email'], $fields['phone']);
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
            foreach (['email', 'phone'] as $field) {
                if ($row[$field] == $fields[$field]) {
                    $error[] = replaceKeyMsg($field, 'Такой %'.$field.'% уже существует', $dictionary);
                }
            }
        }
    }
    if (empty($error)) {
        $sql = sprintf("INSERT INTO `result`(`name`, `email`, `phone`, `date`) VALUES ('%s','%s', '%s', NOW())", $fields['name'], $fields['email'], $fields['phone']);
        if ($mysqli->query($sql)) {
            $message[] = 'ok';
            $fields = initFields();
        }
    }
}

$param =  [
    'lang' => $lang,
    'dictionary' => $dictionary,
    'form' => $fields,
    'error' => implode(', ', $error),
    'message' => implode(', ', $message),
];

$loader = new \Twig\Loader\FilesystemLoader(PATH_TO_TEMPALTES);
$twig = new \Twig\Environment($loader);
echo $twig->render('index.html', $param);