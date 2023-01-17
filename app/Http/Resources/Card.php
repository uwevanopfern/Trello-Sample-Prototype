<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Card extends JsonResource
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
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'description' => $this->description,
            'deleted_at' => $this->deleted_at
        ];
    }
}
