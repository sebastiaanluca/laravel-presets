<?php

namespace SebastiaanLuca\Preset\Presets;

use Illuminate\Filesystem\Filesystem;
use Modules\Auth\Middleware\AuthenticateOnceWithBasicAuth;
use function SebastiaanLuca\Preset\handle_filesystem_errors;

class ApiPreset extends Preset
{
    /**
     * Run the preset.
     *
     * @return void
     */
    public function run() : void
    {
        // DONE: composer require laravel/passport
        // DONE: Copy custom migrations (UUID, current date and time)
        // DONE: Add and copy migration to create OAuth clients
        //  Default (authorization grant via auth approval screen): php artisan passport:client
        //  Password grant (for first-party clients with users): php artisan passport:client --password
        //  Client credentials grant (for machine-to-machine authentication): php artisan passport:client --client
        //  Personal access tokens (let users issue tokens to themselves): php artisan passport:client --personal
        //  Just create and let artisan output their keys (you want different keys per environment)
        // DONE: php artisan vendor:publish --tag=passport-views
        // DONE: Copy API interface directory to src/Interfaces
        // TODO: Add and copy API tests directory to tests/Interfaces/Api
        // DONE: Register API service provider in app config
        // DONE: Change auth API driver to use `passport`
        // DONE: Add HasApiTokens trait to user model
        // DONE: Add the various middleware to the api middleware in the HTTP kernel and set its priority
        // TODO: Add a command to generate oauth keys in /tmp and output them as strings for use in the .env file (add command to Cli interface) (or immediately write to .env file if not yet there, or with --force)
        // TODO: When setting up via the preset, automatically add the generated string (both keys) to the .env file (using the command's --write option)
        // DONE: Ask the user to run `php artisan migrate` after reviewing the created files
        // DONE: Ask user to check the ApiRouter to enable whatever grants they want to want to use

        $this->call('composer require laravel/passport');
        $this->call('php artisan vendor:publish --tag=passport-views');

        $this->copyConfiguration();
        $this->copyMigrations();
        $this->copyInterface();
        $this->registerProvider();
        $this->registerAuthGuard();
        $this->registerUserTrait();
        $this->registerKernelMiddlewares();

        $this->command->info('🎉 API successfully scaffolded!');
        $this->command->info('➡️ After reviewing the changes, run `php artisan migrate` to commit these to your database.');
        $this->command->comment('Based on your requirements, you can add a migration to create your one-time personal OAuth clients or opt to let your users create these manually themselves.');
        $this->command->comment('See https://laravel.com/docs/passport for more information.');
    }

    protected function copyMigrations() : void
    {
        $filesystem = new Filesystem;

        foreach ($filesystem->files(__DIR__ . '/../../resources/api/migrations') as $file) {
            handle_filesystem_errors(
                $filesystem->copy(
                    $file->getPathname(),
                    database_path('migrations/' . now()->format('Y_m_d_') . $file->getFilename())
                )
            );
        }
    }

    protected function copyConfiguration() : void
    {
        handle_filesystem_errors(
            (new Filesystem)->copy(
                __DIR__ . '/../../resources/api/config/passport.php',
                config_path('passport.php')
            )
        );
    }

    protected function copyInterface() : void
    {
        handle_filesystem_errors(
            (new Filesystem)->copyDirectory(
                __DIR__ . '/../../resources/api/Interfaces/Api',
                base_path('app/Interfaces/Api')
            )
        );
    }

    protected function registerProvider() : void
    {
        $filesystem = new Filesystem;

        $path = config_path('app.php');

        $config = $filesystem->get($path);

        $find = <<<TEXT
                Interfaces\Cli\Providers\CliServiceProvider::class,
        TEXT;

        $replace = <<<TEXT
                Interfaces\Api\Providers\ApiServiceProvider::class,
                Interfaces\Cli\Providers\CliServiceProvider::class,
        TEXT;

        $config = str_replace($find, $replace, $config);

        $filesystem->put($path, $config);
    }

