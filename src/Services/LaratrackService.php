<?php


namespace Susheelbhai\Laratrack\Services;

use Susheelbhai\Laratrack\Repository\LicenceRepository;

class LaratrackService
{

    public function trackLicence()
    {
        $repo = new LicenceRepository();
        return $repo->trackLicence();
    }

}
