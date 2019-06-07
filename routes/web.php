<?php

use Alimranahmed\LaraOCR\Facades\OCR;
use Google\Cloud\Vision\VisionClient;
use Google\Cloud\Vision\Image;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function() {
    //$imagePath = "/Users/xanderyui/Projects/btc-fear-greed-index/resources/lara_ocr/sampleImages/1.jpg";
    $imagePath = "/Users/xanderyui/Downloads/fear-and-greed-index.png";
    $text = OCR::scan($imagePath);

    dd($text);
});


Route::get('/test2', function(){

    $vision = new VisionClient();

    $externalUri = 'https://alternative.me/crypto/fear-and-greed-index.png';
    $image = new Image($externalUri, ['landmarks']);
    $res = $image->requestObject();
    dd($res);

// Annotate an image, detecting faces.
    $image = $vision->image(
        //fopen('/data/family_photo.jpg', 'r'),
        fopen('https://alternative.me/crypto/fear-and-greed-index.png', 'r'),
        []
        //['faces']
    );

    $annotation = $vision->annotate($image);
    dd($annotation);
// Determine if the detected faces have headwear.
    /*
    foreach ($annotation->faces() as $key => $face) {
        if ($face->hasHeadwear()) {
            echo "Face $key has headwear.\n";
        }
    }
    */
});


Route::get('/test3', function(){
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', 'https://api.alternative.me/fng/?limit=10');

    $timestamp = 1557547200;

    $date = Carbon::createFromTimestamp($timestamp)->toDateTimeString();

    echo $response->getBody();


    //dd($date);
    //echo $response->getStatusCode(); # 200
    //echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
    //echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'

# Send an asynchronous request.
    /*
    $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
    $promise = $client->sendAsync($request)->then(function ($response) {
        echo 'I completed! ' . $response->getBody();
    });

    $promise->wait();
    */
});




Route::get('btc/tweet/vix/{date?}', 'BitcoinVixController@tweetFearAndGreedIndex');