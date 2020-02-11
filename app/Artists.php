<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artists extends Model
{
    protected $table = 'Artists';

    protected $fillable = ['ArtistName', 'AlbumName', 'ImageURL', 'ReleaseDate', 'Price', 'SampleURL'];
}
