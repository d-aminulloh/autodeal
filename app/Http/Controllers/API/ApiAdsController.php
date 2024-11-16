<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use ResponseService;
use SqlHelpers;
use Auth;
use File;
use Intervention\Image\Facades\Image;

class ApiAdsController extends Controller
{

    public function getItemLanding(Request $request){
      $limit = SqlHelpers::setLimitParams($request->input('limit'), env("DEFAULT_LANDING_ITEM"));
      $current_page = intval($request->input('page')) < 1 ? 1:intval($request->input('page'));
      $offset = 0 + ($current_page - 1) * $limit;
      $location = intval($request->input('location')) < 1 ? 1:intval($request->input('location')); // 1 = default indonesia
      $sortby_query = SqlHelpers::setItemSortByParams($request->input('sortby') ?? '');
    

      $params = array();
      $params['path'] = env('PATH_ADS_THUMBS');
      $params['location'] = $location;

      $favid = Auth::user() ? Auth::user()->id:"0";

      $query = "  
        select a.id as id, 
          md5(a.id) id2,
          a.ads_type_id,
          l1.text as ads_type_text,
          a.condition_id,
          l2.text as condition_text,
          a.duration_id,
          l3.text as duration_text,
          a.quick_specification,
          a.view_count,
          a.title, 
          a.price, 
          a.price_max, 
          fav.ads_id as is_fav,
          ct.category_name,
          DATE_FORMAT(IFNULL(a.sundul_date, a.created_date),'%Y-%m-%d') as created_date, 
          CASE WHEN a.address_id = 1 THEN addr2.name ELSE concat(addr1.name, ', ', addr2.name) END as location,
          CASE WHEN IFNULL(a.image_cover, '') = ''  THEN '' ELSE concat(:path, image_cover) END as image_cover
        from 
          t_m_ads a
          inner join t_m_address addr1 on addr1.id= a.address_id
          inner join t_m_address addr2 on addr2.id= addr1.city_id
          inner join t_m_category_ads ct on ct.id= a.category_id
          left join t_m_ads_favorite fav on fav.ads_id= a.id and fav.user_id = ".$favid."
          left join t_m_list l1 on l1.code = 'ads_type_id' and l1.id = a.ads_type_id
          left join t_m_list l2 on l2.code = 'condition_id' and l2.id = a.condition_id and a.ads_type_id = 1
          left join t_m_list l3 on l3.code = 'duration_id' and l3.id = a.duration_id and a.ads_type_id = 2
        where 1=1
        and (
          addr1.id = :location
          or addr1.city_id = :location
          or addr1.province_id = :location
          or addr1.country_id = :location
        )
        and a.status = '1'
        order by $sortby_query
        limit :offset, :limit
      ";

      $query_count = "  
        select count(1) as cnt
        from 
          t_m_ads a
          inner join t_m_address addr1 on addr1.id= a.address_id
          inner join t_m_address addr2 on addr2.id= addr1.city_id
        where 1=1
        and (
          addr1.id = :location
          or addr1.city_id = :location
          or addr1.province_id = :location
          or addr1.country_id = :location
        )
        and a.status = '1'
      ";

      return SqlHelpers::selectAndCountResult($query, $query_count, $params, $current_page, $limit, $offset);
    }

    public function getMyItemLanding(Request $request){
        $validator = Validator::make($request->all(), [
            'parent' => 'nullable',
        ]);

        if ($validator->fails()) return ResponseService::badRequest($validator->messages());      

        $params = array();
        $params['path'] = env('PATH_ADS_THUMBS');
        $params['seller_id'] = $request->user()->id;

        $query = "  
          select a.id as id, 
            a.ads_type_id,
            l1.text as ads_type_text,
            a.condition_id,
            l2.text as condition_text,
            a.duration_id,
            l3.text as duration_text,
            a.quick_specification,
            a.view_count,
            a.title, 
            a.price, 
            a.price_max, 
            ct.category_name,
            DATE_FORMAT(IFNULL(a.sundul_date, a.created_date),'%Y-%m-%d') as created_date, 
            CASE WHEN a.address_id = 1 THEN addr2.name ELSE concat(addr1.name, ', ', addr2.name) END as location,
            CASE WHEN IFNULL(a.image_cover, '') = ''  THEN '' ELSE concat(:path, image_cover) END as image_cover
          from 
            t_m_ads a
            inner join t_m_address addr1 on addr1.id= a.address_id
            inner join t_m_address addr2 on addr2.id= addr1.city_id
            inner join t_m_category_ads ct on ct.id= a.category_id
            left join t_m_list l1 on l1.code = 'ads_type_id' and l1.id = a.ads_type_id
            left join t_m_list l2 on l2.code = 'condition_id' and l2.id = a.condition_id and a.ads_type_id = 1
            left join t_m_list l3 on l3.code = 'duration_id' and l3.id = a.duration_id and a.ads_type_id = 2
          where seller_id = :seller_id and a.status = '1'
          order by IFNULL(a.updated_date, IFNULL(a.sundul_date, a.created_date)) desc
          limit 0, 2
        ";

        return SqlHelpers::simpleSelectResult($query, $params);
    }

