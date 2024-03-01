<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $content = "<?php

namespace App\Repositories;
        
class ". $filename ."
{

}
";

        $file = app_path('Repositories/' . $filename . '.php');
        file_put_contents($file, $content);

        $this->info($filename. ' created successfully!');
    }
}
