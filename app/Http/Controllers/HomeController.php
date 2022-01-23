<?php

namespace App\Http\Controllers;

use App\Product;
use GuzzelHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * 
     * 
     * @return void
     */
   public function __construct()
   {
      // $this->middleware('auth');
   }

   public function index()
   {
       return view('welcome',[
           'products' => Product::take(5)->latest()->get(),
       ]);
   }



   /**
    * 
    * @return \Illuminate\Constracts\Support\Renderable
    */
    public function home()
    {
        $curl = curl_init('https://api.openweathermap.org/data/2.5/weather?q=gaza,ps&appid=e314c34920446b023c2755e7b40d8f09');
        curl_setopt_array($curl,[
            CURLOPT_HEADER =>false,
            CURLOPT_RETURNTRANSFER =>true,

        ]);
        $res = (object) json_decode(curl_exec($curl));
        curl_close($curl);
        
        //$client = new Client();
        //$res = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=gaza,ps&appid=e314c34920446b023c2755e7b40d8f09', ['allow_redirects' => false]);
      //dd($res);
        return view('dashboard',[
            'weather' => $res,
        ]);
    }

}
