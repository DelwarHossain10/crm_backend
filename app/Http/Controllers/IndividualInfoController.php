<?php
namespace App\Http\Controllers;

use App\Models\IndividualInfo;
use App\Models\InitialInfo;
use App\Models\ConcernPerson;
use App\Models\OrganizationAddress;
use Illuminate\Http\Request;

class IndividualInfoController extends Controller
{
    // Show a specific individual info record with related data
    public function index()
    {
        // Retrieve the IndividualInfo with related InitialInfo, ConcernPerson, and OrganizationAddress
        $individualInfo = IndividualInfo::with(['initialInfo', 'concernPerson', 'organizationAddress'])->get();

        return response()->json(['data' => $individualInfo], 200);
    }
    public function show($id)
    {
        // Retrieve the IndividualInfo with related InitialInfo, ConcernPerson, and OrganizationAddress
        $individualInfo = IndividualInfo::with(['initialInfo', 'concernPerson', 'organizationAddress'])->findOrFail($id);

        return response()->json(['data' => $individualInfo], 200);
    }

    // Store new individual info data
    public function store(Request $request)
    {
        $initial_info = is_string($request->input('initial_info')) ? json_decode($request->input('initial_info'), true) : $request->input('initial_info');
        $concern_person = is_string($request->input('concern_person')) ? json_decode($request->input('concern_person'), true) : $request->input('concern_person');
        $organization_address = is_string($request->input('organization_address')) ? json_decode($request->input('organization_address'), true) : $request->input('organization_address') ?? [];

        $initialInfo = $concernPerson = $organizationAddress = null;

        if ($initial_info) {
            $initialInfo = InitialInfo::create($initial_info);
        }

        if ($concern_person) {
            $concernPerson = ConcernPerson::create($concern_person);
        }
        if ($organization_address) {
            $organizationAddress = OrganizationAddress::create($organization_address);
        }
        if ($initialInfo || $concernPerson || $organizationAddress) {
            $individualInfo = IndividualInfo::create([
                'prospect_type' => $request->input('prospect_type'),
                'initial_info_id' => $initialInfo->id ?? null,
                'concern_person_id' => $concernPerson->id ?? null,
                'organization_address_id' => $organizationAddress->id ?? null,
            ]);
            return response()->json(['message' => 'Record created successfully', 'data' => $individualInfo], 201);
        }
        return response()->json(['message' => 'No valid data to insert'], 400);
    }


    // Update an existing individual info record
    public function update(Request $request, $id)
    {
        $individualInfo = IndividualInfo::find($id);
        if (!$individualInfo) {
            return response()->json(['message' => 'IndividualInfo not found'], 404);
        }
        $initial_info = is_string($request->input('initial_info')) ? json_decode($request->input('initial_info'), true) : $request->input('initial_info');
        $concern_person = is_string($request->input('concern_person')) ? json_decode($request->input('concern_person'), true) : $request->input('concern_person');
        $organization_address = is_string($request->input('organization_address')) ? json_decode($request->input('organization_address'), true) : $request->input('organization_address') ?? [];
        if ($initial_info) {
            $initialInfo = InitialInfo::find($individualInfo->initial_info_id);
            if ($initialInfo) {
                $initialInfo->update($initial_info);
            } else {
                $initialInfo = InitialInfo::create($initial_info);
                $individualInfo->update(['initial_info_id' => $initialInfo->id]);
            }
        }
        if ($concern_person) {
            $concernPerson = ConcernPerson::find($individualInfo->concern_person_id);
            if ($concernPerson) {
                $concernPerson->update($concern_person);
            } else {
                $concernPerson = ConcernPerson::create($concern_person);
                $individualInfo->update(['concern_person_id' => $concernPerson->id]);
            }
        }
        if ($organization_address) {
            $organizationAddress = OrganizationAddress::find($individualInfo->organization_address_id);
            if ($organizationAddress) {
                $organizationAddress->update($organization_address);
            } else {
                $organizationAddress = OrganizationAddress::create($organization_address);
                $individualInfo->update(['organization_address_id' => $organizationAddress->id]);
            }
        }
        return response()->json(['message' => 'Record updated successfully', 'data' => $individualInfo], 200);
    }


    // Delete an individual info record and its related data
    public function destroy($id)
    {
        // Find the individual info record
        $individualInfo = IndividualInfo::findOrFail($id);

        // Delete related records
        $individualInfo->initialInfo->delete();
        $individualInfo->concernPerson->delete();
        $individualInfo->organizationAddress->delete();

        // Delete the individual info record itself
        $individualInfo->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
