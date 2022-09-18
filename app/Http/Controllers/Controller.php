<?php

namespace App\Http\Controllers;

use App\CustomSerializer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($data, $resource, $statusCode, $paginated, $includes = [], $excludes = []): JsonResponse
    {
        $fractal = new Manager();
        $fractal->setSerializer(new CustomSerializer());
        $fractal->parseIncludes($includes);
        $fractal->parseExcludes($excludes);

        if ($paginated) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($data));
        }

        return response()->json(
            $fractal->createData($resource)->toArray(),
            $statusCode
        );
    }

    public function returnSuccess($data = ['message' => 'successful'], $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(
            $data,
            $status
        );
    }

    public function returnFail(
        $data = ['message' => 'An error has occurred.'],
        $status = Response::HTTP_UNPROCESSABLE_ENTITY
    ): JsonResponse {
        return response()->json(
            ['errors' => [$data]],
            $status
        );
    }
}