    public function getMyFavorite(Request $request){
      $limit = SqlHelpers::setLimitParams($request->input('limit'), 1000);
      $current_page = intval($request->input('page')) < 1 ? 1:intval($request->input('page'));
      $offset = 0 + ($current_page - 1) * $limit;
      $sortby_query = SqlHelpers::setItemSortByParams();

      $params = array();
      $params['path'] = env('PATH_ADS_THUMBS');

      $query = "  
        select a.id as id, 
          md5(a.id) id2,
          a.ads_type_id,
          l1.text as ads_type_text,
          a.condition_id,
          l2.text as condition_text,
          a.duration_id,
          l3.text as duration_text,
          a.quick_specification,
          a.view_count,
          a.title, 
          a.price, 
          a.price_max, 
          fav.ads_id as is_fav,
          ct.category_name,
          DATE_FORMAT(IFNULL(a.sundul_date, a.created_date),'%Y-%m-%d') as created_date, 
          CASE WHEN a.address_id = 1 THEN addr2.name ELSE concat(addr1.name, ', ', addr2.name) END as location,
          CASE WHEN IFNULL(a.image_cover, '') = ''  THEN '' ELSE concat(:path, image_cover) END as image_cover
        from 
          t_m_ads a
          inner join t_m_address addr1 on addr1.id= a.address_id
          inner join t_m_address addr2 on addr2.id= addr1.city_id
          inner join t_m_category_ads ct on ct.id= a.category_id
          inner join t_m_ads_favorite fav on fav.ads_id= a.id and fav.user_id = ".Auth::user()->id."
          left join t_m_list l1 on l1.code = 'ads_type_id' and l1.id = a.ads_type_id
          left join t_m_list l2 on l2.code = 'condition_id' and l2.id = a.condition_id and a.ads_type_id = 1
          left join t_m_list l3 on l3.code = 'duration_id' and l3.id = a.duration_id and a.ads_type_id = 2
        where 1=1
        and a.status = '1'
        order by $sortby_query
        limit :offset, :limit
      ";

      $query_count = "  
        select count(1) as cnt
        from 
          t_m_ads a
          inner join t_m_address addr1 on addr1.id= a.address_id
          inner join t_m_address addr2 on addr2.id= addr1.city_id
          inner join t_m_ads_favorite fav on fav.ads_id= a.id and fav.user_id = ".Auth::user()->id."
        where 1=1
        and a.status = '1'
      ";

      return SqlHelpers::selectAndCountResult($query, $query_count, $params, $current_page, $limit, $offset);
    }

    public function getItem(Request $request){
        $limit = SqlHelpers::setLimitParams($request->input('limit'), env("DEFAULT_LANDING_ITEM"));
        $current_page = intval($request->input('page')) < 1 ? 1:intval($request->input('page'));
        $offset = 0 + ($current_page - 1) * $limit;
        $location = intval($request->input('location')) < 1 ? 1:intval($request->input('location')); // 1 = default indonesia
        // $sortby_query = SqlHelpers::setItemSortByParams($request->input('sortby') ?? '');

        $sortby = $request->input('sortby') ?? "";

        $params = array();
        $params['path'] = env('PATH_ADS_THUMBS');
      
        // parameter with_sold_item
        $status_where_query = "and a.status = '1'";
        if(intval($request->input('with_sold_item')) == 1) $status_where_query = "and a.status IN ('1','3')";
        // prepare category
        // $category = intval($request->input('category'));
        // if(intval($category) < 1) $category = '';
        $category = $request->input('category') ?? "";
        $category_where_query = '';
        if($category) {
          $category_where_query = "and ( ct.category_slug = :category or ct.parent_id = (SELECT id FROM t_m_category_ads where category_slug = :category limit 0,1))";
          $params['category'] = $category;
        }

        // prepare search
        $search = $request->input('search') ?? '';
        $search_where_query = '';
        if($search) {
          $search = "%${search}%";
          $search_where_query = "and a.title like :search";
          $params['search'] = $search;
        }

        // check if nearest sort by
        $latitude = floatval($request->input('latitude')); if($latitude == 0 || $sortby != 'nearest') $latitude = '';
        $longitude = floatval($request->input('longitude')); if($longitude == 0 || $sortby != 'nearest') $longitude = '';
        $nearest_query = '';
        if($latitude != '' && $longitude != '') {
          $nearest_query = ", (6371 * acos(cos(radians(:latitude)) * cos(radians(addr1.latitude)) * cos(radians(addr1.longitude) - radians(:longitude)) + sin(radians(:latitude)) * sin(radians(addr1.latitude)))) AS distance";
          $params['latitude'] = $latitude;
          $params['longitude'] = $longitude;
        }
        
        // sort by
        $sortby_query = SqlHelpers::setItemSortByParams($sortby, ($nearest_query != ''));

        $params['location'] = $location;



        //extra filter
        $extra_filter_query = "";
        //brandc
        $brandc = $request->input('brandc') ?? "";
        if(!empty($brandc)) {
          $secure_arr = explode(',', $brandc);
          for ($i=0; $i < count($secure_arr); $i++)  
            $secure_arr[$i] = DB::connection()->getPdo()->quote($secure_arr[$i]);
          
          $brandc = implode(',', $secure_arr);
          $extra_filter_query = " and a.brand_id IN ($brandc) ";
        }

        $query = "  
          select a.id as id, 
            md5(a.id) id2,
            a.ads_type_id,
            l1.text as ads_type_text,
            a.condition_id,
            l2.text as condition_text,
            a.duration_id,
            l3.text as duration_text,
            a.quick_specification,
            a.view_count,
            a.title, 
            a.price, 
            a.price_max, 
            ct.category_name,
            DATE_FORMAT(IFNULL(a.sundul_date, a.created_date),'%Y-%m-%d') as created_date, 
            CASE WHEN a.address_id = 1 THEN addr2.name ELSE concat(addr1.name, ', ', addr2.name) END as location,
            CASE WHEN IFNULL(a.image_cover, '') = ''  THEN '' ELSE concat(:path, image_cover) END as image_cover
            ${nearest_query}
          from 
            t_m_ads a
            inner join t_m_address addr1 on addr1.id= a.address_id
            inner join t_m_address addr2 on addr2.id= addr1.city_id
            inner join t_m_category_ads ct on ct.id = a.category_id
            left join t_m_list l1 on l1.code = 'ads_type_id' and l1.id = a.ads_type_id
            left join t_m_list l2 on l2.code = 'condition_id' and l2.id = a.condition_id and a.ads_type_id = 1
            left join t_m_list l3 on l3.code = 'duration_id' and l3.id = a.duration_id and a.ads_type_id = 2
          where 1=1
          and (
            addr1.id = :location
            or addr1.city_id = :location
            or addr1.province_id = :location
            or addr1.country_id = :location
          )
          $status_where_query
          $category_where_query
          $search_where_query
          $extra_filter_query
          order by $sortby_query
          limit :offset, :limit
        ";

        $query_count = "  
          select count(1) as cnt
          from 
            t_m_ads a
            inner join t_m_address addr1 on addr1.id= a.address_id
            inner join t_m_address addr2 on addr2.id= addr1.city_id
            inner join t_m_category_ads ct on ct.id = a.category_id
          where 1=1
          and (
            addr1.id = :location
            or addr1.city_id = :location
            or addr1.province_id = :location
            or addr1.country_id = :location
          )
          $status_where_query
          $category_where_query
          $search_where_query
          $extra_filter_query
        ";

        $params_count = $params; // handling error unused params
        unset($params_count["latitude"]);
        unset($params_count["longitude"]);

        return SqlHelpers::selectAndCountResult($query, $query_count, $params, $current_page, $limit, $offset, $params_count);
    }

