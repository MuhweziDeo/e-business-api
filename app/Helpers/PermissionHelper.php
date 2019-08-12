<?php

namespace App\Helpers;

use App\User;

class PermissionHelper
{
    public static function IsOwner(User $current_user, $owner_uuid)
    {

        return $current_user->uuid === $owner_uuid;
    }
}
