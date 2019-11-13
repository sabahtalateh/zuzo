<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $prefix = config('app.url') . '/storage/';

        $imageUrl = $this->image;

        if (!(Str::startsWith($imageUrl, 'http://') || (Str::startsWith($imageUrl, 'https://')))) {
            $imageUrl = $prefix . $imageUrl;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'image' => $imageUrl,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
