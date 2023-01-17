<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnRequest;
use App\Http\Resources\ColumnCollection;
use App\Http\Resources\Column as ColumnResource;
use App\Models\Column;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ColumnCollection
     */
    public function index(): ColumnCollection
    {
        return new ColumnCollection(Column::all()->sortByDesc("id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ColumnRequest $request
     * @return ColumnResource
     */
    public function store(ColumnRequest $request): ColumnResource
    {
        $column = new Column();
        $title = $request->title;

        $column->title = $title;
        $column->save();

        return new ColumnResource($column);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $column = Column::findOrFail($id);
        $cards = $column->cards;

        foreach ($cards as $card) {
            $card->deleted_at = Carbon::now()->format('Y-m-d H:i:s');;
            $card->save();
        }
        $column->delete();
        return response("", 204);;
    }
}
