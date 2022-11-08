<?php


namespace App\Repository\EmitterOrganization;

use App\Models\EmitterOrganizaion\EmitterOrgs;


class EmitterOrganizationRepository
{
    /**
     * @var EmitterOrgs
     */
    private $emitterOrgs;

    public function __construct(EmitterOrgs $emitterOrgs)
    {

        $this->emitterOrgs = $emitterOrgs;
    }

    public function all()
    {
        $assignorgs = $this->emitterOrgs->orderBy('id', 'asc')->get();
        return $assignorgs;
    }



}
