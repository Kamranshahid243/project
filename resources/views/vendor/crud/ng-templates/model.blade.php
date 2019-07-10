<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
<?='<?php'?>

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\<?=$gen->modelClassName()?>

 *
@foreach ( $fields as $field )
 * @property integer ${{$field->name}}
@endforeach
@foreach ( $fields as $field )
 * @method static \Illuminate\Database\Query\Builder|<?=$gen->modelClassName()?> where{{studly_case($field->name)}}($value)
@endforeach
 */
class <?=$gen->modelClassName()?> extends Model {
    public $guarded = ["id","created_at","updated_at"];
    public static $bulkEditableFields = ['<?php
        $data = collect($fields)->filter(function ($field) {
            return !in_array($field->name, config('crud.skipped-fields'));
        })->pluck('name')->all();
        echo join("', '", $data);
?>'];
    <?php if (!collect($fields)->where('name', 'created_at')->count()) { ?>
public $timestamps = false;
    <?php } ?>

    public static function findRequested()
    {
        $query = <?=$gen->modelClassName()?>::query();

        // search results based on user input
        @foreach ( $fields as $field )
if (\Request::has('{{$field->name}}')) $query->where({!! \Nvd\Crud\Db::getConditionStr($field) !!});
        @endforeach

        // sort results
        if (\Request::has("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public static function validationRules( $attributes = null )
    {
        $rules = [
@foreach ( $fields as $field )
@if( $rule = \Nvd\Crud\Db::getValidationRule( $field ) )
            {!! $rule !!}
@endif
@endforeach
        ];

        // no list is provided
        if(!$attributes)
            return $rules;

        // a single attribute is provided
        if(!is_array($attributes))
            return [ $attributes => $rules[$attributes] ];

        // a list of attributes is provided
        $newRules = [];
        foreach ( $attributes as $attr )
            $newRules[$attr] = $rules[$attr];
        return $newRules;
    }

}
