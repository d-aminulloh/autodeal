<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use ResponseService;
use SqlHelpers;
use Auth;

class ApiReferenceController extends Controller
{
  private $params = array();

  public function getReference(Request $request, $code)
  {

      // $validator = Validator::make($request->all(), [
      //     'query' => 'required|min:3',
      // ]);

      // if ($validator->fails()) return ResponseService::badRequest($validator->messages());
      
      $this->params = array();
      $this->params[] = $code;
      $with_all = $request->input('with_all') ?? "";
      
      $getQuery =SqlHelpers::simpleSelect("select que from t_m_datasource where id = ?", $this->params);
      $query = isset($getQuery["data"][0]) ? $getQuery["data"][0]->que:"";
      if($query == "") return ResponseService::notSuccess();

      $this->params = array();
      if(!empty($request->input('param'))){
          $this->params['param'] = $request->input('param');
      }
      $with_all = $request->input('with_all') ?? "";

      if(Auth::user()){
          $this->params['user_id'] = Auth::user()->id;
      }

      if(isset($request["param1"])){
          $this->params['param1'] = $request->input('param1') ?? "";
      }
      if(isset($request["param2"])){
          $this->params['param2'] = $request->input('param2') ?? "";
      }
      if(isset($request["param3"])){
          $this->params['param3'] = $request->input('param3') ?? "";
      }

      // if(isset($request["category"])){
      //     $this->params['category'] = $request->input('category') ?? "";
      // }
      // if(isset($request["search"])){
      //     $this->params['search'] = '%'.$request->input('search').'%';
      // }
      // if(isset($request["location"])){
      //     $this->params['location'] = $request->input('location') ?? "";
      // }
      // if(isset($request["pmin"])){
      //     $this->params['pmin'] = $request->input('pmin') ?? "";
      //     // $this->params['param4'] = intval($this->params['param4']);
      // }
      // if(isset($request["pmax"])){
      //     $this->params['pmax'] = $request->input('pmax') ?? "";
      //     // $this->params['param5'] = intval($this->params['param5']);
      // }
      // if(isset($request["ymin"])){
      //     $this->params['ymin'] = $request->input('ymin') ?? "";
      // }
      // if(isset($request["ymax"])){
      //     $this->params['ymax'] = $request->input('ymax') ?? "";
      // }
      // if(isset($request["transc"])){
      //     $this->params['transc'] = $request->input('transc') ?? "";
      // }

      return SqlHelpers::simpleSelectResult($query, $this->params, $with_all);
  }

