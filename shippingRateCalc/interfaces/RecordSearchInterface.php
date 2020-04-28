<?php


namespace App\interfaces;


interface RecordSearchInterface
{
    public function findRecord(string $searchFor, array $searchIn):?string;
    public function findReplace(string $searchFor,string $replaceWith,array $arr):array ;
}