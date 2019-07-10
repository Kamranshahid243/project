<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
?>
<?='<?php'?>

namespace App\Http\Controllers;

use App\{{$gen->modelClassName()}};
use Illuminate\Http\Request;

class {{$gen->controllerClassName()}} extends Controller
{
    public $viewDir = "{{$gen->viewsDirName()}}";

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return {{$gen->modelClassName()}}::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, {{$gen->modelClassName()}}::validationRules());
        return {{$gen->modelClassName()}}::create($request->all());
    }

    public function update(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        if ($request->wantsJson()) {
            $this->validateUpdatedRequest($request->name, $request->value);
            $data = [$request->name => $request->value];
            ${{$gen->modelVariableName()}}->update($data);
            return "{{$gen->modelClassName()}} updated.";
        }

        $this->validate($request, {{$gen->modelClassName()}}::validationRules());
        ${{$gen->modelVariableName()}}->update($request->all());
        return redirect('/{{$gen->route()}}');
    }

    public function destroy(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        ${{$gen->modelVariableName()}}->delete();
        return "{{$gen->titleSingular()}} deleted";
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if(!$items) {
            abort(403, "Please select some items.");
        }

        if(!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        {{$gen->modelClassName()}}::whereIn('id', $ids)->delete();
        return response("Deleted");
    }

    public function bulkEdit(Request $request)
    {
        if (!$field = $request->field) {
            abort(403, "Invalid request. Please provide a field.");
        }

        if (!$fieldName = array_get($field, 'name')) {
            abort(403, "Invalid request. Please provide a field name.");
        }

        if (!in_array($fieldName, {{$gen->modelClassName()}}::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if(!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if(!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        $this->validateUpdatedRequest($fieldName, array_get($field, 'value'));

        {{$gen->modelClassName()}}::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
        return response("Updated");
    }

    protected function view($view, $data = [])
    {
        return view($this->viewDir.".".$view, $data);
    }

    protected function validateUpdatedRequest($field, $value)
    {
        $data = [$field => $value];
        $validator = \Validator::make($data, {{$gen->modelClassName()}}::validationRules($field));
        if ($validator->fails())
            abort(403, $validator->errors()->first($field));
    }

    public function create()
    {
        abort(404);
    }

    public function show(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        abort(404);
    }

    public function edit(Request $request, {{$gen->modelClassName()}} ${{$gen->modelVariableName()}})
    {
        abort(404);
    }

}
