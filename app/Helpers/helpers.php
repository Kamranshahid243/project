<?php
function toStr($var)
{
    return var_export($var, true);
}

/**
 * @param $content
 * @param string $file
 * @param bool|false $overwrite
 * Logs the $content to app_path/storage/logs/$file
 * If $content is not a string, it will be json encoded and then written
 */
function logContent($content, $file = "general.log", $overwrite = false)
{
    try {
        $dir = storage_path("logs/");
        $path = $dir . $file;
        $prevContent = "";

        if (!$overwrite && file_exists($path))
            $prevContent = file_get_contents($path);

        if (!is_string($content))
            $content = json_encode($content);

        $content = $prevContent . date("Y-m-d H:i:s => \n") . $content . "\n";
        file_put_contents($path, $content);
    } catch (Exception $e) {
        Log::error("Error occurred while logging content: " . $e->getTraceAsString());
    }
}

function areSet($keys, $array)
{
    if (!is_array($keys))
        return array_key_exists($keys, $array);
    if (!is_array($array))
        return false;
    $result = true;
    foreach ($keys as $key)
        if (!array_key_exists( $key, $array )) {
            $result = false;
        }
    return $result;
}

function pr($obj, $label = '')
{
    echo "<hr><b>" . $label . ":</b>";
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

function pr_exit($obj, $label = '')
{
    pr($obj, $label);
    exit;
}

function pEcho($str)
{
    echo "<p>$str</p>";
}