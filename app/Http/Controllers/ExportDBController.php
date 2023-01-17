<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Spatie\DbDumper\Databases\MySql;

class ExportDBController extends Controller
{
    public function exportDb(Request $request): JsonResponse
    {
        MySql::create()
            ->setDbName('BeMo')
            ->setUserName('root')
            ->setPassword('')
            ->includeTables(['columns'])
            ->dumpToFile('dump.sql');

        return response()->json(['message' => 'success']);
    }
}
