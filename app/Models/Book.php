<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;
    public function reviews()
    {
        return $this->hasMany(Review::class);

    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('reviews')->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query): Builder
    {
        return $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');

    }

    //"select `books`.*, (select count(*) from `reviews` where `books`.`id` = `reviews`.`book_id`) as `reviews_count`, (select avg(`reviews`.`rating`) from `reviews` where `books`.`id` = `reviews`.`book_id`) as `reviews_avg_rating` from `books` order by `reviews_count` desc, `reviews_avg_rating` desc"
}
