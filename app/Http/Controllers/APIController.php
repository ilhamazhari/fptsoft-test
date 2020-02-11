<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Artists;

class APIController extends Controller
{
    private function checkAPIToken($token)
    {
      if(User::where('api_token', $token)->get()->count() > 0){
        return true;
      }else{
        return false;
      }
    }

    public function showArtist(Request $request)
    {
      if($this->checkAPIToken($request->api_token) == true){
        $totalData = Artists::count();

        $columns = array(
          0 => 'ArtistID',
          1 => 'ArtistName',
          2 => 'AlbumName',
          3 => 'ImageURL',
          4 => 'ReleaseDate',
          5 => 'Price',
          6 => 'SampleURL'
        );

        $search = $request->input('search.value');
        $start = $request->start ? $request->start : 0;
        $limit = $request->length ? $request->length : 10;
        $order = $columns[$request->input('order.0.column') ? $request->input('order.0.column') : 0];
        $dir = $request->input('order.0.dir') ? $request->input('order.0.dir') : 'ASC';

        if(empty($search)){
          $artists = Artists::offset($start)->limit($limit)->orderBy($order,$dir)->get();

          $totalFiltered = 0;
        }else{
          $artists = Artists::where('ArtistName', 'LIKE', '%$search%')->orWhere('AlbumName', 'LIKE', '%{$search}%')->offset($start)->limit($limit)->orderBy($order,$dir)->get();

          $totalFiltered = Artists::where('ArtistName', 'LIKE', '%$search%')->orWhere('AlbumName', 'LIKE', '%{$search}%')->count();
        }

        $data = array(
          'draw' => intval($request->draw),
          'recordsTotal' => intval($totalData),
          'recordsFiltered' => intval($totalFiltered),
          'data' => $artists
        );

        return response()->json($data);
      }else{
        return response()->json('API Token missing/invalid');
      }
    }
}
