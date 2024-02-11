<?php

namespace Brief\Compression\Providers;

use Brief\Compression\Contracts\CompressionType;
use Brief\Compression\Services\SevenZipCompressionType;
use Brief\Compression\Services\TarGzCompressionType;
use Brief\Compression\Services\ZipCompressionType;
use Illuminate\Support\ServiceProvider;

class CompressionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/compression.php');
        $this->mergeConfigFrom(__DIR__ . '/../Config/compression.php', 'CompressionConfig');

        $this->app->bind(CompressionType::class, function () {

            if (config('CompressionConfig.type') == '7zip')
                return resolve(SevenZipCompressionType::class);

            if (config('CompressionConfig.type') == 'tar')
                return resolve(TarGzCompressionType::class);

            return resolve(ZipCompressionType::class);
        });

    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
