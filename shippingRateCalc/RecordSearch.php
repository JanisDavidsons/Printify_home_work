<?php

namespace App;

use App\interfaces\RecordSearchInterface;

class RecordSearch implements RecordSearchInterface
{
    private ? string $result = null;
    private ? array $modified = null;

    public function findRecord(string $searchFor, array $searchIn): ?string
    {
        foreach ($searchIn as $key => $value) {
            // converting $key to string to prevent key type conversion
            if ((string)$key == $searchFor) {
                $this->result = json_encode($value);
            }
            if (is_array($value)) {
                $this->findRecord($searchFor, $value);
            }
        }
        return $this->result;
    }


    function findReplace(string $searchFor, string $replaceWith, $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->findReplace($searchFor, $replaceWith, $value);
            } else {
                if ($key == $searchFor) {
                    $array[$key] = $replaceWith;
                    break;
                }
            }
        }
        return $array;
    }
}
