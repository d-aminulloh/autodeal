<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SqlHelpers;
use DB;
use Helpers;
use Auth;
use Session;
use Cookie;

class AdsController extends Controller
{
    private $data = [];
    public function adsSearch(Request $request, $category_slug, $search)
    {
        $this->data['category_slug'] = $category_slug;
        $this->data['autodealSearch'] = $search;
        $this->data['filter_active'] = "";

        if($category_slug != ""){
            $getFilter =SqlHelpers::simpleSelect("select a.filter from t_m_category_ads_config a inner join t_m_category_ads b on a.category_id = b.id where b.category_slug = ?", [$category_slug]);
            $filter = isset($getFilter["data"][0]) ? $getFilter["data"][0]->filter:"";
            $this->data['filter_active'] = $filter;
        }

        return view('item.search')->with($this->data);
    }

    public function adsDetail(Request $request, $id)
    {
        $this->data=[];
        $this->data['id'] = $id;

        $params = array(); // params digunakan untuk cache server
        $params['id'] = $id;

        if(Auth::user()){
            $params['user_id'] = Auth::user()->id;
        }  

        $query = DB::table('t_m_ads AS a')
          ->select([
            'a.id',
            DB::raw('md5(a.id) id2'),
            'a.title',
            'a.description',
            // 'a.ads_type_id',
            'l1.text AS ads_type_text',
            'l1.label AS ads_type_label',
            // 'a.condition_id',
            'l2.text AS condition_text',
            'l2.label AS condition_label',
            // 'a.duration_id',
            'l3.text AS duration_text',
            'l3.label AS duration_label',
            'a.price',
            'a.price_max',
            'a.category_id',
            'ct.category_name',
            'ctp.category_name as category_parent_name',
            'ct.category_slug',
            'ctp.category_slug as category_parent_slug',

            'u.name as seller_name',
            'u.phone as seller_phone',
            'u.wa_available',
            'u.profile_image as seller_profile_image',
            'u.bio as seller_bio',
            'u.created_at as seller_created_at',
            'u.sosmed_facebook as seller_sosmed_facebook',
            'u.sosmed_instagram as seller_sosmed_instagram',
            'u.sosmed_youtube as seller_sosmed_youtube',
            'u.sosmed_tiktok as seller_sosmed_tiktok',

            DB::raw('CASE WHEN a.address_id = 1 THEN addr2.name ELSE CONCAT(addr1.name, ", ", addr2.name) END AS location'), 
            'a.address_detail',

            // properti
            'a.building_area', // Luas Bangunan
            'a.surface_area', // Luas Tanah
            'a.bedroom_qty', // Kamar Tidur
            'a.bathroom_qty', // Kamar Mandi
            'a.floor', // Lantai
            'a.facility', // Fasilitas
            // 'a.certification_id', // Sertifikasi
            'l5.text AS certification_id_text', // Sertifikasi
            // 'a.seller_type_id', // Tipe Penjual
            'l4.text AS seller_type_id_property_text', // Tipe Penjual
            
            // mobil // motor
            // 'a.brand_id', // Merk
            'br.text as brand_id_text', // Merk
            // 'a.model_id', // Model
            'brm.text as model_id_text', // Model
            // 'a.transmission_id', // Transmisi Mobil
            'l6.text as transmission_id_car', // Transmisi Mobil
            // 'a.fuel_id', // Bahan Bakar Mobil
            'l7.text as fuel_id_car', // Bahan Bakar Mobil
            // 'a.body_type_id', // Tipe Bodi Mobil
            'l8.text as body_type_id_car', // Tipe Bodi Mobil
            'a.year', // Tahun
            'a.year_max', // Tahun
            'a.mileage', // Jarak Tempuh
            'a.engine_capacity', // Kapasitas Mesin
            // 'a.color_id', // Warna Kendaraan
            'l9.text as color_id_vehicle_text', // Warna Kendaraan
            // 'a.passenger_qty_id', // Jumlah Penumpang
            'l13.text as passenger_qty_id_text', // Jumlah Penumpang
            'l13.label as passenger_qty_id_label', // Jumlah Penumpang

            // 'a.transmission_id', // Transmisi Motor
            'l10.text as transmission_id_motorcycle', // Transmisi Motor
            // 'a.fuel_id', // Bahan Bakar Motor
            'l11.text as fuel_id_motorcycle', // Bahan Bakar Motor
            // 'a.body_type_id', // Tipe Bodi Motor
            'l12.text as body_type_id_motorcycle', // Tipe Bodi Motor

            //gadget
            // a.os_id = NULL,
            'l14.text as os_id_text', // OS
            'a.ram', // ram
            'a.storage',

            // 'a.job_type_id',
            'l15.text as job_type_id_text',
            // 'a.gender_id',
            'l16.text as gender_id_text',
            'a.service_id',


            // 'a.view_count',
            DB::raw('DATE_FORMAT(IFNULL(a.sundul_date, a.created_date), "%d/%m/%Y") AS created_date'),
            DB::raw('CASE WHEN IFNULL(a.image_cover, "") = "" THEN "" ELSE image_cover end as image_cover'),

            DB::raw('md5(a.seller_id) AS seller_id'), 
            DB::raw('IFNULL(fav.ads_id,0) AS is_fav'), 
          ])
          ->join('users AS u', 'u.id', '=', 'a.seller_id')
          ->join('t_m_address AS addr1', 'addr1.id', '=', 'a.address_id')
          ->leftJoin('t_m_address AS addr2', 'addr2.id', '=', 'addr1.city_id')
          ->join('t_m_category_ads AS ct', 'ct.id', '=', 'a.category_id')
          ->join('t_m_category_ads AS ctp', 'ctp.id', '=', 'ct.parent_id')
          ->leftJoin('t_m_ads_favorite AS fav', function ($join) use ($params) {
            $join->on('a.id', '=', 'fav.ads_id');
            $join->on('fav.user_id', '=', DB::raw("'".($params['user_id'] ?? "")."'"));
          })
          ->leftJoin('t_m_list AS l1', function ($join) {
              $join->on('l1.code', '=', DB::raw("'ads_type_id'"));
              $join->on('l1.id', '=', 'a.ads_type_id');
          })
          ->leftJoin('t_m_list AS l2', function ($join) {
              $join->on('l2.code', '=', DB::raw("'condition_id'"));
              $join->on('l2.id', '=', 'a.condition_id');
              $join->on('a.ads_type_id', '=', DB::raw('1'));
          })
          ->leftJoin('t_m_list AS l3', function ($join) {
              $join->on('l3.code', '=', DB::raw("'duration_id'"));
              $join->on('l3.id', '=', 'a.duration_id');
              $join->on('a.ads_type_id', '=', DB::raw('2'));
          })

          // brand model
          ->leftJoin('t_m_brand AS br', 'br.id', '=', 'a.brand_id')
          ->leftJoin('t_m_brand_model AS brm', 'brm.id', '=', 'a.model_id')

          // properti
          ->leftJoin('t_m_list AS l4', function ($join) {
              $join->on('l4.code', '=', DB::raw("'seller_type_id_property'"));
              $join->on('l4.id', '=', 'a.seller_type_id');
          })
          ->leftJoin('t_m_list AS l5', function ($join) {
              $join->on('l5.code', '=', DB::raw("'certification_id'"));
              $join->on('l5.id', '=', 'a.certification_id');
          })

          // mobil
          ->leftJoin('t_m_list AS l6', function ($join) {
              $join->on('l6.code', '=', DB::raw("'transmission_id_car'"));
              $join->on('l6.id', '=', 'a.transmission_id');
          })
          ->leftJoin('t_m_list AS l7', function ($join) {
              $join->on('l7.code', '=', DB::raw("'fuel_id_car'"));
              $join->on('l7.id', '=', 'a.fuel_id');
              $join->on('ct.parent_id', '=', DB::raw('2'));
          })
          ->leftJoin('t_m_list AS l8', function ($join) {
              $join->on('l8.code', '=', DB::raw("'body_type_id_car'"));
              $join->on('l8.id', '=', 'a.body_type_id');
              $join->on('ct.parent_id', '=', DB::raw('2'));
          })
          ->leftJoin('t_m_list AS l9', function ($join) {
              $join->on('l9.code', '=', DB::raw("'color_id_vehicle'"));
              $join->on('l9.id', '=', 'a.color_id');
              $join->on('ct.parent_id', '=', DB::raw('2'));
          })
          ->leftJoin('t_m_list AS l13', function ($join) {
              $join->on('l13.code', '=', DB::raw("'passenger_qty_id'"));
              $join->on('l13.id', '=', 'a.passenger_qty_id');
              $join->on('ct.parent_id', '=', DB::raw('2'));
          })

          // motor
          ->leftJoin('t_m_list AS l10', function ($join) {
              $join->on('l10.code', '=', DB::raw("'transmission_id_motorcycle'"));
              $join->on('l10.id', '=', 'a.transmission_id');
              $join->on('ct.parent_id', '=', DB::raw('3'));
          })
          ->leftJoin('t_m_list AS l11', function ($join) {
              $join->on('l11.code', '=', DB::raw("'fuel_id_motorcycle'"));
              $join->on('l11.id', '=', 'a.fuel_id');
              $join->on('ct.parent_id', '=', DB::raw('3'));
          })
          ->leftJoin('t_m_list AS l12', function ($join) {
              $join->on('l12.code', '=', DB::raw("'body_type_id_motorcycle'"));
              $join->on('l12.id', '=', 'a.body_type_id');
              $join->on('ct.parent_id', '=', DB::raw('3'));
          })

          // gadget
          ->leftJoin('t_m_list AS l14', function ($join) {
              $join->on('l14.code', '=', DB::raw("'os_id'"));
              $join->on('l14.id', '=', 'a.os_id');
          })
          ->leftJoin('t_m_list AS l15', function ($join) {
              $join->on('l15.code', '=', DB::raw("'job_type_id'"));
              $join->on('l15.id', '=', 'a.job_type_id');
          })
          ->leftJoin('t_m_list AS l16', function ($join) {
            $join->on('l16.code', '=', DB::raw("'gender_loker'"));
            $join->on('l16.id', '=', 'a.gender_id');
          })
        
        //   ->where('a.status', '=', 1)
          ->where(DB::raw("md5(a.id)"), '=', $params['id'])
        ;

        // return $query->toSql();
        $getData = SqlHelpers::simpleSelectORMFirst($query, $params);
        $this->data["data"] = $getData["data"] ?? [];

        // getimage
        unset($params['user_id']);
        $getImage = SqlHelpers::simpleSelect("select id, image, created_date from t_m_ads_image where md5(ads_id) = :id", $params);
        $this->data["image"] = count($getImage["data"]) > 0 ? $getImage["data"] : [];
        $this->data["image_path"] = env('PATH_ADS');
        $this->data["image_total"] = count($getImage["data"]) + 1;

        $this->data["service_id"] = [];
        if(isset($this->data["data"]->category_id) && $this->data["data"]->category_id == 204){
            $this->data["service_id"] = SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'service_id_car'", []);
        } else if(isset($this->data["data"]->category_id) && $this->data["data"]->category_id == 304){
            $this->data["service_id"] = SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'service_id_motorcycle'", []);
        } else if(isset($this->data["data"]->category_id) && in_array($this->data["data"]->category_id, [101,102,103,104,105,106,107])){
            $this->data["service_id"] = SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'service_id_property'", []);
        }

        $user_id = Auth::user() ? Auth::user()->id : 0;
        $session_id = Session::getId();
        $cookie_name = 'autodeal_view_' . $params['id'];
        $cookie_value = cookie($cookie_name);
        if (empty($cookie_value) || $cookie_value != $user_id . "_" . $session_id) {
            $update = DB::table('t_m_ads')->where(DB::raw("md5(id)"), '=', $params['id'])->increment('view_count');
            Cookie::queue($cookie_name, $user_id . "_" . $session_id, 60 * 60 * 24 * 30);
        }

        // $this->data["user_path"] = env('PATH_USER');
        // if ($this->data["data"]) $this->data["seller_join"] = Helpers::myFormatDate($this->data["data"]->seller_created_at);
        
        // return $this->data["data"];
        // return $this->data;

        return view('item.detail')->with($this->data);
    }

}