    private $query;
    private $params;
    public function getItem2(Request $request) { // versi orm lv karena support where in
        $limit = SqlHelpers::setLimitParams($request->input('limit'));
        $current_page = intval($request->input('page')) < 1 ? 1:intval($request->input('page'));
        $offset = 0 + ($current_page - 1) * $limit;
        $location = intval($request->input('location')) < 1 ? 1:intval($request->input('location')); // 1 = default indonesia
        $sortby = $request->input('sortby') ?? "";

        $this->params = array(); // params digunakan untuk cache server
        $this->params['location'] = $location;
        $this->params["limit"] = intval($limit);
        $this->params["offset"] = intval($offset);

        $select_array = [
          'a.id',
          DB::raw('md5(a.id) id2'),
          'a.brand_id',
          'a.ads_type_id',
          'l1.text AS ads_type_text',
          'a.condition_id',
          'l2.text AS condition_text',
          'a.duration_id',
          'l3.text AS duration_text',
          'a.quick_specification',
          'a.view_count',
          'a.title',
          'a.price',
          'a.price_max', 
          'ct.category_name', 
          DB::raw('fav.ads_id as is_fav'),
          DB::raw('DATE_FORMAT(IFNULL(a.sundul_date, a.created_date), "%Y-%m-%d") AS created_date'),
          DB::raw('CASE WHEN a.address_id = 1 THEN addr2.name ELSE CONCAT(addr1.name, ", ", addr2.name) END AS location'), 
          DB::raw('CASE WHEN IFNULL(a.image_cover, "") = "" THEN "" ELSE CONCAT('.DB::connection()->getPdo()->quote(env('PATH_ADS_THUMBS')).', image_cover) END AS image_cover'),
        ];

        $favid = Auth::user() ? Auth::user()->id:"0";

        $this->query = DB::table('t_m_ads AS a')
          ->join('t_m_address AS addr1', 'addr1.id', '=', 'a.address_id')
          ->leftJoin('t_m_address AS addr2', 'addr2.id', '=', 'addr1.city_id')
          ->join('t_m_category_ads AS ct', 'ct.id', '=', 'a.category_id')
          ->leftJoin('t_m_ads_favorite AS fav', function ($join) use ($favid) {
              $join->on('fav.user_id', '=', DB::raw($favid));
              $join->on('fav.ads_id', '=', 'a.id');
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
          ->where('a.status', '=', 1)
          ->where(function ($subquery) use ($location) {
              $subquery->where('addr1.id', '=', $location)
                  ->orWhere('addr1.city_id', '=', $location)
                  ->orWhere('addr1.province_id', '=', $location)
                  ->orWhere('addr1.country_id', '=', $location);
        });

      
        // prepare category
        $category = $request->input('category') ?? "";
        if($category) {
          $this->query->where(function ($subquery) use ($category) {
              $subquery->where('ct.category_slug', '=', $category)
                  ->orWhere('ct.parent_id', '=', DB::table('t_m_category_ads')->where('category_slug', '=', $category)->limit(1)->value('id'));
          });
          $this->params['category'] = $category;
        }

        // prepare search
        $search = $request->input('search') ?? '';
        if($search) {
          $this->query->where('a.title', 'like', '%' . $search . '%');
          $this->params['search'] = $search;
        }

        // check if nearest sort by
        $latitude = floatval($request->input('latitude')); if($latitude == 0 || $sortby != 'nearest') $latitude = '';
        $longitude = floatval($request->input('longitude')); if($longitude == 0 || $sortby != 'nearest') $longitude = '';
        $nearest_query = "";
        if($latitude != '' && $longitude != '') {
          // tidak dibungkus lagi, harusnya sudah aman karena sudah pakai floatval
          $nearest_query = "(6371 * acos(cos(radians($latitude)) * cos(radians(addr1.latitude)) * cos(radians(addr1.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(addr1.latitude)))) AS distance";
          $select_array[] = DB::raw($nearest_query);
          $this->params['latitude'] = $latitude;
          $this->params['longitude'] = $longitude;
        }

        // sort by
        $sortby_query = SqlHelpers::setItemSortByParams($sortby, ($nearest_query != ''));


        // seller only
        $seller = $request->input('seller') ?? ""; if(!empty($seller)) { $this->query->where(DB::raw("md5(a.seller_id)"), '=', $seller); }


        //extra filter
        //price
        $pmin = $request->input('pmin') ?? "";
        $pmax = $request->input('pmax') ?? "";
        $this->buildQueryWhereMinMax("a.price", "pmin", $pmin, "pmax", $pmax);

        // wherein
        // mobil
        $brandc = $request->input('brandc') ?? ""; if(!empty($brandc)) { $this->buildQueryWhereIn("a.brand_id", "brandc", $brandc); }
        $modc = $request->input('modc') ?? ""; if(!empty($modc)) { $this->buildQueryWhereIn("a.model_id", "modc", $modc); }
        $transc = $request->input('transc') ?? ""; if(!empty($transc)) { $this->buildQueryWhereIn("a.transmission_id", "transc", $transc); }
        $fuelc = $request->input('fuelc') ?? ""; if(!empty($fuelc)) { $this->buildQueryWhereIn("a.fuel_id", "fuelc", $fuelc); }
        $engc = $request->input('engc') ?? ""; if(!empty($engc)) { $this->buildQueryWhereInMinMax("a.engine_capacity", "engine_capacity_id_car" , "engc", $engc); }
        $bodyc = $request->input('bodyc') ?? ""; if(!empty($bodyc)) { $this->buildQueryWhereIn("a.body_type_id", "bodyc", $bodyc); }
        $passec = $request->input('passec') ?? ""; if(!empty($passec)) { $this->buildQueryWhereIn("a.passenger_qty_id", "passec", $passec); }
        $colv = $request->input('colv') ?? ""; if(!empty($colv)) { $this->buildQueryWhereIn("a.color_id", "colv", $colv); }
        $sellv = $request->input('sellv') ?? ""; if(!empty($sellv)) { $this->buildQueryWhereIn("a.seller_type_id", "sellv", $sellv); }
        $atype = $request->input('atype') ?? ""; if(!empty($atype)) { $this->buildQueryWhereIn("a.ads_type_id", "atype", $atype); }
        $acond = $request->input('acond') ?? ""; if(!empty($acond)) { $this->buildQueryWhereIn("a.condition_id", "acond", $acond); }
        $adur = $request->input('adur') ?? ""; if(!empty($adur)) { $this->buildQueryWhereIn("a.duration_id", "adur", $adur); }

        //motor
        $brandm = $request->input('brandm') ?? ""; if(!empty($brandm)) { $this->buildQueryWhereIn("a.brand_id", "brandm", $brandm); }
        $modm = $request->input('modm') ?? ""; if(!empty($modm)) { $this->buildQueryWhereIn("a.model_id", "modm", $modm); }
        $transm = $request->input('transm') ?? ""; if(!empty($transm)) { $this->buildQueryWhereIn("a.transmission_id", "transm", $transm); }
        $engm = $request->input('engm') ?? ""; if(!empty($engm)) { $this->buildQueryWhereInMinMax("a.engine_capacity", "engine_capacity_id_motorcycle", "engm", $engm); }
        $bodym = $request->input('bodym') ?? ""; if(!empty($bodym)) { $this->buildQueryWhereIn("a.body_type_id", "bodym", $bodym); }
        $fuelm = $request->input('fuelm') ?? ""; if(!empty($fuelm)) { $this->buildQueryWhereIn("a.fuel_id", "fuelm", $fuelm); }

        //property
        $bedr = $request->input('bedr') ?? ""; if(!empty($bedr)) { $this->buildQueryWhereInMinMax("a.bedroom_qty", "bedroom_id", "bedr", $bedr); }
        $bath = $request->input('bath') ?? ""; if(!empty($bath)) { $this->buildQueryWhereInMinMax("a.bathroom_qty", "bathroom_id", "bath", $bath); }
        $floor = $request->input('floor') ?? ""; if(!empty($floor)) { $this->buildQueryWhereInMinMax("a.floor", "floor_id", "floor", $floor); }
        $cert = $request->input('cert') ?? ""; if(!empty($cert)) { $this->buildQueryWhereIn("a.certification_id", "cert", $cert); }
        $sellp = $request->input('sellp') ?? ""; if(!empty($sellp)) { $this->buildQueryWhereIn("a.seller_type_id", "sellp", $sellp); }

        //gadget
        $brandg = $request->input('brandg') ?? ""; if(!empty($brandg)) { $this->buildQueryWhereIn("a.brand_id", "brandg", $brandg); }
        $os = $request->input('os') ?? ""; if(!empty($os)) { $this->buildQueryWhereIn("a.os_id", "os", $os); }
        $ram = $request->input('ram') ?? ""; if(!empty($ram)) { $this->buildQueryWhereInMinMax("a.ram", "ram_id", "ram", $ram); }
        $stor = $request->input('stor') ?? ""; if(!empty($stor)) { $this->buildQueryWhereInMinMax("a.storage", "storage_id", "stor", $stor); }

        // pet and job
        $gen = $request->input('gen') ?? ""; if(!empty($gen)) { $this->buildQueryWhereIn("a.gender_id", "gen", $gen); }
        $genp = $request->input('genp') ?? ""; if(!empty($genp)) { $this->buildQueryWhereIn("a.gender_id", "genp", $genp); }
        $genp = $request->input('jobt') ?? ""; if(!empty($jobt)) { $this->buildQueryWhereIn("a.job_type_id", "jobt", $jobt); }

        $ymin = $request->input('ymin') ?? "";
        $ymax = $request->input('ymax') ?? "";
        $this->buildQueryWhereMinMax("a.year", "ymin", $ymin, "ymax", $ymax);

        $ybmin = $request->input('ybmin') ?? "";
        $ybmax = $request->input('ybmax') ?? "";
        if(!empty($ybmin) && !empty($ybmax)) {
        $this->query->where(function ($subquery) use ($ybmin, $ybmax) {
            $subquery->whereBetween(DB::raw(DB::connection()->getPdo()->quote($ybmin)), array(DB::raw('a.year'), DB::raw('a.year_max')))
                     ->orWhereBetween(DB::raw(DB::connection()->getPdo()->quote($ybmax)), array(DB::raw('a.year'), DB::raw('a.year_max'))); 
          });
          $this->params['ybmin'] = $ybmin;
          $this->params['ybmax'] = $ybmax;
        }
        else if(!empty($ybmin)) {
          $this->query->whereBetween(DB::raw(DB::connection()->getPdo()->quote($ybmin)),array(DB::raw('a.year'), DB::raw('a.year_max')));
          $this->params['ybmin'] = $ybmin;
        }
        else if(!empty($ybmax)) {
          $this->query->whereBetween(DB::raw(DB::connection()->getPdo()->quote($ybmax)), array(DB::raw('a.year'), DB::raw('a.year_max')));
          $this->params['ybmax'] = $ybmax;
        }


      return SqlHelpers::selectAndCountResultORM($this->query, $select_array, $sortby_query, $current_page, $limit, $offset, $this->params);
    }

    public function addMyFavorite(Request $request){
      $validator = Validator::make($request->all(), [
          'ads_id' => 'required',
      ]);
      if ($validator->fails()) return ResponseService::badRequest($validator->messages());
      $input = $request->all();

      $this->params["ads_id"] = $input["ads_id"];
      $this->params["user_id"] = Auth::user()->id;

      //cek iklan sendiri
      $cek = SqlHelpers::simpleSelect("select id from t_m_ads where md5(id) = :ads_id and seller_id = :user_id", $this->params);
      if(count($cek["data"]) > 0 ) {
        return ResponseService::notSuccess([], "tidak dapat menambahkan iklan sendiri ke favorit.");
      }

      return SqlHelpers::simpleInsertResult("insert into t_m_ads_favorite(ads_id,user_id) values((select id from t_m_ads where md5(id) = :ads_id), :user_id) ON DUPLICATE KEY UPDATE created_date = created_date", $this->params);
    }

    public function removeMyFavorite(Request $request){
      $validator = Validator::make($request->all(), [
        'ads_id' => 'required',
      ]);
      if ($validator->fails()) return ResponseService::badRequest($validator->messages());
      $input = $request->all();

      $this->params["ads_id"] = $input["ads_id"];
      $this->params["user_id"] = Auth::user()->id;
      return SqlHelpers::simpleInsertResult("delete from t_m_ads_favorite where md5(ads_id)=:ads_id and user_id=:user_id", $this->params);
    }

    function buildExtraQueryOnly($code, $field){
      $newExtra = $code ?? "";
      if(!empty($newExtra)) {
        $secure_arr = explode(',', $newExtra);
        for ($i=0; $i < count($secure_arr); $i++)  
          $secure_arr[$i] = DB::connection()->getPdo()->quote($secure_arr[$i]);
        
        $newExtra = implode(',', $secure_arr);
        return " and $field IN ($newExtra) ";
      }
      return "";
    }

    function buildQueryWhereIn($field, $filtername, $value){
      $this->query->whereIn($field, explode(',', $value)); $this->params[$filtername] = $value;
    }

    function buildQueryWhereInMinMax($field, $filter_code, $filtername, $value){
      $getFilterAttr = SqlHelpers::simpleSelect("SELECT id, min, max FROM t_m_list where code = '$filter_code' ".$this->buildExtraQueryOnly($value, 'id'), []);
      if(count($getFilterAttr["data"]) > 0 ) {
        $this->params[$filtername] = $value; 

        $this->query->where(function ($subquery) use ($field, $getFilterAttr){
          $first = true;
          foreach($getFilterAttr["data"] as $key => $value) {
            $min = $value->min;
            $max = $value->max;
            if($first){
              $first = false;
              if(!empty($min) && !empty($max)) $subquery->whereBetween($field, [$min, $max]);
              else if(!empty($min)) $subquery->where($field, ">=", $min);
              else if(!empty($max)) $subquery->where($field, "<=", $max);
            } else {
              if(!empty($min) && !empty($max)) $subquery->orwhereBetween($field, [$min, $max]);
              else if(!empty($min)) $subquery->orwhere($field, ">=", $min);
              else if(!empty($max)) $subquery->orwhere($field, "<=", $max);
            }
          }
        });
      }
    }

    function buildQueryWhereMinMax($field, $filter_code_min, $min, $filter_code_max, $max) {
      if(!empty($min)) {
        $this->query->where($field, '>=', $min);
        $this->params[$filter_code_min] = $min;
      }

      if(!empty($max)) {
        $this->query->where($field, '<=', $max);
        $this->params[$filter_code_max] = $max;
      }
    }

    function create(Request $request)
    {
      $messages = [
        'imgUpload.required' => 'Upload foto minimal 1 foto.',
      ];

      $validator = Validator::make($request->all(), [
        'title' => 'required|max:150',
        'category' => 'required',
        'category_id' => 'required',
        'ads_type_id' => 'required_unless:category_id,1101,1102',
        'duration_id' => 'required_if:ads_type_id,2',
        'condition_id' => 'required_if:ads_type_id,1',
        'price' => 'required_unless:category_id,1101|numeric',
        'gaji' => 'required_if:category_id,1102|numeric',
        'gaji_max' => 'required_if:category_id,1102|numeric',
        'description' => 'required|max:5000',
        'province_id' => 'required',
        'city_id' => 'required',
        'address_id' => 'required',
        'address_detail' => 'required|max:250',
        'imgUpload' => 'required|array|max:15',

        //mobil motor
        'brand_id' => 'required_if:category_id,204,304,403,404,405,406',
        'model_id' => 'required_if:category_id,204,304',
        'year' => 'nullable|numeric',
        'mileage' => 'nullable|numeric',
        'transmission_id' => 'required_if:category_id,204,304',
        'fuel_id' => 'required_if:category_id,204,304',
        'engine_capacity' => 'nullable|numeric',
        'passenger_qty_id' => 'nullable|numeric',
        'body_type_id' => 'nullable',
        'color_id' => 'nullable',
        'seller_type_id' => 'required_if:category_id,204,304',
        'service_id' => 'nullable',

        // gadget
        // 'brand_id' => 'required_if:category_id,403,404,405,406',
        'os_id' => 'required_if:category_id,403,404,405,406',
        'ram' => 'nullable|numeric',
        'storage' => 'nullable|numeric',
        // 'year' => 'nullable',

        // properti
        'building_area' => 'required_if:category_id,101,102,103,104,105,106,107|numeric',
        'surface_area' => 'required_if:category_id,101,102,103,104,105,106,107|numeric',
        'bedroom_qty' => 'required_if:category_id,101,102,103,104,105,106,107|numeric',
        'bathroom_qty' => 'required_if:category_id,101,102,103,104,105,106,107|numeric',
        'floor' => 'required_if:category_id,101,102,103,104,105,106,107|numeric',
        'certification_id' => 'nullable',
        'seller_type_id' => 'nullable',
        // 'service_id' => 'nullable',

        //peliharaan // loker
        'gender_id' => 'nullable',

        //loker
        'job_type_id' => 'required_if:category_id,1101',
        'year_max' => 'nullable|numeric',

      ], $messages);

      if ($validator->fails()) return ResponseService::notSuccess($validator->messages(), 'Gagal menambahkan iklan.');
      $input = $request->all();

      $this->params['title'] = $input['title'];
      // $this->params['category'] = $input['category'];
      $this->params['category_id'] = $input['category_id'];
      if(isset($input['ads_type_id'])) $this->params['ads_type_id'] = $input['ads_type_id']; // $this->params['ads_type_id'] = $input['ads_type_id'];
      if(!empty($input['duration_id'])) $this->params['duration_id'] = $input['duration_id'];
      if(!empty($input['condition_id'])) $this->params['condition_id'] = $input['condition_id'];
      if(isset($input['price'])) $this->params['price'] = $input['price']; // $this->params['price'] = $input['price'];
      if(isset($input['price_max'])) $this->params['price_max'] = $input['price_max'];
      $this->params['description'] = $input['description'];
      $this->params['address_id'] = $input['address_id'];
      $this->params['address_detail'] = $input['address_detail'];
      $this->params["seller_id"] = Auth::user()->id;

      $this->params["seller_id"] = Auth::user()->id;
      $this->params["status"] = 1;

      if(isset($input['brand_id'])) $this->params['brand_id'] = $input['brand_id'];
      if(isset($input['model_id'])) $this->params['model_id'] = $input['model_id'];
      if(isset($input['year'])) $this->params['year'] = $input['year'];
      if(isset($input['mileage'])) $this->params['mileage'] = $input['mileage'];
      if(isset($input['transmission_id'])) $this->params['transmission_id'] = $input['transmission_id'];
      if(isset($input['fuel_id'])) $this->params['fuel_id'] = $input['fuel_id'];
      if(isset($input['engine_capacity'])) $this->params['engine_capacity'] = $input['engine_capacity'];
      if(isset($input['passenger_qty_id'])) $this->params['passenger_qty_id'] = $input['passenger_qty_id'];
      if(isset($input['body_type_id'])) $this->params['body_type_id'] = $input['body_type_id'];
      if(isset($input['color_id'])) $this->params['color_id'] = $input['color_id'];
      if(isset($input['seller_type_id'])) $this->params['seller_type_id'] = $input['seller_type_id'];
      if(isset($input['service_id'])) $this->params['service_id'] = implode(",", $input['service_id']);

      if(isset($input['os_id'])) $this->params['os_id'] = $input['os_id'];
      if(isset($input['ram'])) $this->params['ram'] = $input['ram'];
      if(isset($input['storage'])) $this->params['storage'] = $input['storage'];

      if(isset($input['building_area'])) $this->params['building_area'] = $input['building_area'];
      if(isset($input['surface_area'])) $this->params['surface_area'] = $input['surface_area'];
      if(isset($input['bedroom_qty'])) $this->params['bedroom_qty'] = $input['bedroom_qty'];
      if(isset($input['bathroom_qty'])) $this->params['bathroom_qty'] = $input['bathroom_qty'];
      if(isset($input['floor'])) $this->params['floor'] = $input['floor'];
      if(isset($input['certification_id'])) $this->params['certification_id'] = $input['certification_id'];
      if(isset($input['seller_type_id'])) $this->params['seller_type_id'] = $input['seller_type_id'];

      if(isset($input['gender_id'])) $this->params['gender_id'] = $input['gender_id'];

      if(isset($input['job_type_id'])) $this->params['job_type_id'] = $input['job_type_id'];
      if(isset($input['year_max'])) $this->params['year_max'] = $input['year_max'];

      if($this->params['category_id'] == 1101 || $this->params['category_id'] == 1102) {
        unset($this->params['ads_type_id']);
        unset($this->params['condition_id']);
        unset($this->params['duration_id']);
        unset($this->params['price']);
      }

      if($this->params['category_id'] == 1102) {
        if(isset($input['gaji'])) $this->params['price'] = $input['gaji'];
        if(isset($input['gaji_max'])) $this->params['price_max'] = $input['gaji_max'];
      }


      // quick specs
      $quick_specification = "";
      $cat_id = $input['category_id'];
      if($cat_id == '204'){
        if(isset($input['year'])) $quick_specification .= $input['year'].";";
        if(isset($input['engine_capacity'])) $quick_specification .= $input['engine_capacity']." CC;";
      } else if($cat_id == '304'){
        if(isset($input['year'])) $quick_specification .= $input['year'].";";
        if(isset($input['engine_capacity'])) $quick_specification .= $input['engine_capacity']." CC;";
      } else if(in_array($cat_id, ['403','404','405','406'])){
        if(isset($input['ram'])) $quick_specification .= $input['ram']." GB RAM;";
        if(isset($input['storage'])) $quick_specification .= $input['storage']." GB Storage;";
        if(isset($input['year'])) $quick_specification .= $input['year'].";";
      } else if(in_array($cat_id, ['101','102','103','104','105','106','107'])){
        if(isset($input['building_area']) && isset($input['surface_area'])) $quick_specification .= $input['building_area']."/".$input['surface_area']." m2;";
        if(isset($input['bedroom_qty'])) $quick_specification .= $input['bedroom_qty']." KT;";
        if(isset($input['bathroom_qty'])) $quick_specification .= $input['bathroom_qty']." KM;";
      } else if(in_array($cat_id, ['702','703','704','705'])){
        if(isset($input['year'])) $quick_specification .= $input['year']." Tahun;";
        if(isset($input['gender_id'])) $quick_specification .= $input['gender_id'] == 1 ? "Jantan;" : "Betina;";
      } else if(in_array($cat_id, ['1101'])){

        if(isset($input['job_type_id'])) {
          try{
            $get_job_type = SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'job_type_id' and id = ?", [$input['job_type_id']]);
            $quick_specification .= $get_job_type['data'][0]->text.";";
          } catch (\Throwable $th) {}
        }
        if(isset($input['gender_id'])) $quick_specification .= $input['gender_id'] == 1 ? "Pria;" : "Wanita;";
        if(isset($input['year'])) $quick_specification .= $input['year']." Tahun;";
      } else if(in_array($cat_id, ['1102'])){
        if(isset($input['gender_id'])) {
          if($input['gender_id'] == 1) $quick_specification .= "Pria;";
          else if($input['gender_id'] == 2) $quick_specification .= "Wanita;";
          else $quick_specification .= "Pria & Wanita;";
        }
        if(isset($input['year']) && isset($input['year_max'])) $quick_specification .= $input['year']. "-".$input['year_max']." Tahun;";
        else if(isset($input['year'])) $quick_specification .= ">".$input['year']." Tahun;";
        else if(isset($input['year_max'])) $quick_specification .= "<".$input['year_max']." Tahun;";
      }
      if(!empty($quick_specification)) $this->params['quick_specification'] = $quick_specification;


      // insert
      $id = DB::table('t_m_ads')->insertGetId($this->params);

      $coba = "";
      $is_cover_saved = false;
      foreach ($input['imgUpload'] as $pathfile) {
        $filename = basename($pathfile);
        
        File::move(public_path().$pathfile, public_path().env('PATH_ADS') . $filename);

        if(!$is_cover_saved){
          $is_cover_saved = true;

          DB::table('t_m_ads')->where('id', $id)->update(['image_cover' => $filename]);

          //thumbnail
          $img = Image::make(public_path().env('PATH_ADS') . $filename);
          $img->fit(306, 230, function ($constraint) {
            $constraint->aspectRatio();
          })->save(public_path().env('PATH_ADS_THUMBS') . $filename);

        } else {
          DB::table('t_m_ads_image')->insert([
            'ads_id' => $id,
            'image' => $filename,
          ]);
        }
        // $imagePath = $image->store('public/item_images'); // Adjust storage path
        // DB::table('t_m_ads_images')->insert([
        //   'ads_id' => DB::getPdo()->lastInsertId(),
        //   'path' => $imagePath,
        // ]);
      }
 
        // return ResponseService::notSuccess([], "tidak dapat menambahkan iklan sendiri ke favorit.");
      return ResponseService::success(['id'=>md5($id)], "Iklan berhasil ditambahkan.");

      // return SqlHelpers::simpleInsertResult("insert into t_m_ads_favorite(ads_id,user_id) values((select id from t_m_ads where md5(id) = :ads_id), :user_id) ON DUPLICATE KEY UPDATE created_date = created_date", $this->params);
    }

    public function imageUpload(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
      ]);
      if ($validator->fails()) return ResponseService::notSuccess($validator->messages());

      // Handle the file upload
      if ($request->hasFile('file')) {
          $filename = SqlHelpers::uploadImage($request->file('file'), env('PATH_ADS_TMP'));
          return ResponseService::success(['fileUrl' => env('PATH_ADS_TMP').$filename], "Gambar berhasil ditambahkan.");
      }

      return ResponseService::badRequest([], "No file uploaded.");
    }

