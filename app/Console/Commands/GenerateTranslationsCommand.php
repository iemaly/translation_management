<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Concurrency;

class GenerateTranslationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate 100K translation fake data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = fake();
        $chunkSize = 1000;
        $total = 100000;
        ini_set('memory_limit', '1G');
        DB::disableQueryLog();
        $this->info("Seeding $total translations...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        for ($i = 0; $i < $total; $i += $chunkSize) {
            $translations = [];

            for ($j = 0; $j < $chunkSize; $j++) {
                $translations[] = [
                    'key' => $faker->word . '_' . ($i + $j),
                    'content' => $faker->sentence(),
                    'locale' => $faker->randomElement(['en', 'fr', 'es']),
                    'tags' => json_encode([$faker->randomElement(['web', 'mobile', 'desktop'])]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Translation::insert($translations);
            $bar->advance($chunkSize);
        }

        $bar->finish();
        $this->info("\nDone seeding translations!");
    }
}
