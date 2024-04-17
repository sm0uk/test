<?php
/*Установить свои настройки*/
define('HOST', 'localhost');
define('DATABASE', 'lsr');
define('USER', 'lsr');
define('PASSWORD', 'lsr');

define('PATH_AUTOLOAD', 'vendor/autoload.php');

/*Прочие настройки*/
define('PATH_TO_TEMPALTES', 'templates');
$dictionaryList = [
    'ru' => [
        'name' => 'Имя',
        'email' => 'Почта',
        'phone' => 'Телефон',
        'save' => 'Сохранить',
        'title' => 'Тест',
    ],
    'en' => [
        'name' => 'First name',
        'email' => 'E-mail',
        'phone' => 'Phone number',
        'save' => 'Save',
        'title' => 'Test',
    ]
];