<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Thujohn\Twitter\Facades\Twitter;
use Intervention\Image\Facades\Image;
use File;
use DateTime;

class BitcoinVixController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }


    /*
     * @date string 'YYYY-mm-dd'
     */
    public function tweetFearAndGreedIndex($date = '')
    {

        if ( !$this->validateDate( $date ))
        {
            return 'invalid date format. Kindly use YYYY-MM-DD.';
        }

        $path = 'https://alternative.me/images/fng/crypto-fear-and-greed-index-' . $date . '.png';
        $filename = basename($path);

        $fileLoc = '/img/btcvix-images/';
        $fileLoc = public_path( $fileLoc . $filename);

        Image::make($path)->save($fileLoc);

        $uploaded_media = Twitter::uploadMedia(['media' => File::get($fileLoc)]);
        Twitter::postTweet(['status' => 'Bitcoin Fear and Greed Index as of ' . $date, 'media_ids' => $uploaded_media->media_id_string]);
        return;

    }

    function validateDate($date, $format = 'Y-n-j')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}
