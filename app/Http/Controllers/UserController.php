<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Session;


class UserController extends Controller
{
    function __construct()
    {

    }

    public function index()
    {
        print_r(YOUR_DEFINED_CONST['email']);
        $Users =  User::all();
        return $this->_renderPage('user.users', ['users' => $Users]);
    }

    public function create($id = 0)
    {
        $id = base64_decode($id);
        $user = ($id) ? User::find($id) : new User;
        if($user){
            return $this->_renderPage('user.form', [ 'user' => $user]);
        }else{
            return redirect(url('404'));
        }
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = ($request->id) ? User::find($request->id) : new User;
        $user->fill($request->all());

        if($request->file){
            $fileName = time().'.'.$request->file->extension();  
            $request->file->move(public_path('uploads/profile'), $fileName);
            if($user->img_name && file_exists('uploads/profile/'. $user->img_name))
                unlink('uploads/profile/'.$user->img_name);

            $user->img_name = $fileName;
        }

        if($user->save()){
            Session::flash('message', "Save user successfully...");
        }else{
            Session::flash('error', "something went wrong");
        }
        return redirect(url('user'));
    }

    public function remove(Request $request, $id)
    {
        $id = base64_decode($id);
        $user=User::find($id);
        

        if($user->delete()){ 
            if(file_exists('uploads/profile/'.$user->img_name))
                unlink('uploads/profile/'.$user->img_name);
                
            Session::flash('message', "User delete successfully...");
        }else{
            Session::flash('error', "something went wrong");
        }
        return redirect(url('user'));
    }

    private function _renderPage($url, $data){
        return view('header', $data).view($url, $data).view('footer', $data);
    }

    public function downloadProfile($id)
    {
        $id = base64_decode($id);
        $user=User::find($id);
        if($user){
            $pathToFile = 'uploads/profile/'.$user->img_name;
            return response()->download($pathToFile);
        }
        return redirect(url('user'));
    }

    
    public function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function getMetaData(Request $request)
    {
        $url = $request->input('url');
        $details = ' <div> <label for=""> <b>Meta Details : </b></label> </div>';
        
        if($url){
            $html = $this->file_get_contents_curl($url);

            $keywords = $description = $title = '';
            //parsing begins here:
            $doc = new \DOMDocument();
            @$doc->loadHTML($html);
            $nodes = $doc->getElementsByTagName('title');

            //get and display what you need:
            
            $title = isset($nodes->item(0)->nodeValue) ? $nodes->item(0)->nodeValue : '';

            $metas = $doc->getElementsByTagName('meta');

            for ($i = 0; $i < $metas->length; $i++)
            {
                $meta = $metas->item($i);
                if($meta->getAttribute('name') == 'description')
                    $description = $meta->getAttribute('content');
                if($meta->getAttribute('name') == 'keywords')
                    $keywords = $meta->getAttribute('content');
            }

            $h1 = $doc->getElementsByTagName('h1');
            $h2 = $doc->getElementsByTagName('h2');
            $h3 = $doc->getElementsByTagName('h3');
            $h4 = $doc->getElementsByTagName('h4');
            $h6 = $doc->getElementsByTagName('h6');
            $p = $doc->getElementsByTagName('p');
            $div = $doc->getElementsByTagName('div');
            $body_html = "";
            if($h1)
                for ($i=0; $i < $h1->length; $i++) {
                    $body_html .= (isset($h1->item($i)->nodeValue) ? $h1->item($i)->nodeValue : '') . '<br> <br>';
                }
            if($h4)
                for ($i=0; $i < $h4->length; $i++) {
                    $body_html .= (isset($h4->item($i)->nodeValue) ? $h4->item($i)->nodeValue : '') . '<br> <br>';
                }
            if($h6)
                for ($i=0; $i < $h6->length; $i++) {
                    $body_html .= (isset($h6->item($i)->nodeValue) ? $h6->item($i)->nodeValue : '') . '<br> <br>';
                }

            if($p)
                for ($i=0; $i < $p->length; $i++) {
                    $paragraphs = explode('.', $p->item($i)->nodeValue);
                    foreach ($paragraphs as $key => $value) {
                        if(trim($value)){
                            $body_html .= $value . '. <br> <br>';
                        }
                    }
                    
                }

            $details .= " <b> Title: </b>". str_replace([',', '.'], [' | ', ' | '], $title) . '<br/><br/>';
            $details .= " <b> Description: </b> ". $description  .'<br/><br/>';
            $details .= " <b> Keywords: </b> $keywords". '<br/><br/>';
            $details .= " <b> Body: </b>" . '<br/>' . $body_html;

        }
        $details .= '</div>';
        // echo print_r($doc);

        $html = '<div style="padding: 10px 20px;margin: 10px 20px;border: 1px solid;">  <form action="'. url('/get-meta-data') .'" method="get">
            <input type="text" name="url" id="url">
            <input type="submit" value="Check Details">
        </form> <br/><br/> ';

        echo $html . $details;


    }

}