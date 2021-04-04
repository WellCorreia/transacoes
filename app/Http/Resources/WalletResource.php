<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
        if (!empty($this['message']) && $this['status'] != 500) {
            return [
                'message' => $this['message']
            ];
        }

        return [
            'message' => 'Internal server error'
        ];
    }

    public static function getInstance($data){
        return (new WalletResource($data));
    }
}
