<?php

namespace App\Models\Itam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $connection = 'itam';

    protected $table = 'licenses';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    public $timestamps = true;
}
