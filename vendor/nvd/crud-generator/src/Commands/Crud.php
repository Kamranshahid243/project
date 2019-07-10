<?php

namespace Nvd\Crud\Commands;

use Illuminate\Console\Command;
use Nvd\Crud\Db;

class Crud extends Command
{
    public $tableName;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nvd:crud
        {tableName : The name of the table you want to generate crud for.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate crud for a specific table in the database';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->tableName = $this->argument('tableName');
        $this->generateModel();
        $this->generateRouteModelBinding();
        $this->generateRoute();
        $this->generateController();
        $this->generateViews();
    }

    public function generateRouteModelBinding()
    {
        $declaration = "\$router->model('".$this->route()."', 'App\\".$this->modelClassName()."');";
        $declaration2 = "app('router')->model('".$this->route()."', 'App\\".$this->modelClassName()."');";
        $providerFile = app_path('Providers/RouteServiceProvider.php');
        $fileContent = file_get_contents($providerFile);

        if (strpos($fileContent, $declaration) == false && strpos($fileContent, $declaration2) == false)
        {
            $regex = "/(public\s*function\s*boot\s*\(\s*Router\s*.router\s*\)\s*\{)/";
            // if above regex fails, try new one as in version > 5.3
            if(!preg_match($regex, $fileContent)) {
                $regex = "/(public\s*function\s*boot\s*\(\)\s*\{)/";
                $declaration = $declaration2;
            }

            if(preg_match($regex, $fileContent))
            {
                $fileContent = preg_replace( $regex, "$1\n\t\t".$declaration, $fileContent );
                file_put_contents($providerFile, $fileContent);
                $this->info("Route model binding inserted successfully in ".$providerFile);
                return true;
            }

            // match was not found for some reason
            $this->warn("Could not add route model binding for the route '".$this->route()."'.");
            $this->warn("Please add the following line manually in {$providerFile}:");
            $this->warn($declaration);
            return false;
        }

        // already exists
        $this->info("Model binding for the route: '".$this->route()."' already exists.");
        $this->info("Skipping...");
        return false;
    }

    public function generateRoute()
    {
        $route = "Route::resource('{$this->route()}', '{$this->controllerClassName()}');";

        // get extra routes if defined
        if($routes = config('crud.extra-routes')) {
            if(is_array($routes)) {
                $routes[] = $route;
            } else {
                $routes = [$route];
            }
        }

        $routesFile = base_path(config('crud.routes-file'));
        if (!file_exists($routesFile)) {
            $this->error("Routes file: {$routesFile} does not exist. Please change routes-file in the config file.");
            return false;
        }

        foreach ($routes as $route) {
            $route = str_replace('{{route}}', $this->route(), $route);
            $route = str_replace('{{controller}}', $this->controllerClassName(), $route);
            $routesFileContent = file_get_contents($routesFile);
            if (strpos($routesFileContent, $route) == false) {
                $routesFileContent = $this->getUpdatedContent($routesFileContent, $route);
                file_put_contents($routesFile, $routesFileContent);
                $this->info("created route: " . $route);
            } else {
                $this->info("Route: '" . $route . "' already exists.");
                $this->info("Skipping...");
            }
        }
        return true;
    }

    protected function getUpdatedContent ( $existingContent, $route )
    {
        // check if the user has directed to add routes
        $str = "nvd-crud routes go here";
        if( strpos( $existingContent, $str ) !== false )
            return str_replace( $str, "{$str}\n\t\t".$route, $existingContent );
        else
            $route = "// {$str}\n\t\t" . $route;

        // check for 'web' middleware group
        $regex = "/(Route\s*\:\:\s*group\s*\(\s*\[\s*\'middleware\'\s*\=\>\s*\[\s*\'web\'\s*\]\s*\]\s*\,\s*function\s*\(\s*\)\s*\{)/";
        if( preg_match( $regex, $existingContent ) )
            return preg_replace( $regex, "$1\n\t".$route, $existingContent );

        // if there is no 'web' middleware group
        return $existingContent."\n".$route;
    }

    public function generateController()
    {
        $controllerFile = $this->controllersDir().'/'.$this->controllerClassName().".php";

        if($this->confirmOverwrite($controllerFile))
        {
            $content = view($this->templatesDir().'.controller',['gen' => $this]);
            file_put_contents($controllerFile, $content);
            $this->info( $this->controllerClassName()." generated successfully." );
        }
    }

    public function generateModel()
    {
        $modelFile = $this->modelsDir().'/'.$this->modelClassName().".php";

        if($this->confirmOverwrite($modelFile))
        {
            $content = view( $this->templatesDir().'.model', [
                'gen' => $this,
                'fields' => Db::fields($this->tableName)
            ]);
            file_put_contents($modelFile, $content);
            $this->info( "Model class ".$this->modelClassName()." generated successfully." );
        }
    }

    public function generateViews()
    {
        if( !file_exists($this->viewsDir()) ) mkdir($this->viewsDir());
        foreach ( config('crud.views') as $view ){
            $generatedViewName = $view;
            if($view == 'ng-app') {
                $generatedViewName = $this->viewsDirName()."-".$view;
            }
            $viewFile = $this->viewsDir()."/". $generatedViewName.".blade.php";
            if($this->confirmOverwrite($viewFile))
            {
                $content = view( $this->templatesDir().'.views.'.$view, [
                    'gen' => $this,
                    'fields' => Db::fields($this->tableName)
                ]);

                file_put_contents($viewFile, $content);
                $this->info( "View file ". $generatedViewName ." generated successfully." );
            }
        }
    }

    protected function confirmOverwrite($file)
    {
        // if file does not already exist, return
        if( !file_exists($file) ) return true;

        // file exists, get confirmation
        if ($this->confirm($file.' already exists! Do you wish to overwrite this file? [y|N]')) {
            $this->info("overwriting...");
            return true;
        }
        else{
            $this->info("Using existing file ...");
            return false;
        }
    }

    public function route()
    {
        return str_slug(str_replace("_"," ", str_singular($this->tableName)));
    }

    public function controllerClassName()
    {
        return studly_case(str_singular($this->tableName))."Controller";
    }

    public function viewsDir()
    {
        return base_path('resources/views/'.$this->viewsDirName());
    }

    public function viewsDirName()
    {
        return str_singular($this->tableName);
    }

    public function controllersDir()
    {
        return app_path('Http/Controllers');
    }

    public function modelsDir()
    {
        return app_path();
    }

    public function modelClassName()
    {
        return studly_case(str_singular($this->tableName));
    }

    public function modelVariableName()
    {
        return camel_case(str_singular($this->tableName));
    }

    public function titleSingular()
    {
        return ucwords(str_singular(str_replace("_", " ", $this->tableName)));
    }

    public function titlePlural()
    {
        return ucwords(str_replace("_", " ", $this->tableName));
    }

    public function templatesDir()
    {
        return config('crud.templates');
    }

}
