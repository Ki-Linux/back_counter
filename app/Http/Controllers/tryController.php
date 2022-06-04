<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Storage;

//use League\Flysystem\AwsS3v3\AwsS3Adapter;


class tryController extends Controller
{
    public function index(Request $request)//リマインダーのデータを取ってくる
    {

        //$connectionString = "DefaultEndpointsProtocol=https;AccountName=".config('azure.account_name').";AccountKey=".config('azure.account_key');

        //$blobClient = BlobRestProxy::createBlobService($connectionString);
        $storage = Storage::disk('s3');
        $data = $storage->get('22563485.png');

        return $data;

    }
}
