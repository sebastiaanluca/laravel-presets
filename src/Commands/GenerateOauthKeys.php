<?php

declare(strict_types=1);

namespace SebastiaanLuca\Preset\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use phpseclib\Crypt\RSA;

class GenerateOauthKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:keys
                            {--W|write : Write the keys to your .env file}
                            {--file= : Specify a different file to write to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new set of Laravel Passport OAuth keys.';

    /**
     * Execute the console command.
     *
     * @param \phpseclib\Crypt\RSA $rsa
     *
     * @return int|void
     */
    public function handle(RSA $rsa)
    {
        $keys = $rsa->createKey(4096);

        $string = <<<TEXT
        
        PASSPORT_PRIVATE_KEY="{$keys['privatekey']}"
        
        PASSPORT_PUBLIC_KEY="{$keys['publickey']}"
        
        TEXT;

        if ($this->option('write') === true) {
            $destination = $this->option('file') ?? '.env';

            (new Filesystem)->append(
                base_path($destination),
                $string
            );

            $this->info(sprintf(
                'Successfully generated a new set of keys and written them to your %s file.',
                $destination
            ));

            return;
        }

        $this->line($string);

        $this->info('Successfully generated a new set of keys.');
    }
}
