<?php

namespace App\Models;

use App\Events\UserDeletingEvent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $attributes = [
        'user_mode' => UserMode::TRANSLATOR,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_mode',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $dispatchesEvents = [
        'deleting' => UserDeletingEvent::class,
    ];

    public static function deletedUser()
    {
        $user = new static([
            'name' => __('Deleted User'),
        ]);

        return $user;
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function sources()
    {
        return $this->hasMany(Source::class, 'author_id', 'id');
    }

    public function translationRequests()
    {
        return $this->hasMany(TranslationRequest::class, 'translator_id', 'id');
    }

    public function claimedTranslationRequests()
    {
        return $this->translationRequests()->where('status', TranslationRequestStatus::CLAIMED);
    }

    public function completedTranslationRequests()
    {
        return $this->translationRequests()->where('status', TranslationRequestStatus::COMPLETE);
    }

    public function speaksLanguage(int $languageId)
    {
        return $this->languages()->wherePivot('language_id', $languageId)->exists();
    }

    public function isInAuthorMode() {
        return $this->user_mode === UserMode::AUTHOR;
    }

    public function switchUserMode() {
        if ($this->isInAuthorMode()) {
            $this->update(['user_mode' => UserMode::TRANSLATOR]);
        } else {
            $this->update(['user_mode' => UserMode::AUTHOR]);
        }
    }
}
