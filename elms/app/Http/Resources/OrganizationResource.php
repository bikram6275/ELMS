<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $organization = $this->organization()->select('id', 'org_name', 'phone_no', 'establish_date')->first();
        return [
            'id' => $organization->id,
            'org_name' => $organization->org_name,
            'phone_no' => $organization->phone_no?$organization->phone_no : '123',
            'establish_date' => $organization->establish_date?$organization->establish_date:'1998',
            'pivot_id' => $this->id,
            'district_name' => $this->organization->district->english_name,
            'sector'=> $this->organization->sector->sector_name,
            'status' => ($this->finish_date != null)?'Completed':(($this->start_date!=null && $this->finish_date==null)?'In Progress':"Not Started"),
            'survey_status' => $this->status
        ];
    }
}
