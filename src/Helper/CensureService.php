<?php

namespace App\Helper;

class CensureService
{

    private $wordList = [
        'merde',
        'putain',
        'bordel',
        'connard',
        'salope',
        'enculé',
        'bâtard',
        'foutre',
        'cul',
        'bite',
        'nique',
        'trou du cul',
        'chié',
        'salaud',
        'enfoiré',
        'connasse',
        'crétin',
        'débile',
        'pétasse',
        'taré',
        'zut',
        'saperlipopette',
    ];

    public function censure(string $text)
    {

        foreach ($this->wordList as $injure) {
            $censoredWord = str_repeat('*', mb_strlen($injure));

            $text = str_replace($injure, $censoredWord, strtolower($text));
        }

        return $text;
    }

}