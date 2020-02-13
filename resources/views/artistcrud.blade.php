@extends('layout.main')

@section('title', 'Artists CRUD Test')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha256-DOS9W6NR+NFe1fUhEE0PGKY/fubbUCnOfTje2JMDw3Y=" crossorigin="anonymous" />
<style type="text/css">
  #playModal .modal-content {
    background: #000;
    color: #fff;
  }
  #playModal .close {
    color: #fff;
  }
  #playModal .modal-header {
    border-bottom: 1px solid #333;
  }
  #playModal .image {
    text-align: center;
  }
  #playModal .modal-footer {
    border-top: 1px solid #333;
  }
  audio {
    width: 100%;
  }
</style>
@endsection

@section('content')
<h1>Artist CRUD Test</h1>
<h2 id="test"></h2>

<button type="button" class="btn btn-primary add-button"><i class="fa fa-plus"></i> Add New</button> 
<br><br>

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
<br><br>
<a href="{{url('logout')}}" class="btn btn-warning logout-button"><i class="fa fa-sign-out"></i>Logout</a>

<div class="modal fade" id="artistsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form name="artistsform" id="formArtist" method="POST" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="artistid" id="artistid" value="">
        <input type="hidden" name="formaction" id="formAction">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Artist Name</label>
            <div class="col-sm-8"><input type="text" name="artist" id="inputArtist" class="form-control"></div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Album Name</label>
            <div class="col-sm-8"><input type="text" name="album" id="inputAlbum" class="form-control"></div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Image URL</label>
            <div class="col-sm-8"><input type="text" name="image" id="inputImage" class="form-control"></div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Release Date</label>
            <div class="col-sm-8"><input type="text" name="release" id="inputRelease" class="form-control datepicker"></div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Price</label>
            <div class="col-sm-8"><input type="text" name="price" id="inputPrice" class="form-control"></div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-4">Sample URL</label>
            <div class="col-sm-8"><input type="text" name="sample" id="inputSample" class="form-control"></div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary save-button"><i class="fa fa-floppy-o"></i> Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="playModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Play song </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <table>
            <tr><td>Artist Name</td><td>:</td><td id="playArtist"></td></tr>
            <tr><td>Album Name</td><td>:</td><td id="playAlbum"></td></tr>
          </table>
          <div class="image">
            <img id="playimage" src="" width="400px" height="400px" align="center">
          </div>
        </div>

        <div class="modal-footer">
          <audio id="playsource" src="" controls>
            <source src="" type="audio/mp3">
            Your browser does not support the audio element.
          </audio>
        </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" integrity="sha256-xljKCznmrf+eJGt+Yxyo+Z3KHpxlppBZSjyDlutbOh0=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha256-FEqEelWI3WouFOo2VWP/uJfs1y8KJ++FLh2Lbqc8SJk=" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $('.datepicker').datetimepicker({
      timepicker:false,
      format:'Y-m-d'
    });

    $('#formArtist').submit(function(e){
      e.preventDefault();
      dataForm = $(this).serializeArray();
      action = dataForm[2].value;
      sendData = {
        api_token: '{{$usertoken}}',
        _token: dataForm[0].value,
        artistid: dataForm[1].value,
        artist: dataForm[3].value,
        album: dataForm[4].value,
        image: dataForm[5].value,
        release: dataForm[6].value,
        price: dataForm[7].value,
        sample: dataForm[8].value,
      };
      if(action == 'add'){
        $.ajax({
          url: '{{url("/api/artists/add")}}',
          dataType: 'json',
          type: 'POST',
          data: sendData,
          success: function(result){
            $('#ArtistTable').DataTable().ajax.reload();
            $('#artistsModal').modal('hide');
          },
          error: function(xhr,status,error){
            console.log(error);
            $('#artistsModal').modal('hide');
          }
        });
      }else if(action == 'update'){
        $.ajax({
          url: '{{url("/api/artists/update")}}',
          dataType: 'json',
          type: 'POST',
          data: sendData,
          success: function(result){
            $('#ArtistTable').DataTable().ajax.reload();
            $('#artistsModal').modal('hide');
          },
          error: function(xhr,status,error){
            console.log(error);
            $('#artistsModal').modal('hide');
          }
        });
      }
    });

    artistTable = $('#ArtistTable').DataTable({
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
        {data: 'ArtistID',
          render: function(data,type,full,meta){
            return meta.row + 1;
          }
        },
        {data: 'AlbumName',
          render: function(data,type,full,meta){
            return '<img src="' + full.ImageURL + '" width="100px" height="100px" align="left" style="margin-right: 10px;"> ' + data;
          }
        },
        {data: 'ArtistName'},
        {data: 'ReleaseDate',
          render: function(data,type,full,meta){
            release = new Date(data);
            return release.toString("dd MMM yyyy");
          }
        },
        {data: 'SampleURL',
          render: function(data,type,full,meta){
            return '<button type="button" class="btn btn-light button-play" data-play="' + data + '" data-artist="' + full.ArtistName + '" data-album="' + full.AlbumName + '" data-image="' + full.ImageURL + '" data-toggle="modal" data-target="#playModal"><i class="fa fa-play"></i></button>';
          }
        },
        {data: 'Price',
          render: function(data,type,full,meta){
            return numeral(data).format(0,0);
          }
        },
        {data: 'ArtistID',
          render: function(data,type,full,meta){
            console.log(full);
            return '<button type="button" class="btn btn-primary edit-button" data-artistid="' + data + '"><i class="fa fa-pencil"></i> Edit</button> <button type="button" class="btn btn-danger delete-button" data-artistid="' + data + '><i class="fa fa-times"></i> Delete</button>';
          }
        }
      ]
    });

    $('#ArtistTable tbody').on('click', '.edit-button', function(){
      $('.modal-title').html('Edit Artists');
      id =$(this).data('artistid');
      dataArtist = $.ajax({
        url: '{{url("/api/artists/get")}}',
        type: 'POST',
        dataType: 'json',
        data: {
          _token: '{{csrf_token()}}',
          api_token: '{{$usertoken}}',
          artistid: id,
        },
        success: function(data){
          $('#artistid').val(id);
          $('#inputArtist').val(data.ArtistName);
          $('#inputAlbum').val(data.AlbumName);
          $('#inputImage').val(data.ImageURL);
          $('#inputRelease').val(data.ReleaseDate);
          $('#inputPrice').val(data.Price);
          $('#inputSample').val(data.SampleURL);
          $('#artistsModal').modal('show');
        }
      });
      $('#formAction').val('update');
    });

    $('.add-button').on('click', function(){
      $('.modal-title').html('Add New Artists');
      $('#inputArtist').val('');
      $('#inputAlbum').val('');
      $('#inputImage').val('');
      $('#inputRelease').val('');
      $('#inputPrice').val('');
      $('#inputSample').val('');
      $('#artistsModal').modal('show');
      $('#formAction').val('add');
    });

    $('#ArtistTable tbody').on('click', '.button-play', function(){
      $('#playsource').attr('src',$(this).data('play'));
      $('#playimage').attr('src',$(this).data('image'));
      $('#playArtist').html($(this).data('artist'));
      $('#playAlbum').html($(this).data('album'));
    })

  });
</script>
@endsection