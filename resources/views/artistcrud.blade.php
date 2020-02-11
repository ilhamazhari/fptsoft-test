@extends('layout.main')

@section('title', 'Artists CRUD Test')

@section('style')
<style type="text/css"></style>
@endsection

@section('content')
<h1>Artist CRUD Test</h1>
<h2 id="test"></h2>

<table id="ArtistTable" class="table stripe">
  <thead>
    <th>No.</th>
    <th>Album Name</th>
    <th>Artist Name</th>
    <th>Date Release</th>
    <th>Sample Audio</th>
    <th>Price</th>
    <th></th>
  </thead>
</table>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#ArtistTable').DataTable({
      processing: true,
      serverSide: true,
      serverMethod: 'POST',
      ajax: {
        url: '{{url("/api/artists")}}',
        dataType: 'json',
        type: 'POST',
        data: {api_token: '{{$usertoken}}'}
      },
      columns: [
        {data: 'ArtistID'},
        {data: 'AlbumName'},
        {data: 'ArtistName'},
        {data: 'ReleaseDate'},
        {data: 'SampleURL'},
        {data: 'Price'},
        {data: 'ArtistID',
          render: function(data,type,full,meta){
            return '<button type="button" class="btn btn-primary edit-button" data-artistid="' + data + '"><i class="fa fa-pencil"></i> Edit</button> <button type="button" class="btn btn-danger delete-button" data-atistid="' + data + '"><i class="fa fa-times"></i> Delete</button>';
          }
        }
      ]
    });
  });
</script>
@endsection