<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTrait extends Command
{
    protected $signature = 'make:trait {name}';
    protected $description = 'Create a new trait';

    public function handle()
    {
        $filename = $this->argument('name');
        $content = "<?php

namespace App\Traits;
        
trait ". $filename ."
{
    
}
";
        
        $directory = app_path('Traits');

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $file = $directory . '/' . $filename . '.php';

        file_put_contents($file, $content);

        $this->info($filename. ' created successfully!');
    }
}
