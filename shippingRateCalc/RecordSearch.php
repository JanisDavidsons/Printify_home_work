<?php

namespace App;

use App\interfaces\RecordSearchInterface;

class RecordSearch implements RecordSearchInterface
{
    private static ? string $result = null;

    public static function findRecord(string $searchFor, array $searchIn):string
    {
        foreach ($searchIn as $key => $value) {
            // converting $key to string to prevent key type conversion
            if ((string)$key == $searchFor) {
                self::$result = json_encode($value);
            }
            if (is_array($value)) {
                self::findRecord($searchFor, $value);
            }
        }
        return self::$result;
    }
}
