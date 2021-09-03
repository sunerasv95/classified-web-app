<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinType extends Model
{
    protected $fillable = [
        "fin_type_name",
        "is_deleted",
        "deleted_at"
    ];

    //protected $incrementing = false;

    public function board_detail()
    {
        return $this->hasOne(BoardDetails::class);
    }
}
