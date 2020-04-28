<?php


namespace App\interfaces;


interface RecordSearchInterface
{
    public static function findRecord(string $searchFor, array $searchIn):string;
}