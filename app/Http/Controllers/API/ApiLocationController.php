<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use ResponseService;
use SqlHelpers;

class ApiLocationController extends Controller
{

    public function getLocation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'query' => 'nullable',
            // 'query' => 'required|min:3', // masih harus di improve front end nyaa pakai autocomplete // current pakai select2
        ]);

        if ($validator->fails()) return ResponseService::badRequest($validator->messages());
        
        $params = $validator->valid();
        $params["query"] = $params["query"] ??"";
        $params["query"] = "%".$params["query"]."%"; // alter value like
        
        $query = "
            select 
                a.id, case when a.id = 1 then a.name else concat(a.name, ', ', b.name) end as text, a.longitude, a.latitude
            from 
                t_m_address a 
                left join t_m_address b on a.parent_id = b.id
            where a.name like :query
            order by a.seq asc
            limit 0,5
        ";

        return SqlHelpers::simpleSelectResult($query, $params);
    }

    public function getLocationByCoordinate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) return ResponseService::badRequest($validator->messages());
        
        $params = $validator->valid();

        $query = "
            SELECT 
            a.id, case when a.id = 1 then a.name else concat(a.name, ', ', b.name) end as text,
            (
                6371 *
                acos(cos(radians(:latitude)) * 
                cos(radians(a.latitude)) * 
                cos(radians(a.longitude) - 
                radians(:longitude)) + 
                sin(radians(:latitude)) * 
                sin(radians(a.latitude)))
            ) AS distance ,
             a.latitude,
             a.longitude
            FROM 
                t_m_address a 
                left join t_m_address b on a.parent_id = b.id
            WHERE a.type = 'DISTRICT'
            ORDER BY distance LIMIT 0, 1
        ";

        return SqlHelpers::simpleSelectResult($query, $params);
    }

    public function getLocationReference(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'query' => 'nullable',
            'type' => 'nullable',
            // 'query' => 'required|min:3', // masih harus di improve front end nyaa pakai autocomplete // current pakai select2
        ]);

        if ($validator->fails()) return ResponseService::badRequest($validator->messages());
        
        $params = [];
        // $params["query"] = $params["query"] ??"";
        // $params["query"] = "%".$params["query"]."%"; // alter value like

        $type = $request->input("type") ??"";
        if($type == "2") { $where = " and type = 'CITY'"; }
        elseif($type == "3") { 
            $where = " and type = 'DISTRICT'"; 
        }
        else { $type = 1; $where = " and type = 'PROVINCE'"; }

        $parent = $request->input("parent");
        if(!empty($parent)){
            $params["parent"] = $parent;
            $where .= " and parent_id = :parent";
        } else {
            if(in_array($type,["2","3"])) return ResponseService::success();
        }

        $query = "
            select 
                a.id, a.name as text
            from 
                t_m_address a 
            where 
                1=1
                $where
            order by a.seq asc
        ";

        // return ["query"=> $query,"params"=> $params,];

        return SqlHelpers::simpleSelectResult($query, $params);
    }
}
