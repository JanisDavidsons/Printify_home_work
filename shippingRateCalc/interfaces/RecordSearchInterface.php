<?php


namespace App\interfaces;


interface RecordSearchInterface
{
    public function findRecord(string $searchFor, array $searchIn):?string;
}