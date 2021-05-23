<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Node\FunctionNode;

class BoardDetails extends Model
{
    protected $touches = ['skill_levels'];

    //protected $incrementing = false;

    protected $fillable = [
        "width",
        "length",
        "thickness",
        "rail",
        "volume",
        "wave_type_id",
        "material_id",
        "fin_type_id",
        "brand_id",
        "functionalities",
        "status",
        "is_deleted"
    ];

    public function listing()
    {
        return $this->morphOne(Listing::class, "detailable");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function fin_type()
    {
        return $this->belongsTo(FinType::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function wave_type()
    {
        return $this->belongsTo(WaveType::class);
    }

    public function skill_levels()
    {
        return $this->belongsToMany(SkillLevel::class, "board_skill_level", "board_detail_id", "skill_level_id")
            ->withTimestamps();
    }
}
