<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use ResponseService;
use SqlHelpers;

class ApiCategoryController extends Controller
{
  private $params = array();

  public function getCategory(Request $request)
  {

      // $validator = Validator::make($request->all(), [
      //     'parent' => 'nullable',
      // ]);

      // if ($validator->fails()) return ResponseService::badRequest($validator->messages());

      $this->params = array();
      $this->params['path'] = env('PATH_CATEGORY');
      $this->params['parent'] = $request->input("parent") ?? "";;

      $query = "  SELECT
                    id AS id,
                    category_name AS text,
                    category_slug,
                    CASE
                      WHEN IFNULL( category_icon, '' ) = '' THEN '' 
                      ELSE concat( :path, category_icon ) 
                    END AS category_icon 
                  FROM
                    t_m_category_ads 
                  WHERE
                    case when IFNULL(parent_id, '') = '' then '' else parent_id end = :parent
                    or case when IFNULL(parent_id, '') = '' then '' else parent_id end = (SELECT id FROM t_m_category_ads where category_slug = :parent)
                  ORDER BY
                    seq ASC
      ";

      return SqlHelpers::simpleSelectResult($query, $this->params);
  }


  public function getCategoryFilter(Request $request)
  {
    $this->params = array();
    $this->params['param1'] = $request->input("parent") ?? "";;

    //getparent
    $query_cekparent = "SELECT
                          id AS id,
                          category_name AS text,
                          category_slug
                        FROM
                          t_m_category_ads 
                        WHERE
                          id = (SELECT id FROM t_m_category_ads where category_slug = :param1)
                          or id = (SELECT parent_id FROM t_m_category_ads where category_slug = :param1)
                        ORDER BY
                          parent_id asc
                        limit 0,1
    ";
    $parent = SqlHelpers::simpleSelect($query_cekparent, $this->params);

    $this->params['param2'] = '%'.$request->input('search').'%';
    $this->params['param3'] = intval($request->input('location')) < 1 ? 1:intval($request->input('location')); // 1 = default indonesia

    //extra filter
    $extra_filter_query = "";

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
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.engine_capacity", "engine_capacity_id_car", "engc", $request->input('engc'));
    $extra_filter_query .= $this->buildExtraQuery("a.body_type_id", "bodyc", $request->input('bodyc'));
    $extra_filter_query .= $this->buildExtraQuery("a.passenger_qty_id", "passec", $request->input('passec'));
    $extra_filter_query .= $this->buildExtraQuery("a.color_id", "colv", $request->input('colv'));
    $extra_filter_query .= $this->buildExtraQuery("a.seller_type_id", "sellv", $request->input('sellv'));

    // motor
    $extra_filter_query .= $this->buildExtraQuery("a.brand_id", "brandm", $request->input('brandm'));
    $extra_filter_query .= $this->buildExtraQuery("a.model_id", "modm", $request->input('modm'));
    $extra_filter_query .= $this->buildExtraQuery("a.transmission_id", "transm", $request->input('transm'));
    $extra_filter_query .= $this->buildExtraQueryWhereInMinMax("a.engine_capacity", "engine_capacity_id_motorcycle", "engm", $request->input('engm'));
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

    if ($parent["data"]) {
      $query = "  SELECT 
                    ct.id as id,
                    ct.category_name as text,
                    ct.category_slug,
                    count(1) as cnt
                  from t_m_category_ads ct
                    inner join t_m_ads a on ct.id = a.category_id
                    inner join t_m_address addr1 on addr1.id= a.address_id
                  where 1 = 1
                    and (
                      ct.parent_id = (SELECT id FROM t_m_category_ads where category_slug = :param1)
                      or ct.parent_id = (SELECT parent_id FROM t_m_category_ads where category_slug = :param1)
                    )
                    and a.title like :param2
                    and (
                      addr1.id = :param3
                      or addr1.city_id = :param3
                      or addr1.province_id = :param3
                      or addr1.country_id = :param3
                    )
                    $extra_filter_query
                  group by ct.id, ct.category_name, ct.category_slug
      ";
    } else {
      unset($this->params["param1"]);
      $query = "  SELECT
                    ct.parent_id as id,
                    ctp.category_name as text,
                    ctp.category_slug,
                    count(1) as cnt
                  from t_m_category_ads ct
                    inner join t_m_ads a on ct.id = a.category_id
                    inner join t_m_address addr1 on addr1.id= a.address_id
                    inner join t_m_category_ads ctp on ct.parent_id= ctp.id
                  where 1 = 1
                    and a.title like :param2
                    and (
                      addr1.id = :param3
                      or addr1.city_id = :param3
                      or addr1.province_id = :param3
                      or addr1.country_id = :param3
                    )
                    $extra_filter_query
                  group by ct.parent_id, ctp.category_name, ctp.category_slug
    ";
    }

    // return $query;
    // return $this->params;
    return SqlHelpers::simpleSelectFilterResult($query, $this->params, '0', $parent['data'], true);
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
    if(!empty($newExtra)) {
      $secure_arr = explode(',', $newExtra);
      for ($i=0; $i < count($secure_arr); $i++)  
        $secure_arr[$i] = DB::connection()->getPdo()->quote($secure_arr[$i]);
      
      $newExtra = implode(',', $secure_arr);
      return " and $field IN ($newExtra) ";
    }
    return "";
  }
}
