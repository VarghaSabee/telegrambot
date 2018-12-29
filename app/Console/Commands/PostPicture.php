<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use App\Http\Controllers\ExampleController;


use App\Images;
use App\Post;
use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendPhoto;
use unreal4u\TelegramAPI\TgLog;

class PostPicture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:cron {--queue}';

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
     * */


    public function handle()
    {
        $this->parse();
        sleep(30);
        // $this->info('Waiting '. $this->nextMinute(). ' for next run of scheduler');
        // sleep($this->nextMinute());
        // $this->runScheduler();
    }
   

    public function parse()
    {
        //https://www.instagram.com/onlyprfectgirls/
    $images = $this->getImagesJSON();

    if (sizeof($images) < 1) {
        $instagram = new \InstagramScraper\Instagram();

        $medias = [];
        $next = "ok";
        $i = 0;

        $post = Post::where(['active' => 'active'])->first();

        if ($post->nexturl == '') {
            $result = $instagram->getPaginateMedias('onlyprfectgirls', $post->nexturl);
            $medias = $result['medias'];
            if ($result['hasNextPage'] === true) {
                $post->nexturl = $result['maxId'];
                $next = $result['maxId'];
            } else {
                $post->nexturl = "no";
            }
            $post->save();

        } else {
            $result = $instagram->getPaginateMedias('onlyprfectgirls', $post->nexturl);
            $medias = $result['medias'];

            if ($result['hasNextPage'] === true) {
                $post->nexturl = $result['maxId'];
                $next = $result['maxId'];
            } else {
                $post->nexturl = "no";
            }
            $post->save();
        }

        $image = array_shift($medias);
        $this->botsend($image);

        $imgArr = [];
        foreach ($medias as $media) {
            $i++;

            $im = new Images();
            $im->id = "" . $i;
            $im->url = $media->getImageHighResolutionUrl();
            $im->author = "";
            $imgArr[$i-1] = $im;

        }
        $image = array_shift($imgArr);
       
        $this->botsend($image->url);

        $this->setJSONImages($imgArr);
        // return view("parser", ["images" => json_encode($imagesArray), "nextpage" => $next]);
    } else {
        $images = $this->getImagesJSON();
        $image = array_shift($images);
       
        $this->setJSONImages($images);
        sleep(10);
        $this->botsend($image['url']);
        // dd($image['url']);
    }
}

//
public function botsend($photo_url)
{
    $token = '706762361:AAGZ4jhhEMoFs25j0Q6dppWayV_YT5cGHDE';
    $chat_id = '-1001276555963';
    $loop = Factory::create();
    $tgLog = new TgLog($token, new HttpClientRequestHandler($loop));
    $sendPhoto = new SendPhoto();
    $sendPhoto->chat_id = $chat_id;
    $sendPhoto->photo = $photo_url;
    // $sendPhoto->caption = 'Not sure if sending image or image not arriving';

    $promise = $tgLog->performApiRequest($sendPhoto);
    $promise->then(
        function ($response) {
            echo '<pre>';
            // var_dump($response);
            echo 'Sended';
            echo '</pre>';
        },
        function (\Exception $exception) {
            // Onoes, an exception occurred...
            echo 'Exception ' . get_class($exception) . ' caught, message: ' . $exception->getMessage();
        }
    );
    $loop->run();
}
public function all()
{
    \Log::info('Post runned!');
    return dd(Post::all());
}

public function increment()
{
    $p = Post::where(['active' => 'active'])->get();
    $p->count = $p->count + 1;
    $p->save();
}

public function chacgeActive($id)
{
    $p = Post::where(['active' => 'active'])->get();
    $p->active = "";
    $p->save();

    $p = Post::where(['id' => $id])->get();
    $p->active = "active";
    $p->save();
}

public function getActiveName()
{
    $p = Post::where(['active' => 'active'])->get();
    return $p->name;
}

public function add()
{
    $img = new Images();
    $img->url = "fjnalksf; fsdnfsd";
    $img->save();

    $img = new Images();
    $img->url = "fkopdsfo;s dfosdndpos";
    $img->save();

    // $p = new Post();
    // $p->name = "onlyprfectgirls";
    // $p->active = "";
    // $p->save();
}

public function getImagesJSON()
{
    $file_path = realpath(__DIR__ . '/../../../database/images.json');
    return json_decode(file_get_contents($file_path), true);
    // dd(json_decode(file_get_contents($file_path), true) );
}
public function setJSONImages($images)
{
    $file_path = realpath(__DIR__ . '/../../../database/images.json');
    file_put_contents($file_path,json_encode($images));
    return true;
}
   
  


}