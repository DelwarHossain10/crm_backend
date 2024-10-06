<?php

namespace App\Http\Controllers;

use App\Models\ProspectMaster;
use Illuminate\Http\Request;

class ProspectMasterController extends Controller
{
    public function index()
    {
        $prospects = ProspectMaster::with(['initialInfo', 'concernPerson', 'organizationAddress'])->get();
        return response()->json($prospects);
    }

    public function store(Request $request)
    {
        dd($request);

        $prospect = ProspectMaster::create($request->all());
        return response()->json($prospect);
    }

    public function show($id)
    {
        $prospect = ProspectMaster::with(['initialInfo', 'concernPerson', 'organizationAddress'])->find($id);
        return response()->json($prospect);
    }

    public function update(Request $request, $id)
    {
        $prospect = ProspectMaster::find($id);
        $prospect->update($request->all());
        return response()->json($prospect);
    }

    public function destroy($id)
    {
        $prospect = ProspectMaster::find($id);
        $prospect->delete();
        return response()->json('Deleted Successfully');
    }
}

