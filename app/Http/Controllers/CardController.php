<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use App\Http\Resources\Card as CardResource;
use App\Http\Resources\CardCollection;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CardCollection
     */
    public function index(Request $request): CardCollection
    {
        $status = $request->status;
        if ($status == 1) {
            // deleted_at empty which means cards are active and have not been deleted
            $cardsByDates = Card::whereDate('created_at', Carbon::parse($request->created_at)->format('Y-m-d'))
                ->whereNull('deleted_at')
                ->get();
            if ($cardsByDates->isEmpty()) {
                return new CardCollection(Card::all());
            }
        } else {
            // deleted_at is not empty because cards deleted at some certain dates
            // Because when a column is deleted , card's property deleted_at records time that deletion happened
            $cardsByDates = Card::whereDate('created_at', Carbon::parse($request->created_at)->format('Y-m-d'))
                ->whereNotNull('deleted_at')
                ->get();
            if ($cardsByDates->isEmpty()) {
                return new CardCollection(Card::all());
            }
        }
        return new CardCollection($cardsByDates);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CardRequest $request
     * @return CardResource
     */
    public function store(CardRequest $request): CardResource
    {
        $card = new Card();
        $column_id = $request->column_id;
        $title = $request->title;
        $description = $request->description;

        $latestDraggableOrder = Card::query()->latest()->first();

        if ($latestDraggableOrder) {
            $draggable_order = $latestDraggableOrder->draggable_order + 1;
        } else {
            $draggable_order = 1;
        }

        $card->column_id = $column_id;
        $card->title = $title;
        $card->description = $description;
        $card->draggable_order = $draggable_order;
        $card->save();

        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return CardResource
     */
    public function update(Request $request, int $id): CardResource
    {
        $card = Card::findOrFail($id);

        $card->title = $request->title;
        $card->description = $request->description;
        $card->save();

        return new CardResource($card);
    }

    public function updateOrder(Request $request)
    {
        //Get ID of card and id of the column where card is being dragged to
        //Update the order of card id
    }
}
