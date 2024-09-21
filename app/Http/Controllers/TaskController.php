<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\SubCategory;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Task $task, Request $request)
    {
        if ($request->ajax()) {
            $tasks = $task->with('subCategory')->orderBy('id', 'desc')->get();
            $sl = 1;
            return $this->table($tasks)
            ->addColumn('sl', function ($row) use (&$sl) {

                return $sl++;

             })
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => url('/task/'.$row->id.'/edit'),
                            'button_text' => 'Edit',
                            'is_modal' => false,
                        ],

                    ]);
                })
                ->addColumn('sub_category', function ($row) {
                    return $row->subCategory ? $row->subCategory->sub_category_name : 'N/A';
                })
                ->editColumn('status', function ($row) {

                    if ($row->status == 1) {
                        return  '<button type="button" class="btn btn-sm btn-success">Active</button>';
                    } else {
                        return '<button type="button" class="btn btn-sm btn-danger">Inactive</button>';
                    }
                })
                ->escapeColumns('status')
                ->rawColumns(['action'])
                ->make(true);


        }
        $subcategories = SubCategory::get();
        return view('auth.user.tasks.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $task = new Task();
            $task->subcategory_id = $request->subcategory_id ?? null;
            $task->name = $request->name ?? null;
            $task->status = $request->status ?? 1;
            $task->save();

            DB::commit();
            Session::flash('message', 'Task created successfully!');
            return redirect()->route('task.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $subcategories = SubCategory::get();
        return view('auth.user.tasks.edit', compact('task','subcategories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        DB::beginTransaction();
        try {
            $task->subcategory_id = $request->subcategory_id ?? null;
            $task->name = $request->name ?? null;
            $task->status = $request->status ?? 1;
            $task->update();

            DB::commit();
            Session::flash('message', 'Task updated successfully!');
            return redirect()->route('task.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
