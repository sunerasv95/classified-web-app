<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AddedFeature extends Model
{
    protected $fillable = [
        "feature_name",
        "status",
        "is_deleted",
        "deleted_at"
    ];

    public function board_detail(): BelongsToMany
    {
        return $this->belongsToMany(
            BoardDetails::class,
            "board_added_feature",
            "feature_id",
            "board_detail_id"
        )->withTimestamps();
    }
}
