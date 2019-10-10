<?php

declare (strict_types=1);

namespace Domain\Auth\Models;

use Modules\Database\Models\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notification;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $allowedLazyLoadRelations = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param string $email
     *
     * @return $this|null
     */
    public static function findByEmail(string $email) : ?User
    {
        return static::where('email', $email)->first();
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return array|string
     */
    public function routeNotificationForMail(Notification $notification) : array
    {
        return [
            $this->email => $this->name,
        ];
    }

    /**
     * @return string
     */
    public function getNameAttribute() : string
    {
        return collect([
            $this->first_name,
            $this->last_name,
        ])
            ->reject(null)
            ->implode(' ');
    }

    /**
     * @param string|null $value
     *
     * @return void
     */
    public function setPasswordAttribute(?string $value) : void
    {
        $this->attributes['password'] = $value !== null
            ? app(Hasher::class)->make($value)
            : null;
    }

    /**
     * @return bool
     */
    public function getHasPasswordAttribute() : bool
    {
        return $this->attributes['password'] !== null;
    }
}
