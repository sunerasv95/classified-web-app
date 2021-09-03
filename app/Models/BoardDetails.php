<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BoardDetails extends Model
{

    protected $touches = ['skill_levels'];

    protected $fillable = [
        "length_ft",
        "length_in",
        "width_in",
        "thickness_cm",
        "rail_cm",
        "volume_ltr",
        "capacity_lbs",
        "material_id",
        "fin_type_id",
        "brand_id",
        "status",
        "is_deleted",
        "deleted_at"
    ];

    public function listing()
    {
        return $this->morphOne(Listing::class, "detailable");
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function fin_type() : BelongsTo
    {
        return $this->belongsTo(FinType::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function wave_type(): BelongsToMany
    {
        return $this->belongsToMany(
            WaveType::class,
            "board_wave_type",
            "board_detail_id",
            "wave_type_id"
        )->withTimestamps();
    }

    public function skill_levels(): BelongsToMany
    {
        return $this->belongsToMany(
            SkillLevel::class,
            "board_skill_level",
            "board_detail_id",
            "skill_level_id"
        )->withTimestamps();
    }

    public function added_features(): BelongsToMany
    {
        return $this->belongsToMany(
            AddedFeature::class,
            "board_added_feature",
            "board_detail_id",
            "feature_id"
        )->withTimestamps();
    }
}
