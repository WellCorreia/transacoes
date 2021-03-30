<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!empty($this['result'])) {
            return $this['result'];
        }
        if (!empty($this['errorMessage']) && $this['status'] != 500) {
            return [
                'errorMessage' => $this['errorMessage']
            ];
        }

        return [
            'errorMessage' => 'Internal server error'
        ];
    }

    public static function getInstance($data){
        return (new UserResource($data));
    }
}