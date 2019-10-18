<?php

declare(strict_types=1);

namespace Analytics\Exceptions;

final class TrackingException extends AnalyticsException
{
    /**
     * @param string $code
     * @param string $key
     *
     * @return \Analytics\Exceptions\TrackingException
     */
    public static function trackingCodeNotTranslated(string $code, string $key) : self
    {
        return new self(sprintf(
            'No translation has been defined for tracking code "%s" and translation key "%s"',
            $code,
            $key
        ));
    }
}
