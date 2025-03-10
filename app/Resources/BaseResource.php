<?php

namespace App\Http\Resources;

use App\Constants\ApiConstants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public function withResponse(Request $request, $response)
    {
        $response->setData([
            ApiConstants::SUCCESS => true,
            ApiConstants::CODE => 200,
            ApiConstants::DATA => $response->getData(),
            ApiConstants::MESSAGE => 'Request successful'
        ]);
    }
}
