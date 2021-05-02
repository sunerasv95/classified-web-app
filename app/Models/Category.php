<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "category_name",
        "category_description",
        "category_slug",
        "is_parent",
        "parent_id",
        "status",
        "is_deleted"
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id')->where('parent_id', 0);
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
