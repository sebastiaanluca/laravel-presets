<?php

namespace SebastiaanLuca\Preset;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Foundation\Console\Presets\Preset as BasePreset;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Preset extends BasePreset
{
    /**
     * @var \Illuminate\Foundation\Console\PresetCommand
     */
    protected $command;

    /**
     * @param \Illuminate\Foundation\Console\PresetCommand $command
     */
    public function __construct(PresetCommand $command)
    {
        $this->command = $command;
    }

    /**
     * @param \Illuminate\Foundation\Console\PresetCommand $command
     */
    public static function install(PresetCommand $command) : void
    {
        static::removeNodeModules();

        (new static($command))->run();
    }

    public function run() : void
    {
        $this->command->task('Remove obsolete directories and files', Closure::fromCallable([$this, 'deleteObsoleteDirectories']));
        //        $this->command->task('Move framework to a sub directory', Closure::fromCallable(['static', 'moveFramework']));
        $this->command->task('Scaffold application directories', Closure::fromCallable([$this, 'createApplicationDirectories']));
        $this->command->task('Scaffold configuration', Closure::fromCallable([$this, 'scaffoldConfiguration']));
        $this->command->task('Scaffold resources', Closure::fromCallable([$this, 'scaffoldResources']));
        $this->command->task('Scaffold NPM packages', Closure::fromCallable([$this, 'scaffoldNpmPackages']));

        // TODO: update composer.json with new app class structure
        // TODO: update composer.json with config values
        // TODO: update composer packages
        // TODO: update npm packages
        // TODO: remove providers from app.php config file
        // TODO: update app namespace in files and bootstrap file
        // TODO: add back User model (in domain code)

        $this->command->info('Project successfully scaffolded!');
        $this->command->comment('Don\'t forget to update your composer.json and README.md with your project\'s name and description.');
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     * @param string $key
     *
     * @return array
     */
    protected static function updatePackageArray(array $packages, string $key) : array
    {
        return static::config(sprintf('npm.%s', $key));
    }

    /**
     * @param string|null $key
     *
     * @return array
     */
    protected static function config(?string $key = null) : array
    {
        $key = $key
            ? '.' . $key
            : '';

        return config('preset-sebastiaanluca.project' . $key);
    }

    /**
     * @param string $directory
     */
    protected static function createDirectory(string $directory) : void
    {
        $filesystem = new Filesystem;

        if ($filesystem->isDirectory($directory)) {
            return;
        }

        $filesystem->makeDirectory($directory, 0755, true);
    }

    /**
     * @param string $directory
     */
    protected static function addGitKeepFileTo(string $directory) : void
    {
        (new Filesystem)->copy(__DIR__ . '/../resources/.gitkeep', $directory);
    }

    /**
     * @param string $directory
     *
     * @return string
     */
    protected static function stubPath(string $directory = '') : string
    {
        return __DIR__ . '../resources/project-stubs/' . $directory;
    }

    /**
     * @param string $command
     */
    protected static function call(string $command) : void
    {
        $process = new Process(
            explode(' ', $command),
            base_path()
        );

        $process->start();
    }

    protected function deleteObsoleteDirectories() : void
    {
        tap(new Filesystem, static function (Filesystem $filesystem) : void {
            $filesystem->deleteDirectory(base_path('routes'));
            $filesystem->deleteDirectory(public_path('css'));
            $filesystem->deleteDirectory(public_path('js'));
            $filesystem->deleteDirectory(resource_path('css'));
            $filesystem->deleteDirectory(resource_path('js'));
            $filesystem->deleteDirectory(resource_path('sass'));

            $filesystem->delete(base_path('.editorconfig'));
            $filesystem->delete(base_path('.env'));
            $filesystem->delete(base_path('.env.example'));
            $filesystem->delete(base_path('.gitattributes'));
            $filesystem->delete(base_path('.gitignore'));
            $filesystem->delete(base_path('.styleci.yml'));
            $filesystem->delete(base_path('phpunit.xml'));
            $filesystem->delete(base_path('webpack.mix.js'));

            //            $filesystem->delete(base_path('app/Http/Controllers/Controller.php'));
            //            $filesystem->delete(base_path('app/Providers/AppServiceProvider.php'));
            //            $filesystem->delete(base_path('app/Providers/AuthServiceProvider.php'));
            //            $filesystem->delete(base_path('app/Providers/BroadcastServiceProvider.php'));
            //            $filesystem->delete(base_path('app/Providers/EventServiceProvider.php'));
            //            $filesystem->delete(base_path('app/Providers/RouteServiceProvider.php'));
            //            $filesystem->delete(base_path('app/User.php'));
        });

        static::removeNodeModules();
    }

    protected function moveFramework() : void
    {
        $filesystem = new Filesystem;

        $filesystem->moveDirectory(base_path('app'), base_path('_app'));

        if (! $filesystem->isDirectory($directory = base_path('app'))) {
            $filesystem->makeDirectory($directory, 0755, true);
        }

        $filesystem->moveDirectory(base_path('_app'), base_path('app/Framework'));
    }

    protected function scaffoldConfiguration() : void
    {
        tap(new Filesystem, static function (Filesystem $filesystem) : void {
            $filesystem->copy(static::stubPath('.browserslistrc'), base_path('.browserslistrc'));
            $filesystem->copy(static::stubPath('.editorconfig'), base_path('.editorconfig'));
            $filesystem->copy(static::stubPath('.env'), base_path('.env'));
            $filesystem->copy(static::stubPath('.env.example'), base_path('.env.example'));
            $filesystem->copy(static::stubPath('.env.testing'), base_path('.env.testing'));
            $filesystem->copy(static::stubPath('.gitattributes'), base_path('.gitattributes'));
            $filesystem->copy(static::stubPath('.gitignore'), base_path('.gitignore'));
            $filesystem->copy(static::stubPath('.phpcs.xml.dist'), base_path('.phpcs.xml.dist'));
            $filesystem->copy(static::stubPath('.phpunit.dusk.xml'), base_path('.phpunit.dusk.xml'));
            $filesystem->copy(static::stubPath('.phpunit.xml.dist'), base_path('.phpunit.xml.dist'));
            $filesystem->copy(static::stubPath('.shiftrc'), base_path('.shiftrc'));
            $filesystem->copy(static::stubPath('README.md'), base_path('README.md'));
            $filesystem->copy(static::stubPath('SCRATCH.md'), base_path('SCRATCH.md'));
            $filesystem->copy(static::stubPath('tailwind.config.js'), base_path('tailwind.config.js'));
            $filesystem->copy(static::stubPath('webpack.mix.js'), base_path('webpack.mix.js'));
        });
    }

    protected function createApplicationDirectories() : void
    {
        static::createDirectory(base_path('app/Domain'));
        static::createDirectory(base_path('app/Interfaces/Web'));
        static::createDirectory(base_path('app/Modules'));

        static::addGitKeepFileTo(base_path('app/Domain'));
        static::addGitKeepFileTo(base_path('app/Interfaces/Web'));
        static::addGitKeepFileTo(base_path('app/Modules'));
    }

    protected function scaffoldResources() : void
    {
        tap(new Filesystem, static function (Filesystem $filesystem) : void {
            $filesystem->copyDirectory(static::stubPath('resources/js'), resource_path('js'));
            $filesystem->copyDirectory(static::stubPath('resources/css'), resource_path('css'));
        });
    }

    protected function scaffoldNpmPackages() : void
    {
        static::updatePackages($dev = false);
        static::updatePackages($dev = true);

        static::call('yarn install');
    }
}
