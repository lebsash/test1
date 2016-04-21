<?php

/*
 * Intranet - dashboard
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Http\Controllers\Intranet;

use GAPlatform\Http\Controllers\Controller;
use GAPlatform\Libraries\LegacyHelpers;

use Session;
use GAPlatform\Models\GASalesPerson;
use GAPlatform\Models\GAUser;

class DashboardController extends Controller
{

    /**
     * Controller index method
     */
    public function index()
    {
        $data = $this->requests();
        $errors = [];

        $oSalesPerson = new GASalesPerson();
        $data['users']['live'] = $oSalesPerson->getAllAgents(10, 'live');
        $data['users']['deployed'] = $oSalesPerson->getAllAgents(10, 'deployed');
        $data['users']['suspended'] = $oSalesPerson->getAllAgents(10, 'suspended');

        return view('intranet.dashboard.index', $data);
    }
}