    public function getCreateContent(Request $request, $cat_id){
      $data = [];

      $category = DB::table('t_m_category_ads')->where('id', $cat_id)->first();
      if(!$category) return "";

      $content = '';

      // if($category->category_slug == 'mobil_c204'){
      if($cat_id == '204'){
        $content = view()->exists('api.item.create.mobil') ? view('api.item.create.mobil') : "";
        if(!$content) return "";
          $data = [
          'brand_id' => SqlHelpers::simpleSelect("select id, text from t_m_brand where code = 'car'", []),
          'model_id' => SqlHelpers::simpleSelect("select a.id, a.text, a.brand_id as parent from t_m_brand_model a join t_m_brand b on a.brand_id = b.id where b.code = 'car'", []),
          'transmission_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'transmission_id_car'", []),
          'fuel_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'fuel_id_car'", []),
          'passenger_qty_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'passenger_qty_id'", []),
          'body_type_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'body_type_id_car'", []),
          'color_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'color_id_vehicle'", []),
          'seller_type_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'seller_type_id_vehicle'", []),  
          'service_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'service_id_car'", []),
        ];
      } else if($cat_id == '304'){
        $content = view()->exists('api.item.create.motor') ? view('api.item.create.motor') : "";
        if(!$content) return "";
        $data = [
          'brand_id' => SqlHelpers::simpleSelect("select id, text from t_m_brand where code = 'motorcycle'", []),
          'model_id' => SqlHelpers::simpleSelect("select a.id, a.text, a.brand_id as parent from t_m_brand_model a join t_m_brand b on a.brand_id = b.id where b.code = 'motorcycle'", []),
          'transmission_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'transmission_id_motorcycle'", []),
          'fuel_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'fuel_id_motorcycle'", []),
          'passenger_qty_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'passenger_qty_id'", []),
          'body_type_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'body_type_id_motorcycle'", []),
          'color_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'color_id_vehicle'", []),
          'seller_type_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'seller_type_id_vehicle'", []),  
          'service_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'service_id_motorcycle'", []),
        ];
        
      } else if(in_array($cat_id, ['403','404','405','406'])){
        $content = view()->exists('api.item.create.gadget') ? view('api.item.create.gadget') : "";
        if(!$content) return "";
        $data = [
          'brand_id' => SqlHelpers::simpleSelect("select id, text from t_m_brand where code = 'gadget'", []),
          'os_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'os_id'", []),
        ];
      } else if(in_array($cat_id, ['101','102','103','104','105','106','107'])){
        $content = view()->exists('api.item.create.properti') ? view('api.item.create.properti') : "";
        if(!$content) return "";
        $data = [
          'certification_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'certification_id'", []),
          'seller_type_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'seller_type_id_property'", []),
          'service_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'service_id_property'", []),
        ];
      } else if(in_array($cat_id, ['702','703','704','705'])){
        $content = view()->exists('api.item.create.peliharaan') ? view('api.item.create.peliharaan') : "";
        if(!$content) return "";
        $data = [
          'gender_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'gender_pet'", []),
        ];
      } else if(in_array($cat_id, ['1101'])){
        $content = view()->exists('api.item.create.cariperkajaan') ? view('api.item.create.cariperkajaan') : "";
        if(!$content) return "";
        $data = [
          'job_type_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'job_type_id'", []),
          'gender_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'gender'", []),
        ];
      } else if(in_array($cat_id, ['1102'])){
        $content = view()->exists('api.item.create.loker') ? view('api.item.create.loker') : "";
        if(!$content) return "";
        $data = [
          'job_type_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'job_type_id'", []),
          'gender_id' => SqlHelpers::simpleSelect("select id, text from t_m_list where code = 'gender_loker'", []),
        ];
      }



      if(!$content) return "";
      return $content->with($data);


    }
}

