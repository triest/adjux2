<?php

namespace App\Http\Controllers;

use App\A;
use App\Aorganizer;
use App\User;
use Illuminate\Http\Request;
use App\Education;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use File;
use Response;
use App\Image;
use App\Main;
use App\AContent;
use App\Jobs\SendMessage;
use App\Jobs\SenMessagesToOrganizer;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;


class AdminController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function b()
    {
        return view('admin/index');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function showB($id)
    {
        if ($id == null) {
            return abort(404);
        }
        $did = B::select('id',
            'name',
            'phone',
            'email',
            'education_id',
            'femili',
            'description',
            'created_at',
            'updated_at',
            'utm',
            'ip')
            ->where('id', $id)->first();
        if ($did == null) {
            return abort(404);
        }
        $utm = explode('&', $did->utm);
        $content = $did->Content()->get();

        return view("admin/bDetail")->with([
            'item'    => $did,
            'content' => $content,
            'utms'    => $utm,
        ]);
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function showA($id)
    {

        $did = A::select('id',
            'name',
            'phone',
            'email',
            'education_id',
            'femili',
            'description',
            'created_at',
            'updated_at',
            'utm',
            'ip')
            ->where('id', $id)->first();
        if ($did == null) {
            return abort(404);
        }
        $utm = explode('&', $did->utm);
        $content = $did->Content()->get();

        return view("admin/aDetail")->with([
            'item'    => $did,
            'content' => $content,
            'utms'    => $utm,
        ]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function deleteDid($id)
    {
        if ($id == null) {
            return abort(404);
        }
        $did = B::find($id);
        if ($did == null) {
            return abort(404);
        }
        $did->delete();

        // return redirect('admin');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function deleteRand($id)
    {
        if ($id == null) {
            return abort(404);
        }
        $rand = A::select('id',
            'title',
            'description',
            'created_at',
            'updated_at')->where('id', $id)->first();

        if ($rand == null) {
            return abort(404);
        }
        $content = $rand->randContent()->get();

        foreach ($content as $item) {
            try {
                $temp_file = base_path().'\public\images\upload\\'
                    .$item->file_name;
                dump($temp_file);
                //  die();
                File::Delete($temp_file);
            } catch (\Exception $e) {
                echo "delete errod";
            }
            $item->delete();
        }
        $rand->delete();

        //   return redirect('admin');
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function didIndex(Request $request)
    {
        $dids = B::select('id',
            'name',
            'phone',
            'email',
            'education_id',
            'femili',
            'description',
            'created_at',
            'updated_at')->simplePaginate(20);

        return view("admin/b")->with(['dids' => $dids]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function randIndex(Request $request)
    {
        $rand = A::select('id',
            'name',
            'phone',
            'email',
            'education_id',
            'femili',
            'description',
            'created_at',
            'updated_at')->simplePaginate(20);

        return view("admin/a")->with(['rands' => $rand]);
    }

    //назначить организаторов

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Organizer(Request $request)
    {
        $users = User::all();

        return view('admin/makeOrganizer')->with(['users' => $users]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return json
     */
    public function getUsers(Request $request)
    {
        $users = User::all();
        /*  $users = DB::table('users')
              ->leftJoin('a_organized', 'users.id', '=', 'a_organized.user_id')
              ->leftJoin('b_organized', 'users.id', '=', 'b_organized.user_id')
              ->get();*/
        $users = DB::select('select us.id,us.email, us.name,a_org.user_id as `a_org`,b_org.user_id as `b_org` from users us left join a_organized a_org on  us.id=a_org.user_id 
 left join b_organized b_org on  us.id=b_org.user_id  
         ');

        return Response::json($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function makeB(Request $request)
    {
        $user = User::find($request->id)->first();
        if ($user == null) {
            return Response(404);
        }

        $rez = DB::select('select * from b_organized where user_id=?',
            [$user->id]);
        if ($rez != null) {
            return Response(404);
        }
        DB::table('b_organized')->insert(['user_id' => $user->id]);

        return Response::json(['result' => '200']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return json
     */
    public function makeA(Request $request)
    {

        $user = User::find($request->id)->first();
        if ($user == null) {
            return Response(404);
        }

        $rez = DB::select('select * from a_organized where user_id=?',
            [$user->id]);
        if ($rez != null) {
            return Response(404);
        }
        DB::table('a_organized')->insert(['user_id' => $user->id]);

        return Response::json(['result' => '200']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function deleteUserB(Request $request)
    {
        $user = User::find($request->id)->first();
        $user->aOrganizer = 0;
        $user->save();

        return Response::json(['result' => '200']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function deleteUserA(Request $request)
    {
        $user = User::find($request->id)->first();
        $user->bOrganizer = 0;
        $user->save();

        return Response::json(['result' => '200']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function getImages(Request $request)
    {
        $main = Main::select([
            'id',
            'title',
            'description',
            'created_at',
            'updated_at',
        ])->first();
        if ($main != null) {
            $images = $main->images()->get();
        }

        return Response::json($images);
    }

}
