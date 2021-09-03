<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    //protected $incrementing = false;

    protected $fillable = [
        "category_name",
        "category_description",
        "category_slug",
        "category_code",
        "is_parent",
        "parent_id",
        "status",
        "is_deleted",
        "deleted_at"
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'category_id');
    }
}
