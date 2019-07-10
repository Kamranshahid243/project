<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PageAction
 *
 * @property integer $id
 * @property string $title
 * @property string $method
 * @property string $route
 * @property integer $page_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Page $page
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserRole[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\PageAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageAction whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageAction whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageAction wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageAction whereRoute($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageAction whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageAction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageAction extends Model
{
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function roles()
    {
        return $this->belongsToMany(UserRole::class)->withTimestamps();
    }
}