  public function getFilterReference(Request $request, $code)
  {
    $this->params = array();

    //extra filter
    $extra_filter_query = "";

    if(!empty($request["category"])){
      $extra_filter_query .= "and (
                                ct.id = (SELECT id FROM t_m_category_ads where category_slug = :category)
                                or ct.parent_id = (SELECT id FROM t_m_category_ads where category_slug = :category and parent_id is null)
                              )
      ";
        $this->params['category'] = $request->input('category') ?? "";
    }
    if(isset($request["search"])){
      $extra_filter_query .= " and a.title like :search ";
      $this->params['search'] = '%'.$request->input('search').'%';
    }
    // if(isset($request["location"])){
      $location = intval($request->input('location')) < 1 ? 1:intval($request->input('location')); // 1 = default indonesia
      $extra_filter_query .= "and (
                                addr1.id = :location
                                or addr1.city_id = :location
                                or addr1.province_id = :location
                                or addr1.country_id = :location
                              )
      ";
      $this->params['location'] = $location;
    // }

    //price
    $pmin = $request->input('pmin') ?? "";
    if(!empty($pmin)) {
      $extra_filter_query .= " and a.price >= :pmin ";
      $this->params['pmin'] = $pmin;
    }
    $pmax = $request->input('pmax') ?? "";
    if(!empty($pmax)) {
      $extra_filter_query .= " and a.price <= :pmax ";
      $this->params['pmax'] = $pmax;
    }
    
    //year
    $ymin = $request->input('ymin') ?? "";
    if(!empty($ymin)) {
      $extra_filter_query .= " and a.year >= :ymin ";
      $this->params['ymin'] = $ymin;
    }
    $ymax = $request->input('ymax') ?? "";
    if(!empty($ymax)) {
      $extra_filter_query .= " and a.year <= :ymax ";
      $this->params['ymax'] = $ymax;
    }
    //wherein
    $extra_filter_query .= $this->buildExtraQuery("a.ads_type_id", "atype", $request->input('atype'));
    $extra_filter_query .= $this->buildExtraQuery("a.condition_id", "acond", $request->input('acond'));
    $extra_filter_query .= $this->buildExtraQuery("a.duration_id", "adur", $request->input('adur'));

    // mobil
    $extra_filter_query .= $this->buildExtraQuery("a.brand_id", "brandc", $request->input('brandc'));
    $extra_filter_query .= $this->buildExtraQuery("a.model_id", "modc", $request->input('modc'));
    $extra_filter_query .= $this->buildExtraQuery("a.transmission_id", "transc", $request->input('transc'));
    $extra_filter_query .= $this->buildExtraQuery("a.fuel_id", "fuelc", $request->input('fuelc'));
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.engine_capacity", "engine_capacity_car", "engc", $request->input('engc'));
    $extra_filter_query .= $this->buildExtraQuery("a.body_type_id", "bodyc", $request->input('bodyc'));
    $extra_filter_query .= $this->buildExtraQuery("a.passenger_qty_id", "passec", $request->input('passec'));
    $extra_filter_query .= $this->buildExtraQuery("a.color_id", "colv", $request->input('colv'));
    $extra_filter_query .= $this->buildExtraQuery("a.seller_type_id", "sellv", $request->input('sellv'));

    // motor
    $extra_filter_query .= $this->buildExtraQuery("a.brand_id", "brandm", $request->input('brandm'));
    $extra_filter_query .= $this->buildExtraQuery("a.model_id", "modm", $request->input('modm'));
    $extra_filter_query .= $this->buildExtraQuery("a.transmission_id", "transm", $request->input('transm'));
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.engine_capacity", "engine_capacity_motorcycle", "engm", $request->input('engm'));
    $extra_filter_query .= $this->buildExtraQuery("a.body_type_id", "bodym", $request->input('bodym'));
    $extra_filter_query .= $this->buildExtraQuery("a.fuel_id", "fuelm", $request->input("fuelm"));

    //property
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.bedroom_qty", "bedroom_id", "bedr", $request->input('bedr'));
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.bathroom_qty", "bathroom_id", "bath", $request->input('bath'));
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.floor", "floor_id", "floor", $request->input('floor'));
    $extra_filter_query .= $this->buildExtraQuery("a.certification_id", "cert", $request->input('cert'));
    $extra_filter_query .= $this->buildExtraQuery("a.seller_type_id", "sellp", $request->input('sellp'));

    //gadget
    $extra_filter_query .= $this->buildExtraQuery("a.brand_id", "brandg", $request->input('brandg'));
    $extra_filter_query .= $this->buildExtraQuery("a.os_id", "os", $request->input('os'));
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.ram", "ram_id", "ram", $request->input('ram'));
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.storage", "storage_id", "stor", $request->input('stor'));

    // pet and job
    $extra_filter_query .= $this->buildExtraQuery("a.gender_id", "gen", $request->input('gen'));
    $extra_filter_query .= $this->buildExtraQuery("a.gender_id", "genp", $request->input('genp'));
    $extra_filter_query .= $this->buildExtraQuery("a.job_type_id", "jobt", $request->input('jobt'));

    $query = $this->getQuery($code, $extra_filter_query);

    // return $query;

    return SqlHelpers::simpleSelectFilterResult($query, $this->params);
  }

  function getQuery($code, $extra_filter_query){
    $query = "";
    if($code == "get_filter_brandc"){
      $query = "SELECT 
                  a.brand_id as id,
                  b.text,
                  count(1) as cnt
                from t_m_ads a
                  inner join t_m_address addr1 on addr1.id= a.address_id
                  inner join t_m_category_ads ct on ct.id = a.category_id
                inner JOIN t_m_brand b on a.brand_id = b.id and b.code ='car'
                where 1 = 1
                  $extra_filter_query
                group by a.brand_id, b.text
                order by b.text
                limit 0,100
      ";
    } 
    elseif($code == "get_filter_modc"){
      $query = "SELECT 
                  a.model_id as id,
                  b.text,
                  count(1) as cnt
                from t_m_ads a
                  inner join t_m_address addr1 on addr1.id= a.address_id
                  inner join t_m_category_ads ct on ct.id = a.category_id
                inner JOIN t_m_brand c on a.brand_id = c.id and c.code ='car'
                inner JOIN t_m_brand_model b on a.model_id = b.id
                where 1 = 1
                  $extra_filter_query
                group by a.model_id, b.text
                order by b.text
                limit 0,100
      ";
    } 
    elseif($code == "get_filter_transc"){ $query =  $this->buildFilterQuery("transmission_id","transmission_id_car", $extra_filter_query); } 
    elseif($code == "get_filter_fuelc"){ $query = $this->buildFilterQuery("a.fuel_id","fuel_id_car", $extra_filter_query); } 
    elseif($code == "get_filter_engc"){ $query = $this->buildFilterQueryWhereInMinMax("a.engine_capacity","engine_capacity_id_car", $extra_filter_query); } 
    elseif($code == "get_filter_bodyc"){ $query = $this->buildFilterQuery("a.body_type_id","body_type_id_car", $extra_filter_query); } 
    elseif($code == "get_filter_passec"){ $query = $this->buildFilterQuery("a.passenger_qty_id","passenger_qty_id", $extra_filter_query); } 
    elseif($code == "get_filter_colv"){ $query = $this->buildFilterQuery("a.color_id","color_id_vehicle", $extra_filter_query); } 
    elseif($code == "get_filter_sellv"){ $query = $this->buildFilterQuery("a.seller_type_id","seller_type_id_vehicle", $extra_filter_query); } 
    elseif($code == "get_filter_atype"){ $query = $this->buildFilterQuery("a.ads_type_id","ads_type_id", $extra_filter_query); } 
    elseif($code == "get_filter_acond"){ $query = $this->buildFilterQuery("a.condition_id","condition_id", $extra_filter_query); } 
    elseif($code == "get_filter_adur"){ $query = $this->buildFilterQuery("a.duration_id","duration_id", $extra_filter_query); }

    elseif($code == "get_filter_brandm"){
      $query = "SELECT 
                  a.brand_id as id,
                  b.text,
                  count(1) as cnt
                from t_m_ads a
                  inner join t_m_address addr1 on addr1.id= a.address_id
                  inner join t_m_category_ads ct on ct.id = a.category_id
                inner JOIN t_m_brand b on a.brand_id = b.id and b.code ='motorcycle'
                where 1 = 1
                  $extra_filter_query
                group by a.brand_id, b.text
                order by b.text
                limit 0,100
      ";
    } elseif($code == "get_filter_modm"){
      $query = "SELECT 
                  a.model_id as id,
                  b.text,
                  count(1) as cnt
                from t_m_ads a
                  inner join t_m_address addr1 on addr1.id= a.address_id
                  inner join t_m_category_ads ct on ct.id = a.category_id
                inner JOIN t_m_brand c on a.brand_id = c.id and c.code ='motorcycle'
                inner JOIN t_m_brand_model b on a.model_id = b.id
                where 1 = 1
                  $extra_filter_query
                group by a.model_id, b.text
                order by b.text
                limit 0,100
      ";
    } 
    elseif($code == "get_filter_transm"){ $query = $this->buildFilterQuery("a.transmission_id","transmission_id_motorcycle", $extra_filter_query); }
    elseif($code == "get_filter_engm"){ $query = $this->buildFilterQueryWhereInMinMax("a.engine_capacity","engine_capacity_id_motorcycle", $extra_filter_query); }
    elseif($code == "get_filter_bodym"){ $query = $this->buildFilterQuery("a.body_type_id","body_type_id_motorcycle", $extra_filter_query); }
    elseif($code == "get_filter_fuelm"){ $query = $this->buildFilterQuery("a.fuel_id","fuel_id_motorcycle", $extra_filter_query); }

    elseif($code == "get_filter_bedr"){ $query = $this->buildFilterQueryWhereInMinMax("a.bedroom_qty","bedroom_id", $extra_filter_query); }
    elseif($code == "get_filter_bath"){ $query = $this->buildFilterQueryWhereInMinMax("a.bathroom_qty","bathroom_id", $extra_filter_query); }
    elseif($code == "get_filter_floor"){ $query = $this->buildFilterQueryWhereInMinMax("a.floor","floor_id", $extra_filter_query); }
    elseif($code == "get_filter_cert"){ $query = $this->buildFilterQuery("a.certification_id","certification_id", $extra_filter_query); }
    elseif($code == "get_filter_sellp"){ $query = $this->buildFilterQuery("a.seller_type_id","seller_type_id_property", $extra_filter_query); }

    elseif($code == "get_filter_brandg"){
      $query = "SELECT 
                  a.brand_id as id,
                  b.text,
                  count(1) as cnt
                from t_m_ads a
                  inner join t_m_address addr1 on addr1.id= a.address_id
                  inner join t_m_category_ads ct on ct.id = a.category_id
                inner JOIN t_m_brand b on a.brand_id = b.id and b.code ='gadget'
                where 1 = 1
                  $extra_filter_query
                group by a.brand_id, b.text
                order by b.text
                limit 0,100
      ";
    } 
    elseif($code == "get_filter_os"){ $query = $this->buildFilterQuery("a.os_id","os_id", $extra_filter_query); }
    elseif($code == "get_filter_ram"){ $query = $this->buildFilterQueryWhereInMinMax("a.ram","ram_id", $extra_filter_query); }
    elseif($code == "get_filter_stor"){ $query = $this->buildFilterQueryWhereInMinMax("a.storage","storage_id", $extra_filter_query); }

    elseif($code == "get_filter_gen"){ $query = $this->buildFilterQuery("a.gender_id","gender", $extra_filter_query); }
    elseif($code == "get_filter_genp"){ $query = $this->buildFilterQuery("a.gender_id","gender_pet", $extra_filter_query); }
    elseif($code == "get_filter_jobt"){ $query = $this->buildFilterQuery("a.job_type_id","job_type_id", $extra_filter_query); }
    
    return $query;
  }

  function buildExtraQuery($field, $filtername, $value){
    $newExtra = $value ?? "";
    if(!empty($newExtra)) {
      $secure_arr = explode(',', $newExtra);
      for ($i=0; $i < count($secure_arr); $i++)  
        $secure_arr[$i] = DB::connection()->getPdo()->quote($secure_arr[$i]);
      
      $newExtra = implode(',', $secure_arr);
      $this->params[$filtername] = $newExtra;
      return " and $field IN ($newExtra) ";
    }
    return "";
  }

  function buildExtraQueryWhereInMinMax($field, $filter_code, $filtername, $value){
    $build_query = "";
    $newExtra = $value ?? "";
    if(!empty($newExtra)) {
      // $secure_arr = explode(',', $newExtra);
      // for ($i=0; $i < count($secure_arr); $i++)  
      //   $secure_arr[$i] = DB::connection()->getPdo()->quote($secure_arr[$i]);
      
      // $newExtra = implode(',', $secure_arr);

      $getFilterAttr = SqlHelpers::simpleSelect("SELECT id, min, max FROM t_m_list where code = '$filter_code' ".$this->buildExtraQueryOnly($newExtra, 'id'), []);
      if(count($getFilterAttr["data"]) > 0 ) {
        $this->params[$filtername] = $newExtra; 
  
        $first = true;
        foreach($getFilterAttr["data"] as $key => $val) {
          $min = $val->min;
          $max = $val->max;
          if(!$first) $build_query .= " or ";
          $first = false;
          if(!empty($min) && !empty($max)) $build_query .= " $field between $min and $max ";
          else if(!empty($min)) $build_query .= " $field >= $min ";
          else if(!empty($max)) $build_query .= " $field <= $max ";
        }
        $build_query = " AND ($build_query) ";
      }
    }

    return $build_query;
  }

  function buildExtraQueryOnly($code, $field){
    $newExtra = $code ?? "";
    // return $newExtra;
    if(!empty($newExtra)) {
      $secure_arr = explode(',', $newExtra);
      for ($i=0; $i < count($secure_arr); $i++)  
        $secure_arr[$i] = DB::connection()->getPdo()->quote($secure_arr[$i]);
      
      $newExtra = implode(',', $secure_arr);
      return " and $field IN ($newExtra) ";
    }
    return "";
  }

  function buildFilterQuery($field, $reff, $extra_filter_query){
      return "SELECT 
                  b.id,
                  b.text,
                  count(1) as cnt
                from t_m_ads a
                  inner join t_m_address addr1 on addr1.id= a.address_id
                  inner join t_m_category_ads ct on ct.id = a.category_id
                  inner join t_m_list b on b.id = $field and b.code = '$reff'
                where 1 = 1
                  $extra_filter_query
                group by b.id, b.text
                order by b.id asc
      ";
  }


  function buildFilterQueryWhereInMinMax($field, $reff, $extra_filter_query){
    return "SELECT 
                b.id,
                b.text,
                count(1) as cnt
              from t_m_ads a
                inner join t_m_address addr1 on addr1.id= a.address_id
                inner join t_m_category_ads ct on ct.id = a.category_id
                inner join t_m_list b on b.code = '$reff' 
                and 
                case 
                  when b.min is not null and b.max is not null and $field BETWEEN b.min and b.max then 1 
                  when b.max is null and $field > b.min then 1 
                  when b.min is null and $field < b.max then 1 
                end = 1

              where 1 = 1
                $extra_filter_query
              group by b.id, b.text
              order by b.id asc
    ";
    // return "SELECT * FROM (
    //           SELECT 
    //             b.id,
    //             b.text
    //             , (select count(1) from t_m_ads a 
    //                 inner join t_m_address addr1 on addr1.id= a.address_id
    //                 inner join t_m_category_ads ct on ct.id = a.category_id
    //             where 1=1
    //               $extra_filter_query
    //               AND
    //               case 
    //                 when b.min is not null and b.max is not null and $field BETWEEN b.min and b.max then 1 
    //                 when b.max is null and $field > b.min then 1 
    //                 when b.min is null and $field < b.max then 1 
    //               end = 1
    //               ) cnt
    //           from t_m_list b
    //           where 1 = 1
    //           and b.code = '$reff'
    //       ) t where cnt > 0
    // ";

  }

  public function getNotification(Request $request){
    $params = array();
    $params['user_id'] = $request->user()->id;

    $query = "  
      select 
        a.title,
        a.detail,
        a.type,
        a.is_read,
        a.action,
        md5(a.ads_id) ads_id,
        a.user_reff_id,
        a.user_id,
        b.title as title_item,
        DATE_FORMAT(a.created_date,'%Y-%m-%d %H:%i') as created_date,
        CASE WHEN IFNULL(b.image_cover, '') = ''  THEN '' ELSE concat('".env('PATH_ADS_THUMBS')."', image_cover) END as image_cover
      from 
        t_m_notification a
        left join t_m_ads b on b.id = a.ads_id
      where a.user_id = :user_id
      order by created_date desc
      limit :offset, :limit
    ";

    $query_count = "  
      select count(1) as cnt
      from 
        t_m_notification a
      where a.user_id = :user_id
    ";

    return SqlHelpers::selectAndCountResult($query, $query_count, $params, 1, 100, 1);
  }
    
}