    protected function registerAuthGuard() : void
    {
        $filesystem = new Filesystem;

        $path = config_path('auth.php');

        $config = $filesystem->get($path);

        $find = <<<TEXT
        'driver' => 'token',
        TEXT;

        $replace = <<<TEXT
        'driver' => 'passport',
        TEXT;

        $config = str_replace($find, $replace, $config);

        $filesystem->put($path, $config);
    }

    protected function registerUserTrait() : void
    {
        $filesystem = new Filesystem;

        $path = base_path('app/Domain/Auth/Models/User.php');

        $config = $filesystem->get($path);

        $searchImport = <<<TEXT
        use Modules\Eloquent\Models\Model;
        TEXT;

        $replaceImport = <<<TEXT
        use Laravel\Passport\HasApiTokens;
        use Modules\Eloquent\Models\Model;
        TEXT;

        $searchTrait = <<<TEXT
            use SoftDeletes;
        TEXT;

        $replaceTrait = <<<TEXT
            use SoftDeletes;
            use HasApiTokens;
        TEXT;

        $replacements = [
            $searchImport => $replaceImport,
            $searchTrait => $replaceTrait,
        ];

        $config = $this->replace($replacements, $config);

        $filesystem->put($path, $config);
    }

    protected function registerKernelMiddlewares() : void
    {
        $filesystem = new Filesystem;

        $path = base_path('app/Framework/Http/Kernel.php');

        $config = $filesystem->get($path);

        $searchImport = <<<TEXT
        use Illuminate\View\Middleware\ShareErrorsFromSession;
        TEXT;

        $replaceImport = <<<TEXT
        use Illuminate\View\Middleware\ShareErrorsFromSession;
        use Laravel\Passport\Http\Middleware\CheckClientCredentials;
        use Laravel\Passport\Http\Middleware\CheckForAnyScope;
        use Laravel\Passport\Http\Middleware\CheckScopes;
        use Laravel\Passport\Http\Middleware\CreateFreshApiToken;
        TEXT;

        $searchWebMiddleware = <<<TEXT
                    SubstituteBindings::class,
        TEXT;

        $replaceWebMiddleware = <<<TEXT
                    SubstituteBindings::class,
                    CreateFreshApiToken::class,
        TEXT;

        $searchRouteMiddleware = <<<TEXT
                'auth:basic:once' => AuthenticateOnceWithBasicAuth::class,
        TEXT;

        $replaceRouteMiddleware = <<<TEXT
                'auth:basic:once' => AuthenticateOnceWithBasicAuth::class,
                'api:auth:client' => CheckClientCredentials::class,
                'api:scopes:all' => CheckScopes::class,
                'api:scopes:any' => CheckForAnyScope::class,
        TEXT;

        $searchMiddlewarePriority1 = <<<TEXT
                AuthenticateOnceWithBasicAuth::class,
        TEXT;

        $replaceMiddlewarePriority1 = <<<TEXT
                AuthenticateOnceWithBasicAuth::class,
                CheckClientCredentials::class,
        TEXT;

        $searchMiddlewarePriority2 = <<<TEXT
                SubstituteBindings::class,
        TEXT;

        $replaceMiddlewarePriority2 = <<<TEXT
                SubstituteBindings::class,
                CreateFreshApiToken::class,
        TEXT;

        $replacements = [
            $searchImport => $replaceImport,
            $searchWebMiddleware => $replaceWebMiddleware,
            $searchRouteMiddleware => $replaceRouteMiddleware,
            $searchMiddlewarePriority1 => $replaceMiddlewarePriority1,
            $searchMiddlewarePriority2 => $replaceMiddlewarePriority2,
        ];

        $config = $this->replace($replacements, $config);

        $filesystem->put($path, $config);
    }

    /**
     * @param array $replacements
     * @param string $string
     *
     * @return string
     */
    private function replace(array $replacements, string $string) : string
    {
        foreach ($replacements as $search => $replace) {
            $string = str_replace($search, $replace, $string);
        }

        return $string;
    }
}
