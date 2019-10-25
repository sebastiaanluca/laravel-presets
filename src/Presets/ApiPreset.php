<?php

namespace SebastiaanLuca\Preset\Presets;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use SebastiaanLuca\Preset\Commands\GenerateOauthKeys;
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
        // TODO: Write and copy API tests directory to tests/Interfaces/Api

        $this->command->task('Add Laravel Passport package', Closure::fromCallable([$this, 'addPackage']));
        $this->command->task('Publish Laravel Passport views', Closure::fromCallable([$this, 'publishViews']));
        $this->command->task('Scaffold configuration', Closure::fromCallable([$this, 'copyConfiguration']));
        $this->command->task('Scaffold migrations', Closure::fromCallable([$this, 'copyMigrations']));
        $this->command->task('Scaffold HTTP interface', Closure::fromCallable([$this, 'copyInterface']));
        $this->command->task('Register HTTP interface provider', Closure::fromCallable([$this, 'registerProvider']));
        $this->command->task('Register auth guard', Closure::fromCallable([$this, 'registerAuthGuard']));
        $this->command->task('Register user tokens trait', Closure::fromCallable([$this, 'registerUserTrait']));
        $this->command->task('Register kernel middleware', Closure::fromCallable([$this, 'registerKernelMiddlewares']));
        $this->command->task('Add environment variables', Closure::fromCallable([$this, 'addEnvironmentVariables']));
        $this->command->task('Add generated OAuth keys', Closure::fromCallable([$this, 'generateAndWriteOauthKeys']));

        $this->command->info('🎉 API successfully scaffolded!');
        $this->command->info('➡️  After you\'ve reviewed the changes, run `php artisan migrate` to persist the database structure.');
        $this->command->line('');
        $this->command->comment('Based on your requirements, you can add a migration to create your one-time personal OAuth clients or opt to let your users create these manually themselves in your app.');
        $this->command->comment('See https://laravel.com/docs/passport for more information on how to further configure your API.');
    }

    protected function addPackage() : void
    {
        $this->call('composer require laravel/passport');
    }

    protected function publishViews() : void
    {
        $this->call('php artisan vendor:publish --tag=passport-views');
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
                Interfaces\Console\Providers\ConsoleServiceProvider::class,
        TEXT;

        $replace = <<<TEXT
                Interfaces\Api\Providers\ApiServiceProvider::class,
                Interfaces\Console\Providers\ConsoleServiceProvider::class,
        TEXT;

        $config = str_replace($find, $replace, $config);

        handle_filesystem_errors($filesystem->put($path, $config));
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

        handle_filesystem_errors($filesystem->put($path, $config));
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

        handle_filesystem_errors($filesystem->put($path, $config));
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
                    VerifyCsrfToken::class,
                    SubstituteBindings::class,
        TEXT;

        $replaceWebMiddleware = <<<TEXT
                    VerifyCsrfToken::class,
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
                ForceJsonRequests::class,
                SubstituteBindings::class,
        TEXT;

        $replaceMiddlewarePriority2 = <<<TEXT
                ForceJsonRequests::class,
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

        handle_filesystem_errors($filesystem->put($path, $config));
    }

    protected function addEnvironmentVariables() : void
    {
        $string = <<<TEXT
        
        PASSPORT_PRIVATE_KEY=
        PASSPORT_PUBLIC_KEY=
        
        TEXT;

        $filesystem = new Filesystem;

        $file = base_path('.env.example');
        $contents = $filesystem->get($file);

        if (! Str::contains($contents, $string)) {
            handle_filesystem_errors($filesystem->put($file, $contents . $string));
        }
    }

    /**
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function generateAndWriteOauthKeys() : void
    {
        $returnCodes[] = $this->command->callSilent(GenerateOauthKeys::class, [
            '--write' => true,
            '--file' => '.env',
        ]);

        $returnCodes[] = $this->command->callSilent(GenerateOauthKeys::class, [
            '--write' => true,
            '--file' => '.env.testing',
        ]);

        if (collect($returnCodes)->reject(0)->isNotEmpty()) {
            throw new RuntimeException('Generating OAuth keys failed.');
        }
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
