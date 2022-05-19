<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TextStyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'text:style {text} {--style=lowercase}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converte una stringa in uppercase se richiesto';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stringToConvert = $this->argument('text');
        switch ($this->option('style')) {
            case 'uppercase':
                $stringToConvert = mb_strtoupper($stringToConvert);
                break;
            case 'lowercase':
                $stringToConvert = mb_strtolower($stringToConvert);
                break;
            default:
                $this->error('Stile non disponibile');
                return 1;
        }

        $this->info("Nuova stringa: $stringToConvert");
        return 0;
    }
}
