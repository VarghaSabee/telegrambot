<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use App\Http\Controllers\ExampleController;
class PostPicture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:picture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Posting a Picture to chanel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contr = new ExampleController();

        while (true) {
            // $this->line();
            \Log::info('<info>[' . Carbon::now()->format('Y-m-d H:i:s') . ']</info> Calling scheduler post Image');
            // ExampleController::parse();
            // $this->call('App\Http\Controllers\ExampleController@parse');
            $contr->parse();
            sleep(60);
            $this->call('schedule:run');
// 
        }
       

    }
}