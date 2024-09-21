<?php

namespace App\Http\Controllers;

use App\Helpers\PHPExportable;

use App\Http\Requests\ImportDatabaseRequest;
use App\Models\Backup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Contracts\Database\Query\Builder;


class DatabaseController extends Controller
{
    /**
     * Summary of export
     * @param Request $request
     * @return string
     */
    public function export(Request $request)
    {
        $headers = explode(',', $request->rows);
        $headers[0] === 'on' ? array_shift($headers) : true;

        $queryResult = DB::table($request->db_table)
            // ->when(
            //     $request->date_from && !$request->date_to,
            //     function (Builder $builder) use ($request) {
            //         $builder->whereDate('created_at', $request->date_from);
            //     }
            // )
            // ->when(
            //     $request->date_to && !$request->date_from,
            //     function (Builder $builder) use ($request) {
            //         $builder->whereDate('created_at', $request->date_to);
            //     }
            // )
            // ->when(
            //     $request->date_from && $request->date_to,
            //     function (Builder $builder) use ($request) {
            //         $builder->whereBetween('created_at', [
            //             $request->date_from,
            //             $request->date_to
            //         ]);
            //     }
            // )
            ->select($headers)
            ->get()
            ->toArray();

        $fileName = (new PHPExportable())->exportFromData(
            $queryResult,
            'csv_data',
            $headers
        );

        return asset('csv/' . $fileName);
    }

    /**
     * Summary of download
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        $file = File::glob(storage_path('app/*.csv'))[0];
        return response()->download($file)->deleteFileAfterSend();
    }
}
