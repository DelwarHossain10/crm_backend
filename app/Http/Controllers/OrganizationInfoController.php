<?php
namespace App\Http\Controllers;

use App\Models\IndividualInfo;
use App\Models\OrganizationBasicInfo;
use App\Models\OrganizationCommunicationInfo;
use App\Models\OrganizationInitialInfo;
use App\Models\OrganizationPersonalInfo;
use App\Models\OrganizationServiceInfo;
use Illuminate\Http\Request;

class OrganizationInfoController extends Controller
{
    // Show a specific individual info record with related data
    public function index()
    {
        // Retrieve the IndividualInfo with related InitialInfo, ConcernPerson, and OrganizationAddress
        $individualInfo = IndividualInfo::with(['organizationInitial', 'organizationBasic', 'organizationPersonal', 'organizationCommunication', 'organizationService'])->get();

        return response()->json(['data' => $individualInfo], 200);
    }
    public function show($id)
    {
        // Retrieve the IndividualInfo with related InitialInfo, ConcernPerson, and OrganizationAddress
        $individualInfo = IndividualInfo::with(['organizationInitial', 'organizationBasic', 'organizationPersonal', 'organizationCommunication', 'organizationService'])->findOrFail($id);

        return response()->json(['data' => $individualInfo], 200);
    }

    // Store new individual info data
    public function store(Request $request)
    {

        dd($request->all());

        // Validate the request data
        $validatedData = $request->validate([
            'organization_initial_info' => 'nullable|json',
            'organization_basic_info' => 'nullable|json',
            'organization_personal_info' => 'nullable|json',
            'organization_communication_info' => 'nullable|json',
            'organization_service_info' => 'nullable|json',
            'prospect_type' => 'required|string',
        ]);

        // Decode JSON data if necessary
        $organization_initial_info = json_decode($request->input('organization_initial_info'), true);
        $organization_basic_info = json_decode($request->input('organization_basic_info'), true);
        $organization_personal_info = json_decode($request->input('organization_personal_info'), true);
        $organization_communication_info = json_decode($request->input('organization_communication_info'), true);
        $organization_service_info = json_decode($request->input('organization_service_info'), true);


        $organization_initial_info_record = null;
        if ($organization_initial_info) {
            $organization_initial_info_record = OrganizationInitialInfo::create($organization_initial_info);
        }

        $organization_basic_info_record = null;
        if ($organization_basic_info) {
            $organization_basic_info_record = OrganizationBasicInfo::create($organization_basic_info);
        }

        $organization_personal_info_record = null;
        if ($organization_personal_info) {
            $organization_personal_info_record = OrganizationPersonalInfo::create($organization_personal_info);
        }

        $organization_communication_info_record = null;
        if ($organization_communication_info) {
            $organization_communication_info_record = OrganizationCommunicationInfo::create($organization_communication_info);
        }

        $organization_service_info_record = null;
        if ($organization_service_info) {
            $organization_service_info_record = OrganizationServiceInfo::create($organization_service_info);
        }

        if ($organization_initial_info_record || $organization_basic_info_record || $organization_personal_info_record || $organization_communication_info_record || $organization_service_info_record) {
            $individualInfo = IndividualInfo::create([
                'prospect_type' => $request->input('prospect_type'),
                'organization_initial_info_id' => $organization_initial_info_record->id ?? null,
                'organization_basic_info_id' => $organization_basic_info_record->id ?? null,
                'organization_personal_info_id' => $organization_personal_info_record->id ?? null,
                'organization_communication_info_id' => $organization_communication_info_record->id ?? null,
                'organization_service_info_id' => $organization_service_info_record->id ?? null,
            ]);
            return response()->json(['message' => 'Record created successfully', 'data' => $individualInfo], 201);
        }

        return response()->json(['message' => 'No valid data to insert'], 400);
    }



    // Update an existing individual info record
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'organization_initial_info' => 'nullable|json',
            'organization_basic_info' => 'nullable|json',
            'organization_personal_info' => 'nullable|json',
            'organization_communication_info' => 'nullable|json',
            'organization_service_info' => 'nullable|json',
            'prospect_type' => 'required|string',
        ]);

        $individualInfo = IndividualInfo::findOrFail($id);

        $organization_initial_info_data = json_decode($request->input('organization_initial_info'), true);
        $organization_basic_info_data = json_decode($request->input('organization_basic_info'), true);
        $organization_personal_info_data = json_decode($request->input('organization_personal_info'), true);
        $organization_communication_info_data = json_decode($request->input('organization_communication_info'), true);
        $organization_service_info_data = json_decode($request->input('organization_service_info'), true);

        if ($organization_initial_info_data) {
            $organization_initial_info = OrganizationInitialInfo::updateOrCreate(
                ['id' => $individualInfo->organization_initial_info_id],
                $organization_initial_info_data
            );
        }

        if ($organization_basic_info_data) {
            $organization_basic_info = OrganizationBasicInfo::updateOrCreate(
                ['id' => $individualInfo->organization_basic_info_id],
                $organization_basic_info_data
            );
        }
        if ($organization_personal_info_data) {
            $organization_personal_info = OrganizationPersonalInfo::updateOrCreate(
                ['id' => $individualInfo->organization_personal_info_id],
                $organization_personal_info_data
            );
        }
        if ($organization_communication_info_data) {
            $organization_communication_info = OrganizationCommunicationInfo::updateOrCreate(
                ['id' => $individualInfo->organization_communication_info_id],
                $organization_communication_info_data
            );
        }
        if ($organization_service_info_data) {
            $organization_service_info = OrganizationServiceInfo::updateOrCreate(
                ['id' => $individualInfo->organization_service_info_id],
                $organization_service_info_data
            );
        }

        $individualInfo->update([
            'prospect_type' => $request->input('prospect_type'),
            'organization_initial_info_id' => $organization_initial_info->id ?? $individualInfo->organization_initial_info_id,
            'organization_basic_info_id' => $organization_basic_info->id ?? $individualInfo->organization_basic_info_id,
            'organization_personal_info_id' => $organization_personal_info->id ?? $individualInfo->organization_personal_info_id,
            'organization_communication_info_id' => $organization_communication_info->id ?? $individualInfo->organization_communication_info_id,
            'organization_service_info_id' => $organization_service_info->id ?? $individualInfo->organization_service_info_id,
        ]);

        return response()->json(['message' => 'Record updated successfully', 'data' => $individualInfo], 200);
    }


    // Delete an individual info record and its related data
    public function destroy($id)
    {
        $individualInfo = IndividualInfo::findOrFail($id);

        // Delete associated information if necessary
        if ($individualInfo->organization_initial_info_id) {
            OrganizationInitialInfo::find($individualInfo->organization_initial_info_id)?->delete();
        }
        if ($individualInfo->organization_basic_info_id) {
            OrganizationBasicInfo::find($individualInfo->organization_basic_info_id)?->delete();
        }
        if ($individualInfo->organization_personal_info_id) {
            OrganizationPersonalInfo::find($individualInfo->organization_personal_info_id)?->delete();
        }
        if ($individualInfo->organization_communication_info_id) {
            OrganizationCommunicationInfo::find($individualInfo->organization_communication_info_id)?->delete();
        }
        if ($individualInfo->organization_service_info_id) {
            OrganizationServiceInfo::find($individualInfo->organization_service_info_id)?->delete();
        }

        $individualInfo->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
