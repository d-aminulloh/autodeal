<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SqlHelpers;
use DB;
use Helpers;
use Auth;

class ProfileController extends Controller
{
    private $data = [];
    public function myProfile(Request $request)
    {
        $this->data=[];
        $params = array(); // params digunakan untuk cache server
        $params['id'] = Auth::user()->id;
  
        $query = DB::table('users AS a')
          ->select([
            'a.id',
            'a.name',
            'a.email',
            'a.email_verified_at',
            'a.password',
            'a.remember_token',
            'a.created_at',
            'a.updated_at',
            'a.phone',
            'a.wa_available',
            'a.address_id',
            'a.address_detail',
            'a.post_code',
            'a.latitude',
            'a.longitude',
            'a.profile_image',
            'a.is_verified',
            'a.is_active',
            'a.role_id',
            'a.last_login',
            'a.sosmed_facebook',
            'a.sosmed_instagram',
            'a.sosmed_tiktok',
            'a.sosmed_youtube',
            'a.bio',
            DB::raw('CASE WHEN a.address_id = 1 THEN addr2.name ELSE CONCAT(addr1.name, ", ", addr2.name) END AS location'), 
          ])
          ->leftjoin('t_m_address AS addr1', 'addr1.id', '=', 'a.address_id')
          ->leftJoin('t_m_address AS addr2', 'addr2.id', '=', 'addr1.city_id')        
        //   ->where('a.status', '=', 1)
          ->where(DB::raw("a.id"), '=', $params['id'])
        ;

        // return $query->toSql();
        $getData = SqlHelpers::simpleSelectORMFirst($query, $params);
        $this->data["data"] = $getData["data"] ?? [];

        // $this->data["user_path"] = env('PATH_USER');
        // if ($this->data["data"]) $this->data["seller_join"] = Helpers::myFormatDate($this->data["data"]->seller_created_at);
        
        // return $this->data["data"];
        // return $this->data;

        return view('profile.myprofile')->with($this->data);
    }

    public function myProfileEdit(Request $request)
    {
        $this->data=[];
        $params = array(); // params digunakan untuk cache server
        $params['id'] = Auth::user()->id;
  
        $query = DB::table('users AS a')
          ->select([
            'a.id',
            'a.name',
            'a.email',
            'a.email_verified_at',
            'a.password',
            'a.remember_token',
            'a.created_at',
            'a.updated_at',
            'a.phone',
            'a.wa_available',
            'a.address_id',
            'a.address_detail',
            'a.post_code',
            'a.latitude',
            'a.longitude',
            'a.profile_image',
            'a.is_verified',
            'a.is_active',
            'a.role_id',
            'a.last_login',
            'a.sosmed_facebook',
            'a.sosmed_instagram',
            'a.sosmed_tiktok',
            'a.sosmed_youtube',
            'a.bio',
            DB::raw('CASE WHEN a.address_id = 1 THEN addr2.name ELSE CONCAT(addr1.name, ", ", addr2.name) END AS location'), 
            'addr1.id AS district_id',
            'addr1.name AS district_name',
            'addr2.id AS city_id',
            'addr2.name AS city_name',
            'addr3.id AS province_id',
            'addr3.name AS province_name',
          ])
          ->leftjoin('t_m_address AS addr1', 'addr1.id', '=', 'a.address_id')
          ->leftJoin('t_m_address AS addr2', 'addr2.id', '=', 'addr1.city_id')        
          ->leftJoin('t_m_address AS addr3', 'addr3.id', '=', 'addr1.province_id')        
        //   ->where('a.status', '=', 1)
          ->where(DB::raw("a.id"), '=', $params['id'])
        ;

        // return $query->toSql();
        $getData = SqlHelpers::simpleSelectORMFirst($query, $params);
        $this->data["data"] = $getData["data"] ?? [];

        // $this->data["user_path"] = env('PATH_USER');
        // if ($this->data["data"]) $this->data["seller_join"] = Helpers::myFormatDate($this->data["data"]->seller_created_at);
        
        // return $this->data["data"];
        // return $this->data;

        return view('profile.myprofileedit')->with($this->data);
    }

}
