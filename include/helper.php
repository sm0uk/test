<?php

function validate(string $type, string $value): string {
    $result = '';
    if (empty($value)) {
        $result = 'Не заполнено поле %'.$type.'%';
    }
    return $result;
}

function initFields(): array {
    return [
        'name' => '',
        'email' => '',
        'phone' => '',
    ];
}
function replaceKeyMsg(string $key, string $msg, array $dictionary): string {
    return str_replace('%'.$key.'%', $dictionary[$key], $msg);
}
