<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Page
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PageAction[] $actions
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUrl($value)
 */
class Page extends Model
{
    public function actions()
    {
        return $this->hasMany(PageAction::class);
    }
}
