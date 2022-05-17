<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($data){
            return [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at
            ];
        });
    }
}
