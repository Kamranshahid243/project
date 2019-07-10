<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Widget *
 * @property  integer $id
 * @property  integer $title
 * @property  integer $color
 * @property  integer $template_url
 * @property  integer $enabled
 * @property  integer $locked
 * @property  integer $row
 * @property  integer $col
 * @property  integer $size_x
 * @property  integer $min_size_x
 * @property  integer $max_size_x
 * @property  integer $size_y
 * @property  integer $min_size_y
 * @property  integer $max_size_y
 * @property  string $status
 * @property  integer $created_at
 * @property  integer $updated_at
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereId($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereTitle($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereColor($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereTemplateUrl($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereEnabled($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereLocked($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereRow($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereCol($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereSizeX($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereMinSizeX($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereMaxSizeX($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereSizeY($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereMinSizeY($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereMaxSizeY($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereStatus($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereCreatedAt($value)
 * @method  static \Illuminate\Database\Query\Builder|\App\Widget whereUpdatedAt($value)
 */
class Widget extends Model
{
    public $guarded = ["id", "created_at", "updated_at"];
    protected $hidden = ["created_at", "updated_at"];

    public static function findRequested()
    {
        $query = Widget::query();

        // search results based on user input
        \Request::input('id') and $query->where('id', \Request::input('id'));
        \Request::input('title') and $query->where('title', 'like', '%' . \Request::input('title') . '%');
        \Request::input('color') and $query->where('color', 'like', '%' . \Request::input('color') . '%');
        \Request::input('template_url') and $query->where('template_url', 'like', '%' . \Request::input('template_url') . '%');
        \Request::input('enabled') and $query->where('enabled', \Request::input('enabled'));
        \Request::input('locked') and $query->where('locked', \Request::input('locked'));
        \Request::input('row') and $query->where('row', \Request::input('row'));
        \Request::input('col') and $query->where('col', \Request::input('col'));
        \Request::input('size_x') and $query->where('size_x', \Request::input('size_x'));
        \Request::input('min_size_x') and $query->where('min_size_x', \Request::input('min_size_x'));
        \Request::input('max_size_x') and $query->where('max_size_x', \Request::input('max_size_x'));
        \Request::input('size_y') and $query->where('size_y', \Request::input('size_y'));
        \Request::input('min_size_y') and $query->where('min_size_y', \Request::input('min_size_y'));
        \Request::input('max_size_y') and $query->where('max_size_y', \Request::input('max_size_y'));
        \Request::input('status') and $query->where('status', \Request::input('status'));
        \Request::input('created_at') and $query->where('created_at', \Request::input('created_at'));
        \Request::input('updated_at') and $query->where('updated_at', \Request::input('updated_at'));

        // sort results
        \Request::input("sort") and $query->orderBy(\Request::input("sort"), \Request::input("sortType", "asc"));

        // paginate results
        if ($resPerPage = \Request::input("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'template_url' => 'required|string|max:255',
            'enabled' => 'required',
            'locked' => 'required',
            'row' => 'integer',
            'col' => 'integer',
            'size_x' => 'required|integer',
            'min_size_x' => 'integer',
            'max_size_x' => 'integer',
            'size_y' => 'required|integer',
            'min_size_y' => 'integer',
            'max_size_y' => 'integer',
            'status' => 'in:Enabled,Disabled',
        ];

        // no list is provided
        if (!$attributes)
            return $rules;

        // a single attribute is provided
        if (!is_array($attributes))
            return [$attributes => $rules[$attributes]];

        // a list of attributes is provided
        $newRules = [];
        foreach ($attributes as $attr)
            $newRules[$attr] = $rules[$attr];
        return $newRules;
    }

    public function toArray()
    {
        $attributes = $this->attributesToArray();
        $newAttributes = [];
        foreach (array_keys($attributes) as $attribute) {
            if ($attributes[$attribute] !== null) {
                $newAttributes[camel_case($attribute)] = $attributes[$attribute];
            }
        }
        return $newAttributes;
    }

    public static function enabled()
    {
        return Widget::whereStatus("Enabled")->get();
    }
}
