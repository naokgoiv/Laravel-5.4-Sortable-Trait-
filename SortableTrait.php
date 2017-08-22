<?php


/*
this Trait was written by Nazar Ivankiv (https://prosite5.com)
it helps to perform sorting by column in CRUD tables and any other cases
*/


namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


trait SortableTrait {


    // add ordering instructions to a current query
    public function scopeSortable($query) {
        $request = Request::capture();

        if($request->get('s') && $request->get('o')) {         
            return $query->orderBy($request->get('s'), $request->get('o'));   
        } else {
            return $query;
        }
    }
 

    // form the ordering link
    public static function link_to_sorting_action($col, $title = null) {
        $request = Request::capture();

        if (is_null($title)) {
            $title = str_replace('_', ' ', $col);
            $title = ucfirst($title);
        }

        $indicator = ($request->get('s') == $col ? ($request->get('o') === 'asc' ? '&uarr;' : '&darr;') : null);
        $parameters = array_merge($_GET, array('s' => $col, 'o' => ($request->get('o') === 'asc' ? 'desc' : 'asc')));
 
        return link_to_route(Route::currentRouteName(), "$title $indicator", $parameters);
    }


}