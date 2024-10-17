<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
    use ApiResponses;
    use AuthorizesRequests;

    protected string $policyClass;
    protected GateContract $gate;

    public function __construct(GateContract $gate)
    {
        $this->gate = $gate;

        $this->gate->guessPolicyNamesUsing(function () {
            return $this->policyClass;
        });
    }

    public function include(string $relationship): bool
    {
        $param = request()->get('include');
        if (!isset($param)) {
            return false;
        }
        $includeValues = explode(',', strtolower($param));
        return in_array(strtolower($relationship), $includeValues);
    }
}
