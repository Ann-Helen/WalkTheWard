<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $areaId
 * @property int $themeId
 * @property string $created_at
 * @property string $updated_at
 * @property Area $area
 * @property Theme $theme
 * @property BonusGameInGame[] $bonusGameInGames
 * @property Patient[] $patients
 * @property PlaceInGame[] $placeInGames
 * @property QuestionsInGame[] $questionsInGames
 */
class games extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['areaId', 'themeId', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo('App\Area', 'areaId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme()
    {
        return $this->belongsTo('App\Theme', 'themeId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bonusGameInGames()
    {
        return $this->hasMany('App\BonusGameInGame', 'gameId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patients()
    {
        return $this->hasMany('App\Patient', 'gameId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function placeInGames()
    {
        return $this->hasMany('App\PlaceInGame', 'gameId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionsInGames()
    {
        return $this->hasMany('App\QuestionsInGame', 'gameId');
    }
}
