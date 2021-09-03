<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //protected $incrementing = false;
    protected $fillable = [
        "material_name",
        "description",
        "is_deleted",
        "deleted_at"
    ];

    public function board_detail()
    {
        return $this->hasOne(BoardDetails::class);
    }
}
