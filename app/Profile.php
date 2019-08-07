<?php

namespace App;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    //
    protected $fillable = [
        'user_uuid',
        'first_name',
        'last_name',
        'image',
        'country',
        'city',
        'location'
        ];

    /**
     * @param array $data
     * @return array
     */
    public static function validate(Array $data)
    {
        $rules = [
            'first_name' => 'string|min:3',
            'last_name' => 'string|min:3',
            'image' => 'string',
            'country' => 'string|min:3',
            'location' => 'string'

        ];
        return Helpers::validate($data, $rules);
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function updateProfile($data)
    {
        return Profile::where('user_uuid', $data['user_uuid'])
                        ->update($data);
    }

    
}
