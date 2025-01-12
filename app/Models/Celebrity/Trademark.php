<?php

namespace App\Models\Celebrity;

use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $trademark_uz
 * @property string $trademark_uz_cy
 * @property string $trademark_ru
 * @property string $trademark_en
 * @property int $celebrity_id
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $trivia
 *
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class Trademark extends BaseModel
{
    use HasFactory;

    protected $table = 'celebrity_trademarks';

    protected $fillable = ['trademark_uz', 'trademark_uz_cy', 'trademark_ru', 'trademark_en', 'celebrity_id'];

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo(int $id): bool
    {
        return $this->id === $id;
    }


    ########################################### Mutators

    public function getNameAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getTrademark($this));
    }

    ###########################################


    ########################################### Relations

    public function celebrity(): BelongsTo|Celebrity
    {
        return $this->belongsTo(Celebrity::class, 'celebrity_id', 'id');
    }

    public function createdBy(): BelongsTo|User
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo|User
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    ###########################################
}
