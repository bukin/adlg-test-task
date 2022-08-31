<?php

namespace  Bukin\AdminPanel\Base\Presentation\Http\Responses;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class Response implements Responsable
{
    public function __construct(
        protected $error = null
    ){}

    public function setError(?Exception $error): void
    {
        $this->error = $error;
    }

    public function toResponse($request): ?JsonResponse
    {
        if ($this->error) {
            return response()->json([
                'error' => $this->error->getMessage()
            ], $this->error->getCode());
        }

        return null;
    }
}
