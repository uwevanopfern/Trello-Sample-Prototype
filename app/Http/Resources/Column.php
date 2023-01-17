<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Column extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public static $wrap = null; // is used to disable data wrapper and remove it from response


    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cards' => new CardCollection($this->cards)
        ];
    }
}
