<?php

namespace App\Http\Controllers;


use App\A;
use App\AContent;
use App\Education;
use Illuminate\Http\Request;


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


}
