<?php

declare(strict_types=1);

namespace Modules\Database\Models;

use RuntimeException;

trait PreventsLazyLoading
{
    /**
     * Get a relationship value from a method.
     *
     * @param string $method
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    protected function getRelationshipFromMethod($method)
    {
        if ($this->shouldPreventLazyLoadingRelation($method)) {
            throw new RuntimeException(sprintf(
                'Unable to lazy load relation %s in model %s',
                $method,
                static::class,
            ));
        }

        return parent::getRelationshipFromMethod($method);
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    protected function shouldPreventLazyLoadingRelation(string $method) : bool
    {
        return $this->exists
            && config('database.prevent_lazy_loading_relations')
            && (property_exists($this, 'allowedLazyLoadRelations') && ! in_array($method, $this->allowedLazyLoadRelations, true));
    }
}
