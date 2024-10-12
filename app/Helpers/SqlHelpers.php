<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Cache;
use Str;

class SqlHelpers {

    function cacheQuery($sql, $params, $timeout = 1) {
        return Cache::remember(md5($sql.join("",$params)), $timeout, function() use ($sql, $params) {
            return DB::select($sql, $params);
        });
    }

    function cacheFilterQuery($sql, $params, $timeout = 1) {
        return Cache::remember(md5($sql.join("",$params)), $timeout, function() use ($sql, $params) {
            // wherein ignore
            unset($params["atype"]);
            unset($params["acond"]);
            unset($params["adur"]);
            unset($params["brandc"]);
            unset($params["modc"]);
            unset($params["transc"]);
            unset($params["fuelc"]);
            unset($params["engc"]);
            unset($params["bodyc"]);
            unset($params["passec"]);
            unset($params["colv"]);
            unset($params["sellv"]);
            return DB::select($sql, $params);
        });
    }

    function cacheQueryORM($sql, $params, $single = false, $timeout = 1) {
        return Cache::remember(md5($sql->toSql().join("",$params)), $timeout, function() use ($sql, $single) {
            if($single) return $sql->first();
            return $sql->get();
        });
    }

    public static function simpleSelect($query, $params)
    {
        try {
            return [
                "status"=> true,
                "data"=> self::cacheQuery($query, $params)
            ];
            
        } catch (\Throwable $th) {
            return [
                "status"=> false,
                // "data"=> "error query"
                "data"=> [],
                "message"=> "error query"
            ];
        }
    }

    public static function simpleInsertResult($query, $params)
    {
        try {
            $id = DB::insert($query, $params);
            return ResponseService::success();
        } catch (\Throwable $th) {
            return ResponseService::catchError($th);
        }
    }
    
    public static function simpleDeleteResult($query, $params)
    {
        try {
            $id = DB::insert($query, $params);
            return ResponseService::success();
        } catch (\Throwable $th) {
            return ResponseService::catchError($th);
        }
    }

    public static function simpleSelectResult($query, $params, $with_all = '0', $extraData = [], $extra = false)
    {
        try {
            // $result = DB::select($query, $params);
            $result = self::cacheQuery($query, $params);
            if($with_all == "1") array_unshift($result, [ "id"=> "", "text"=> "Semua"]);

            // if (empty($result)) {
            //     return ResponseService::notSuccess();
            // }
            
            if($extra){
                $result = [
                    "data"=> $result,
                    "other"=> $extraData
                ];
            }
    
            return ResponseService::success($result);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseService::catchError($th);
        }
    }
    public static function simpleSelectFilterResult($query, $params, $with_all = '0', $extraData = [], $extra = false)
    {
        try {
            $result = self::cacheFilterQuery($query, $params);
            
            if($extra){
                $result = [
                    "data"=> $result,
                    "other"=> $extraData
                ];
            }
    
            return ResponseService::success($result);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseService::catchError($th);
        }
    }

    public static function selectAndCountResult($query, $query_count, $params, $current_page, $limit, $offset, $params_count = [])
    {
        try {
            $result_count = self::cacheQuery($query_count, (empty($params_count)) ? $params:$params_count);
            $data_cnt = $result_count[0]->cnt;

            if(isset($limit)) $params["limit"] = intval($limit);
            if(isset($offset)) $params["offset"] = intval($offset);
            $result = self::cacheQuery($query, $params);
            
            $out = [
                "data"=> $result,
                // "params" =>$params,
                // "query" =>$query,
                "pagination"=> [
                  "total_records"=> intval($data_cnt),
                  "current_page"=> $current_page,
                  "total_pages"=> intval($data_cnt/$limit) + (($data_cnt%$limit == 0) ? 0:1),
                  "next_page"=> $current_page >= intval($data_cnt/$limit) ? null: $current_page + 1,
                  "prev_page"=> $current_page == 1 ? null:$current_page-1,
                ]
            ];
    
            return ResponseService::success($out);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseService::catchError($th);
        }
    }
    
    public static function selectAndCountResultORM($query, $select_array, $sortby_query, $current_page, $limit, $offset, $params)
    {
        try {
            $query->select([Db::raw('count(1) as cnt')]);
            $result_count = self::cacheQueryORM($query, $params);
            $data_cnt = $result_count[0]->cnt;

            $query->select($select_array)
                            ->orderByRaw($sortby_query)
                            ->limit($limit)
                            ->offset($offset);
            $result = self::cacheQueryORM($query, $params);
            
            $out = [
                "data"=> $result,
                "pagination"=> [
                  "total_records"=> intval($data_cnt),
                  "current_page"=> $current_page,
                  "total_pages"=> intval($data_cnt/$limit) + (($data_cnt%$limit == 0) ? 0:1),
                  "next_page"=> $current_page >= intval($data_cnt/$limit) ? null: $current_page + 1,
                  "prev_page"=> $current_page == 1 ? null:$current_page-1,
                ]
            ];
    
            return ResponseService::success($out);
        } catch (\Throwable $th) {
            //throw $th;
            return ResponseService::catchError($th);
        }
    }

    public static function simpleSelectORMFirst($query, $params)
    {
        try {
            return [
                "status"=> true,
                "data"=> self::cacheQueryORM($query, $params, true)
            ];

        } catch (\Throwable $th) {
            return [
                "status"=> false,
                "data"=> "error query"
            ];
        }
    }

    public static function setLimitParams($val, $default_val = null){
        $limit = intval($val);
        if($limit < 1) $limit = $default_val ?? env("DEFAULT_LIMIT");
        if($limit > env("DEFAULT_MAX_LIMIT")) $limit = env("DEFAULT_MAX_LIMIT");
        return $limit;
    }

    public static function setLocationParams($val, $default_val = null){
        $limit = intval($val);
        if($limit < 1) $limit = $default_val ?? env("DEFAULT_LIMIT");
        if($limit > env("DEFAULT_MAX_LIMIT")) $limit = env("DEFAULT_MAX_LIMIT");
        return $limit;
    }

    public static function setItemSortByParams($val = "", $nearestEnable = false){
        $sortby_query = 'IFNULL(a.sundul_date, a.created_date) desc';
        if($val == 'expensive') $sortby_query = 'a.price desc, IFNULL(a.sundul_date, a.created_date) desc';
        else if($val == 'cheapest') $sortby_query = 'a.price asc, IFNULL(a.sundul_date, a.created_date) desc';
        else if($val == 'nearest' && $nearestEnable) $sortby_query = 'distance asc, IFNULL(a.sundul_date, a.created_date) desc';
        return $sortby_query;
    }

    public static function uploadImage($image, $path){
        $extension = $image->getClientOriginalName();
        $extension = pathinfo($extension, PATHINFO_EXTENSION);
        $namaFile = str_replace('-', '', Str::uuid()->toString()).'.'.$extension;
        $image->move(public_path() . $path, $namaFile);
        return $namaFile;
    }

    public static function deleteImage($image, $path){
        if ($image && file_exists(public_path() . $path . $image)) {
          unlink(public_path() . $path . $image);
        }
    }

}
