<?php

if (!function_exists('infy_tab')) {
	function infy_tab($spaces = 4)
	{
			return str_repeat(' ', $spaces);
	}
}

if (!function_exists('infy_tabs')) {
	function infy_tabs($tabs, $spaces = 4)
	{
			return str_repeat(infy_tab($spaces), $tabs);
	}
}

if (!function_exists('infy_nl')) {
	function infy_nl($count = 1)
	{
			return str_repeat(PHP_EOL, $count);
	}
}

if (!function_exists('infy_nls')) {
	function infy_nls($count, $nls = 1)
	{
			return str_repeat(infy_nl($nls), $count);
	}
}

if (!function_exists('infy_nl_tab')) {
	function infy_nl_tab($lns = 1, $tabs = 1)
	{
			return infy_nls($lns).infy_tabs($tabs);
	}
}

function underscore_to_space($text) {
	$text = str_replace("_", " ", $text);
	return $text;
}

function route_admin($name, $params=[]) {
    return route(route_admin_name($name), $params);
}

function route_admin_name($name) {
    return $name;
}

function roles_badge($names) 
{
    $output = '';

    foreach($names as $name) {
        $output .= '<div class="badge badge-primary mr-1">'. $name .'</div>';
    }

    return $output;
}

function is_request_name($name, $prefix=null) 
{
    if(!$prefix) $prefix = 'admin';

    return Request::route()->getName() == $prefix . '.' . $name;
}

function is_request_path($path, $prefix=null)
{
    if(!$prefix) $prefix = 'backend';

    return Request::is($prefix .'/' . $path);
}

function url_segments()
{
	return Request::segments();
}

function setting($get, $set=false) 
{
    if($set)
        return Setting::set($get, $set);

    return Setting::get($get);
}

function is_setting_avail($get) 
{
    return Setting::check($get);
}

function field($type, $data=[])
{

    if(is_array($type))
    {
        $data = $type;
        $type = $data['type'];
        $data = array_except($data, ['type']);
    }

    $field = new Fields\Field($type);

    return $field->run($data);
}

function media($p = '/') 
{
    return url(media_path() . '/' . $p);
}

function images($file) 
{
    return media(config("starter.paths.images") . '/' . $file);
}

function images_path($file)
{
    return storage_path('app/public/' . media_path() . '/' . config('starter.paths.images') . (!$file ?: '/' . $file));
}

function files($file) 
{
    return media(config("starter.paths.files") . '/' . $file);
}

function path() 
{
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      return "\\";
  } else {
      return "/";
  }
}

function media_path() 
{
    return config("starter.paths.media");
}

function activity_subject($subject_type)
{
    $reflection = new ReflectionClass($subject_type);
    $subject = $reflection->getShortName();

    return $subject;
}

function activity_desc($activity)
{
    $subject = activity_subject($activity->subject_type);

    switch ($activity->description) {
        case 'created':
            return $activity->causer->name . ' created a new ' . $subject;
            break;
        
        case 'updated':
            return $activity->causer->name . ' has updated a ' . $subject;
            break;
        
        case 'deleted':
            return $activity->causer->name . ' has deleted a ' . $subject;
            break;
        
        case 'login':
            return $activity->causer->name . ' has logged in';
            break;
        
        case 'logout':
            return $activity->causer->name . ' has logged out';
            break;

        case 'register':
            return $activity->causer->name . ' registered successfully';
            break;
        
        default:
            # code...
            break;
    }
}

function activity_icon($desc)
{
    switch ($desc) {
        case 'created':
            return 'fas fa-pen-alt';
            break;

        case 'updated':
            return 'fas fa-sync';
            break;

        case 'deleted':
            return 'fas fa-trash';
            break;

        case 'login':
            return 'fas fa-sign-in-alt';
            break;
        
        case 'logout':
            return 'fas fa-sign-out-alt';
            break;
        
        case 'register':
            return 'fas fa-user-plus';
            break;
        
        default:
            # code...
            break;
    }
}

function activity_color($desc)
{
    switch ($desc) {
        case 'created':
            return 'primary';
            break;

        case 'updated':
            return 'info';
            break;

        case 'deleted':
            return 'danger';
            break;

        case 'login':
            return 'info';
            break;
        
        case 'logout':
            return 'info';
            break;
        
        case 'register':
            return 'info';
            break;
        
        default:
            # code...
            break;
    }
}

function activity_detail($string)
{
    $json = json_decode($string);

    if(optional($json)->attributes) 
    {
        $html = '<pre data-label="Data" class="highlight"><code>';
        foreach($json->attributes as $k => $v)
        {
            $html .= $k . ': ' . e(json_encode($v)) . '<br>';
        }
        $html .= '</code></pre>';
    }

    if(optional($json)->old) 
    {
        $html .= '<pre data-label="Old" class="highlight"><code>';
        foreach($json->old as $k => $v)
        {
            $html .= $k . ': ' . e(json_encode($v)) . '<br>';
        }
        $html .= '</code></pre>';
    }

    return $html;
}