<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use League\Fractal\Resource\Item;

class AuthController
{
    public function signup(SignupRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = AuthHandler::signup($request->all());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }

        $actor = $user->getUserActor();
        $actor->actable->setAttribute('associated', $user->associated ?: false);

        $resource = new Item($actor, new ActorTransformer, 'actor');

        return $this->response(
            $actor,
            $resource,
            Response::HTTP_CREATED,
            false,
            ['actable.club.city']
        );
    }
}
