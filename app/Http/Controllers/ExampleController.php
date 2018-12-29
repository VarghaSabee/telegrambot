<?php

namespace App\Http\Controllers;

use App\Images;
use App\Post;
use GuzzleHttp\Client;
use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendPhoto;
use unreal4u\TelegramAPI\TgLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ExampleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function parse()
    {
        //https://www.instagram.com/onlyprfectgirls/

        $images = $this->getImagesJSON();

        if (sizeof($images) < 2) {
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
           
            if(sizeof($images) > 0 ){
            $this->setJSONImages($images);
            }
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
    
    public function getImagesJSON()
    {
        // $file_path = realpath(__DIR__ . '/../../../database/images.json');
        $file_path = "https://api.jsonbin.io/b/5c2786d3412d482eae5759f4/latest";
        return json_decode(file_get_contents($file_path), true);
        // dd(urlencode($o[0]->$photo_url));
    }
    public function setJSONImages($images)
    {
        $client = new Client();
        // $file_path = realpath(__DIR__ . '/../../../database/images.json');
        $r = $client->request('PUT', 'https://api.jsonbin.io/b/5c2786d3412d482eae5759f4', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($images),
        ]);
    }

    public function all()
    {
        return json_encode(Post::all());
    }

    public function chacgeActive($id)
    {
        // $p = Post::where(['active' => 'active'])->get();
        // $p->active = "";
        // $p->save();

        // $p = Post::where(['id' => $id])->get();
        // $p->active = "active";
        // $p->save();
        return $id . 'ok';
    }

    public function getActiveName()
    {
        $p = Post::where(['active' => 'active'])->get();
        return $p->name;
    }

    public function getImages()
    {
        return json_encode($this->getImagesJSON());
    }

    public function add(Request $request) 
    {
        $p = new Post();
        $p->name = $request->input('name');
        $p->active = "";
        $p->save();
        return "ok";
    }

    public function settings (){
        return view('parser');
    }
}
