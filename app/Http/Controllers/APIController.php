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

    public function showArtists(Request $request)
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

        return response()->json($data,200);
      }else{
        return response()->json('API Token missing/invalid',400);
      }
    }

    public function getArtists(Request $request)
    {
      if($this->checkAPIToken($request->api_token) == true){
        if($getArtist = Artists::where('ArtistID', $request->artistid)->first()){
          return response()->json($getArtist,200);
        }else{
          return response()->json('Failed',400);
        }
      }else{
        return response()->json('API Token missing/invalid',400);
      }
    }

    public function addArtists(Request $request)
    {
      if($this->checkAPIToken($request->api_token) == true){
        $artists = new Artists;
        $artists->ArtistName = $request->artist;
        $artists->AlbumName = $request->album;
        $artists->ImageURL = $request->image;
        $artists->ReleaseDate = $request->release;
        $artists->Price = $request->price;
        $artists->SampleURL = $request->sample;

        if($artists->save()){
          return response()->json('Added successfully',200);
        }else{
          return response()->json('Failed',400);
        }
      }else{
        return response()->json('API Token missing/invalid',400);
      }
    }

    public function updateArtists(Request $request)
    {
      if($this->checkAPIToken($request->api_token) == true){

        if(Artists::where('ArtistID', $request->artistid)->update([
          'ArtistName' => $request->artist,
          'AlbumName' => $request->album,
          'ImageURL' => $request->image,
          'ReleaseDate' => $request->release,
          'Price' => $request->price,
          'SampleURL' => $request->sample
        ])){
          return response()->json('Updated successfully',200);
        }else{
          return response()->json('Failed',400);
        }
      }else{
        return response()->json('API Token missing/invalid',400);
      }
    }

    public function deleteArtists(Request $request)
    {
      if($this->checkAPIToken($request->api_token) == true){
        if(Artists::destroy($request->artistid)){
          return response()->json('Deleted successfully',200);
        }else{
          return response()->json('Failed',400);
        }
      }else{
        return response()->json('API Token missing/invalid',400);
      }
    }
}
