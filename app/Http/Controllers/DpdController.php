<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreDpdRequest;
use App\Http\Requests\UpdateDpdRequest;

use App\Dpd;

class DpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dpd.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dpd.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDpdRequest $request)
    {
        $dpd = new Dpd;
        $dpd->code = $request->code;
        $dpd->name = $request->name;
        $dpd->save();
        $dpd_id = $dpd->id;
        return redirect('dpd')
            ->with('successMessage', "DPD $request->name has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dpd = Dpd::findOrFail($id);
        return view('dpd.show')
            ->with('dpd', $dpd);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dpd = Dpd::findOrFail($id);
        return view('dpd.edit')
            ->with('dpd', $dpd);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDpdRequest $request, $id)
    {
        $dpd = Dpd::findOrFail($id);
        $dpd->code = $request->code;
        $dpd->name = $request->name;
        $dpd->save();
        return redirect('dpd')
            ->with('successMessage', "DPD $request->name has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dpd = Dpd::findOrFail($request->dpd_id);
        $dpd->delete();
        return redirect('dpd')
            ->with('successMessage', "DPD $dpd->name has been deleted");
    }
    
}
