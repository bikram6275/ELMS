<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\EnumeratorAssign\EnumeratorAssign;

class SurveyListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $survey = $this->Survey()->select('id', 'survey_name', 'start_date', 'end_date')->first();
        return [
            'id' => $survey->id,
            'survey_name' => $survey->survey_name,
            'start_date' => $survey->start_date,
            'end_date' => $survey->end_date
        ];
    }
}
