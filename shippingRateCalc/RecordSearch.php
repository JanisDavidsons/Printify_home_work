<?php

//$array = ["result" =>
//    ["id" => "STANDARD",
//        "name" => "Flat Rate (3-4 business days after fulfillment)",
//        "rate" => 5.24,
//        "currency" => "USD",
//        "minDeliveryDays" => 3,
//        "maxDeliveryDays" => 4,]];
//
//
//$fullArray = [
//    ["code" => 200],
//    ["result" =>
//        [0 =>
//            ["id" => "STANDARD",
//                "name" => "Flat Rate (3-4 business days after fulfillment)",
//                "rate" => "5.24",
//                "currency" => "USD",
//                "minDeliveryDays" => 3,
//                "maxDeliveryDays" => 4
//            ]
//        ]
//    ],
//    ["extra" => []]
//];
namespace App;
class RecordSearch
{
    private static ? string $result = null;
    public static function findRecord($searchFor, $array)
    {
        foreach ($array as $key => $value) {
            // converting $key to string to prevent key type conversion
            if ((string)$key == $searchFor) {
                self::$result =json_encode($value);
            }
            if (is_array($value)) {
                self::findRecord($searchFor, $value);
            }
        }
        return self::$result;
    }
}
//echo RecordSearch::findRecord('code', $fullArray);