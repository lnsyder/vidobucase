<?php

namespace App\Libraries\Cache;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use App\Models\People;
use App\Models\Address;

class CacheControl extends Controller
{
    const DEFAULT_TIME = 10800;
    const ONE_HOUR = 3600;
    private static $fields;
    private static $getOrFirst;

    public function __construct()
    {
        self::$fields = null;
        self::$getOrFirst = true;
    }

    public static function peopleRedis($filter, $object = true)
    {
        $keyValue = null;
        $modelPrefix = "App\Models\\";
        $modelName = "People";
        $redisPrefix = strtolower($modelName);

        if ($filter == "get") {
            $keyValue .= "all";
            $queryType = "get";
        } else {
            foreach ($filter as $keyArray => $value) {
                $keyValue .= "-" . $keyArray . "-" . $value;
                $query['field'] = $keyArray;
                $query['value'] = $value;
            }
            $queryType = "first";
        }

        $keyValue = ltrim($keyValue, '-');
        $redisKey = "$redisPrefix:{$keyValue}:$queryType";

        $model = $modelPrefix . $modelName;
        $cache = json_decode(Redis::get($redisKey), $object);

        if (!isset($cache)) {
            if ($filter == "get") {
                $cache = $model::select('people.*', 'addresses.*')
                    ->leftJoin('addresses', 'people.id', '=', 'addresses.person_id')
                    ->get();
            } else {
                $cache = $model::select('people.*', 'addresses.*')
                    ->leftJoin('addresses', 'people.id', '=', 'addresses.person_id')->where($query['field'], $query['value'])->first();
            }

            Redis::set($redisKey, json_encode($cache));
            Redis::expire($redisKey, self::DEFAULT_TIME);
        }
        return $cache;
    }

    public static function clearRedis($filter)
    {
        $keys = Redis::del($filter);
    }


}
