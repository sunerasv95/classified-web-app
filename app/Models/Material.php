<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //protected $incrementing = false;

    public function board_detail()
    {
        return $this->hasOne(BoardDetails::class);
    }
}
