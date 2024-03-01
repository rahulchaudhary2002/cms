<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepositoryInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $content = "<?php

namespace App\Interfaces;
        
interface ". $filename ."
{

}
";

        $file = app_path('Interfaces/' . $filename . '.php');
        file_put_contents($file, $content);

        $this->info($filename. ' created successfully!');
    }
}
