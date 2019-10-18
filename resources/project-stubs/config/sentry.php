<?php

return [

    'dsn' => env('SENTRY_DSN'),

    'release' => static function () : ?string {
        $commitHash = base_path('.commit_hash');

        if (file_exists($commitHash)) {
            return trim(exec(sprintf('cat %s', $commitHash)));
        }

        if (is_dir(base_path('.git'))) {
            return trim(exec('git log --pretty="%H" -n1 HEAD'));
        }

        return null;
    },

    'breadcrumbs' => [
        'sql_bindings' => true,
    ],

];
