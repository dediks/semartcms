<?php

namespace App\Traits;

use Storage;
use Auth;
use Role;

trait UserTrait 
{
    public function getProfilelinkAttribute()
    {
        return route('users.edit', 1);
    }

    public function getAvatarlinkAttribute()
    {
        $path = images_path($this->avatar);

        if(file_exists($path))
        {
            return images('thumbs-100/' . $this->avatar);
        }
        return asset('assets/img/avatar/avatar-1.png');
    }

    public function getIsmeAttribute()
    {
        if(Auth::check() && Auth::id() == $this->id)
        {
            return true;
        }
        return false;
    }
}
