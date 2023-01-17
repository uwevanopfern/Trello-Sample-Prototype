<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CardCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array|Arrayable
     */

    public static $wrap = null; // is used to disable data wrapper and remove it from response

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
