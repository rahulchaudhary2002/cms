<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $content = "<?php

namespace App\Services;
        
class ". $filename ."
{

}
";
        $file = app_path('Services/' . $filename . '.php');
        file_put_contents($file, $content);

        $this->info($filename. ' created successfully!');
    }
}
