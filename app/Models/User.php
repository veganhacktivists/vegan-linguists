<?php

namespace App\Models;

use App\Events\UserDeletingEvent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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

    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=B6674B&background=fff';
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class)->orderByName();
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

    public function translationRequestsClaimedForReview()
    {
        return $this->belongsToMany(
            TranslationRequest::class,
            'reviewer_translation_request',
            'reviewer_id',
            'translation_request_id'
        );
    }

    public function completedTranslationRequests()
    {
        return $this->translationRequests()->complete();
    }

    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }

    public function notificationSettings()
    {
        return $this->hasMany(NotificationSetting::class);
    }

    public function speaksLanguages(iterable $languageIds)
    {
        if ($this->relationLoaded('languages')) {
            return $this->languages->whereIn(['pivot', 'language_id'], $languageIds)->count() === count($languageIds);
        }

        return $this->languages()->wherePivotIn('language_id', $languageIds)->count() === count($languageIds);
    }

    public function getDefaultTargetLanguagesAttribute()
    {
        $setting = $this->settings()->where('setting_key', UserSettingKeys::DEFAULT_TARGET_LANGUAGES)->first();

        return $setting ? Language::whereIn('id', json_decode($setting->setting_value))->orderByName()->get() : collect();
    }

    public function setDefaultTargetLanguagesAttribute(iterable $languages)
    {
        $setting = UserSetting::firstOrNew([
            'user_id' => $this->id,
            'setting_key' => UserSettingKeys::DEFAULT_TARGET_LANGUAGES,
        ]);

        $setting->setting_value = json_encode($languages);
        $setting->save();
    }

    public function getNumClaimedTranslationRequestsCount()
    {
        if ($this->relationLoaded('claimedTranslationRequests')) {
            return $this->claimedTranslationRequests->count();
        }

        return $this->claimedTranslationRequests()->count();
    }

    public function isInAuthorMode()
    {
        return $this->user_mode === UserMode::AUTHOR;
    }

    public function isOnboarded()
    {
        // This function only gets called in middlewares, so we might as well load the relationship
        // to save potential queries later
        return $this->languages->count() > 0;
    }

    public function switchUserMode()
    {
        if ($this->isInAuthorMode()) {
            $this->update(['user_mode' => UserMode::TRANSLATOR]);
        } else {
            $this->update(['user_mode' => UserMode::AUTHOR]);
        }
    }

    public function shouldBeNotified(string $notificationType, string $medium)
    {
        if ($medium !== 'email' && $medium !== 'site') {
            abort(500, __('Something went terribly wrong'));
        }

        $notificationSetting = $this->notificationSettings()->where('notification_type', $notificationType)->firstOrNew([
            'notification_type' => $notificationType
        ]);

        return $notificationSetting->$medium;
    }

    public function scopeWhereHasVerifiedEmail(Builder $query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeWhereSpeaksMultipleLanguages(Builder $query)
    {
        return $query->has('languages', '>', 1);
    }
}
