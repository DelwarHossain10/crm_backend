<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function allTaskPaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = Task::select('tasks.*',
            // 'quotations.quotation_number',
            // 'leads.lead_name',
        )
        // ->leftJoin('quotations', 'quotations.id', '=', 'sale_orders.prospect_id')
        // // ->leftJoin('prospects', 'prospects.id', '=', 'sale_orders.prospect_id')
        // ->leftJoin('leads', 'leads.id', '=', 'sale_orders.lead_id')
            ->latest();

        if ($search) {
            // $query->where('quotations.quotation_number', 'LIKE', '%' . $search . '%')
            // ->where('leads.lead_name', 'LIKE', '%' . $search . '%');
        }

        $data = $query->paginate($perPage);

        return response()->json($data, 200);
    }
    public function index()
    {
        try {
            $tasks = Task::all();
            return response()->json($tasks);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve tasks', 'message' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {

        try {
            // Validate the request
            $request->validate([
                'title' => 'nullable|string|max:255',
                'type' => 'nullable|string|max:255',
                'priority' => 'nullable|string|max:255',
                'prospect_id' => 'nullable|integer',
                'assign_to' => 'nullable|string|max:255',
                'contact' => 'nullable|string|max:255',
                'lead_id' => 'nullable|integer',
                'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'status' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Using Carbon to handle date and time formatting
            $startDateTime = $request->input('start_date') && $request->input('start_time')
            ? Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'))
            : null;

            $dueDateTime = $request->input('due_date') && $request->input('due_time')
            ? Carbon::parse($request->input('due_date') . ' ' . $request->input('due_time'))
            : null;

            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $attachmentPath = $file->store('attachments', 'public');
            }

            $taskId = DB::table('tasks')->insertGetId([
                'title' => $request->input('task_title'),
                'type' => $request->input('type'),
                'priority' => $request->input('priority'),
                'start_date' => $startDateTime,
                'due_date' => $dueDateTime,
                'prospect_id' => $request->input('prospect_id'),
                'assign_to' => $request->input('attention_person'),
                'contact' => $request->input('contact'),
                'lead_id' => $request->input('lead_id'),
                'attachment' => $attachmentPath,
                'status' => $request->input('status'),
                'description' => $request->input('task_description'),
                'template' => '',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Task created successfully!', 'task_id' => $taskId], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create task!', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show($id)
    {
        try {
            // Fetch the task from the database by ID
            $task = DB::table('tasks')->where('id', $id)->first();

            // Check if the task exists
            if (!$task) {
                return response()->json(['message' => 'Task not found.'], Response::HTTP_NOT_FOUND);
            }


            // Prepare the task details with formatted dates
            $taskDetails = [
                'id' => $task->id,
                'task_title' => $task->title,
                'type' => $task->type,
                'priority' => $task->priority,
                'start_date' => Carbon::parse($task->start_date)->format('Y-m-d'),
                'start_time' => Carbon::parse($task->start_date)->format('H:i'),
                'due_date' => Carbon::parse($task->due_date)->format('Y-m-d'),
                'due_time' => Carbon::parse($task->due_date)->format('H:i'),
                'prospect_id' => $task->prospect_id,
                'assign_to' => $task->assign_to,
                'contact' => $task->contact,
                'lead_id' => $task->lead_id,
                'attachment' => $task->attachment,
                'status' => $task->status,
                'description' => $task->description,
                'template' => $task->template,
                'created_by' => $task->created_by,
                'updated_by' => $task->updated_by,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
            ];
            $data= $taskDetails;
            // Return the task details with formatted dates
            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Failed to retrieve task: ' . $e->getMessage());

            // Handle any errors that occur during the process
            return response()->json(['message' => 'Failed to retrieve task!', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'title' => 'nullable|string|max:255',
                'type' => 'nullable|string|max:255',
                'priority' => 'nullable|string|max:255',
                'prospect_id' => 'nullable|integer',
                'assign_to' => 'nullable|string|max:255',
                'contact' => 'nullable|string|max:255',
                'lead_id' => 'nullable|integer',
                'attachments' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'status' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Find the task by ID
            $task = DB::table('tasks')->where('id', $id)->first();

            // Check if the task exists
            if (!$task) {
                return response()->json(['message' => 'Task not found.'], Response::HTTP_NOT_FOUND);
            }

            // Using Carbon to handle date and time formatting
            $startDateTime = $request->input('start_date') && $request->input('start_time')
                ? Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'))
                : $task->start_date;

            $dueDateTime = $request->input('due_date') && $request->input('due_time')
                ? Carbon::parse($request->input('due_date') . ' ' . $request->input('due_time'))
                : $task->due_date;

            // Handle file upload (keep existing attachment if not updated)
            $attachmentPath = $task->attachment;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $attachmentPath = $file->store('attachments', 'public');
            }

            // Update the task
            DB::table('tasks')->where('id', $id)->update([
                'title' => $request->input('task_title', $task->title),
                'type' => $request->input('type', $task->type),
                'priority' => $request->input('priority', $task->priority),
                'start_date' => $startDateTime,
                'due_date' => $dueDateTime,
                'prospect_id' => $request->input('prospect_id', $task->prospect_id),
                'assign_to' => $request->input('attention_person', $task->assign_to),
                'contact' => $request->input('contact', $task->contact),
                'lead_id' => $request->input('lead_id', $task->lead_id),
                'attachment' => $attachmentPath,
                'status' => $request->input('status', $task->status),
                'description' => $request->input('task_description', $task->description),
                'template' => '', // Assuming this is not changing
                'updated_by' => auth()->user()->id,
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Task updated successfully!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Log the error and return the response
            Log::error('Failed to update task: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update task!', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found', 'message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete task', 'message' => $e->getMessage()], 500);
        }
    }
}
