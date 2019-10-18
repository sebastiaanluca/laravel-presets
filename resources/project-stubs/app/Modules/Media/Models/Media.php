<?php

declare(strict_types=1);

namespace Modules\Media\Models;

use Propaganistas\LaravelFakeId\RoutesWithFakeIds;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use RoutesWithFakeIds;

    /**
     * @param array $attributes
     *
     * @return string
     */
    public function render(array $attributes = []) : string
    {
        return $this->img('', $attributes);
    }

    /**
     * @return string|null
     */
    public function getUrlAttribute() : ?string
    {
        return $this->getUrl();
    }

    /**
     * @return int
     */
    public function getPublicIdAttribute() : int
    {
        return $this->getRouteKey();
    }
}
