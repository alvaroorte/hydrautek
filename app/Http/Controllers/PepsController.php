<?php

namespace App\Http\Controllers;

use App\Models\peps;
use Illuminate\Http\Request;

class PepsController extends Controller
{
    public function EncontrarPeps($id)
    {
        $peps = peps::where('id',$id)->get();
        return $peps;   
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\peps  $peps
     * @return \Illuminate\Http\Response
     */
    public function show(peps $peps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\peps  $peps
     * @return \Illuminate\Http\Response
     */
    public function edit(peps $peps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\peps  $peps
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, peps $peps)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\peps  $peps
     * @return \Illuminate\Http\Response
     */
    public function destroy(peps $peps)
    {
        //
    }
}
