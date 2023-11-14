<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{

    public function list()
    {
        return view('module.list');
    }

    public function addForm()
    {
        return view('module.add');
    }

    public function editForm()
    {
        return view('module.edit');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Module $module)
    {
        //
    }

    public function edit(Module $module)
    {
        //
    }

    public function update(Request $request, Module $module)
    {
        //
    }

    public function destroy(Module $module)
    {
        //
    }
}
