<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_no',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'authtoken'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**Get a user specified by Id */
    public function getUser($id)
    {
        $user = $this::findOrFail($id);
        return $user;
    }

    /**Add a user */
    public function addUser($fields)
    {
        $name = $fields['firstName'] . " " . $fields['secondName'];

        $this->name = $name;
        $this->email = $fields['email'];
        $this->password = bcrypt($fields['password']);
        $this->phone_no = $fields['phone_no'];

        /**Save user to db */
        $this->save();

        /**return result */
        return $this;
    }

    /**Update a User specified by Id */
    public function updateUser($fields, $id)
    {
        /**find user */
        $user = $this::findOrFail($id);

        /**Create variables */
        $firstName = $fields['firstName'] ?? null;
        $secondName = $fields['secondName'] ?? null;
        $email = $fields['email'] ?? null;
        $password = bcrypt($fields['password']) ?? null;
        $phone_no = $fields['phone_no'] ?? null;

        /** Update fields if they exist in the $fields array */
        if (isset($firstName) || isset($secondName)) {
            $name = $firstName . " " . $secondName;
            $user->name = $name;
        }
        if (isset($email)) {
            $user->email = $email;
        }
        if (isset($password)) {
            $user->password = $password;
        }
        if (isset($phone_no)) {
            $user->phone_no = $phone_no;
        }

        /** Save user to database */
        $user->save();

        /** Return updated user */
        return $user;

    }

    /**Delete a user specified by Id */
    public function deleteUser($id)
    {
        $user = $this::findOrFail($id);
        $user->delete();
        return $user;
    }
}
