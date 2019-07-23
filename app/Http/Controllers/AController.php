<?php

namespace App\Http\Controllers;


use App\A;
use App\AContent;
use App\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class AController extends Controller
{
    //


    public function create(Request $request)
    {

        $utm = $request->all();

        $educations = Education::select('id',
            'name',
            'created_at',
            'updated_at')->get();
        $utm2 = implode('&', $utm);

        return view('a.create')->with([
            'educations' => $educations,
            'utm'        => $utm2,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\B $did
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = A::select([
            'id',
            'name',
            'phone',
            'email',
            'education_id',
            'femili',
            'description',
            'created_at',
            'updated_at',
            'ip',
        ])->where('id', $id)->first();
        if ($item == null) {
            return abort(404);
        }
        $content = $item->Content()->get();

        return view('a/detail')->with(['item' => $item, 'content' => $content]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => 'required',
            'femili'      => 'required',
            'phone'       => 'required|numeric|min:18',
            'email'       => 'required|email',
            'description' => 'required',
            'education'   => 'required|numeric',
        ]);
        $ip = $request->ip();
        $did = new A();
        $did->name = $request->name;
        $did->femili = $request->femili;
        $did->email = $request->email;
        $did->phone = $request->phone;
        $did->description = $request->description;
        $did->ip = $ip;
        $did->options = json_encode($request->server());
        //  $did->utm = $request->utm;
        $did->save();
        dump($request);
        $education = Education::select('id',
            'name',
            'created_at',
            'updated_at')
            ->where('id', $request->education)
            ->first();
        dump($did);
        dump($education);
        if ($education!=null) {
            $education->did()->save($did);
        }


        if (Input::hasFile('files')) {
            foreach ($request->files as $key) {
                foreach ($key as $key2) {
                    $image_extension = $key2->getClientOriginalExtension();
                    $type
                        = $this->mime_content_type($image_extension);      //получпем тип загруженного файла
                    $image_new_name = md5(microtime(true));
                    $key2->move(public_path().'/images/upload/',
                        strtolower($image_new_name.'.'.$image_extension));
                    $b_content = new AContent();
                    $b_content->file_name = $image_new_name.'.'
                        .$image_extension;   //сохраняем и привязываем к обьекту A;
                    $b_content->content_type = $type;
                    $b_content->save();
                    $did->Content()->save($b_content);
                    $did->save();
                }
            }
        }
        //создайм задание на отправку почты
        // $user = $user = Auth::user();

        /*  $event = "A";
          // отправка сообщеня пользователю
          SendMessage::dispatch("Test2", $user->email, $user->name, $event)
              ->delay(now());
          $users = User::select([
              'name',
              'email',
              'password',
              'email',
              'email_verified_at',
              'admin',
              'superAdmin',
              'aOrganizer',
              'bOrganizer',
          ])->where('aOrganizer', '=', 1)->get();
          foreach ($users as $user) {
              SenMessagesToOrganizer::dispatch("Test2", $user->name, $user->email,
                  $did,
                  $event)->delay(now()->addMinutes(1));
          }
  */

        return Response::json(['result' => '200']);
    }

    /**
     * @param $filename
     *
     * @return mixed|null
     */
    function mime_content_type($filename)
    {
        $mime_types = array(
            'txt'  => 'text/plain',
            'htm'  => 'text/html',
            'html' => 'text/html',
            'php'  => 'text/html',
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'swf'  => 'application/x-shockwave-flash',
            'flv'  => 'video/x-flv',
            // images
            'PNG'  => 'image',
            'png'  => 'image',
            'jpe'  => 'image',
            'jpeg' => 'image',
            'jpg'  => 'image',
            'gif'  => 'image',
            'bmp'  => 'image',
            'ico'  => 'image',
            'tiff' => 'image',
            'tif'  => 'image',
            'svg'  => 'image',
            'svgz' => 'image',
            // archives
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'exe'  => 'application/x-msdownload',
            'msi'  => 'application/x-msdownload',
            'cab'  => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3'  => 'audio',
            'qt'   => 'video',
            'mov'  => 'video',
            'mp4'  => 'video',
            'wmv'  => 'video',
            'avi'  => 'video',
            // adobe
            'pdf'  => 'doc',
            'psd'  => 'doc',
            'ai'   => 'doc',
            'eps'  => 'doc',
            'ps'   => 'doc',
            // ms office
            'doc'  => 'doc',
            'rtf'  => 'doc',
            'xls'  => 'doc',
            'ppt'  => 'doc',
            // open office
            'odt'  => 'doc',
            'ods'  => 'doc',
        );
        //   $ext = strtolower(array_pop(explode('.', $filename)));
        $ext = $filename;
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } else {
            return null;
        }
    }

}
