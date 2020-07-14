<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $connection = 'tenant';
    protected $table = 'mensagem';
    protected $primaryKey = 'id';
    protected $fillable = ['titulo', 'mensagem', 'idusr'];
}
