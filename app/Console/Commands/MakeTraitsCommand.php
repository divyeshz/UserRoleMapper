<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeTraitsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $traitPath = app_path('Traits') . DIRECTORY_SEPARATOR . $name . '.php';

        if (!File::exists($traitPath)) {
            File::ensureDirectoryExists(app_path('Traits'));

            File::put($traitPath, '<?php

namespace App\Traits;

trait ' . $name . '
{
    // Your trait methods can be defined here
}
');

            $this->info('Trait ' . $name . ' created successfully!');
        } else {
            $this->error('Trait ' . $name . ' already exists!');
        }
    }
}
