<?php

declare(strict_types=1);

namespace Modules\Database\Models;

use Propaganistas\LaravelFakeId\RoutesWithFakeIds;
use SebastiaanLuca\BooleanDates\HasBooleanDates;
use SebastiaanLuca\Flow\Models\Model;

abstract class BaseModel extends Model
{
    use PreventsLazyLoading;
    use RoutesWithFakeIds;
    use HasBooleanDates;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * @return int
     */
    public function getPublicIdAttribute() : int
    {
        return $this->getRouteKey();
    }

    /**
     * Save the model to the database if it doesn't exist yet.
     *
     * @return void
     */
    protected function ensureModelExists() : void
    {
        if ($this->exists) {
            return;
        }

        $this->save();
    }
}
