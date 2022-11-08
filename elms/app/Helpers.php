<?php

use App\Models\Roles\Menu;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;


function helperPermission()
{
    //get Controller Name
    //get the access from database
    //set variable for add/edit/delete


    $user_group_id = Auth::user()->user_group_id;


    $action = app('request')->route()->getAction();

    /*
     * Splits the controller and store in array
     */
    $controllers = explode("@", class_basename($action['controller']));
    /*
     * Checks the existence of controller and method
     */

    $controller_name = isset($controllers[0]) ? $controllers[0] : '';

    $permission = [
        'isView' => false,
        'isAdd' => false,
        'isEdit' => false,
        'isDelete' => false
    ];


    $res = Menu::join('user_roles', 'menus.id', '=', 'user_roles.menu_id')
        ->select('user_roles.*', 'menus.*')
        ->where('user_group_id', '=', $user_group_id)
        ->where('menu_controller', '=', $controller_name)
        ->first();

    $cnt = empty($res);

    if (!$cnt) {

        $isView = $res->allow_view;
        $isAdd = $res->allow_add;
        $isEdit = $res->allow_edit;
        $isDelete = $res->allow_delete;

        $permission = [
            'isView' => $isView,
            'isAdd' => $isAdd,
            'isEdit' => $isEdit,
            'isDelete' => $isDelete
        ];
    }
    return $permission;
}

function helperPermissionLink($addRoute, $viewRoute)
{
    $permission = helperPermission();
    if ($permission['isAdd']) {
        echo '<a href="' . $addRoute . '"  class="pull-right boxTopButton" id="add" data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle" style="font-size:20px;" ></i></a>';
    }
    echo '<a href="' . $viewRoute . '"  class="pull-right boxTopButton" data-toggle="tooltip" title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>';
    echo '<a href="' . URL::previous() . '" class="pull-right  boxTopButton" data-toggle="tooltip" title="Go Back"><i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>';
    return $permission;
}

/*
 * Random Password Generate Function
 */
function rand_string($length)
{

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
}

function Median($Array) {
    return Quartile_2($Array);
  }
  
  function Quartile_1($Array) {
    return Quartile($Array, 0.25);
  }
  
  function Quartile_2($Array) {
    return Quartile($Array, 0.5);
  }
  
  function Quartile_3($Array) {
    return Quartile($Array, 0.75);
  }
  
  function Quartile($Array, $Quartile) {
    sort($Array);
    $pos = (count($Array) - 1) * $Quartile;
  
    $base = floor($pos);
    $rest = $pos - $base;
  
    if( isset($Array[$base+1]) ) {
      return $Array[$base] + $rest * ($Array[$base+1] - $Array[$base]);
    } else {
      return $Array[$base];
    }
  }
  
  function Average($Array) {
    return array_sum($Array) / count($Array);
  }
  
  function StdDev($Array) {
    if( count($Array) < 2 ) {
      return;
    }
  
    $avg = Average($Array);
  
    $sum = 0;
    foreach($Array as $value) {
      $sum += pow($value - $avg, 2);
    }
  
    return sqrt((1 / (count($Array) - 1)) * $sum);
  }
