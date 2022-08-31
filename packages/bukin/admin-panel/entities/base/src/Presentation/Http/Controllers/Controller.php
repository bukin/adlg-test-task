<?php

namespace Bukin\AdminPanel\Base\Presentation\Http\Controllers;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        public Application $app
    ) {}

    protected function process($request, $operation, $response)
    {
        $data = $request->getDataObject();

        $result = null;

        try {
            $result = $operation->execute($data);
        } catch (Exception $error) {
            $response->setError($error);
        }

        $response->setResult($result);

        return $response;
    }
}
