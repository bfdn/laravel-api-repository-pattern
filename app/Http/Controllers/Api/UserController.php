<?php

namespace App\Http\Controllers\Api;


use App\Core\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserController\CreateRequest;
use App\Http\Requests\UserController\DeleteRequest;
use App\Http\Requests\UserController\GetAllRequest;
use App\Http\Requests\UserController\GetByIdRequest;
use App\Http\Requests\UserController\GetProfileRequest;
use App\Http\Requests\UserController\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\Eloquent\IUserService;
use Illuminate\Http\Request;
use App\Core\ServiceResponse;

class UserController extends Controller
{
    use HttpResponse;
    private IUserService $userRepository;

    public function __construct(IUserService $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getPageAll(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $response = $this->userRepository->getPageAll(
            perPage: $perPage
        );
        // return UserResource::collection($response->getData());
        return $this->httpResponse($response);
    }

    public function getAll(GetAllRequest $request)
    {
        $response = $this->userRepository->getAll();
        return $this->httpResponse($response);
    }

    public function getById(GetByIdRequest $request)
    {
        $response = $this->userRepository->getById(
            id: $request->id
        );
        // return new UserResource($response->getData());
        return $this->httpResponse($response);
    }

    // public function create(string $name, string $email, string $password)
    public function create(CreateRequest $request)
    {
        \DB::beginTransaction();
        try {
            $response = $this->userRepository->create(
                name: $request->name,
                email: $request->email,
                password: $request->password,
            );
            DB::commit();
            return $this->httpResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->httpResponse(
                new ServiceResponse(false, $e->getMessage(), null, 500)
            );
        }
    }

    public function update(UpdateRequest $request)
    {
        \DB::beginTransaction();
        try {
            $response = $this->userRepository->update(
                id: $request->id,
                name: $request->name,
                email: $request->email,
                password: $request->password,
            );
            DB::commit();
            return $this->httpResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->httpResponse(
                new ServiceResponse(false, $e->getMessage(), null, 500)
            );
        }
    }

    public function delete(DeleteRequest $request)
    {
        \DB::beginTransaction();
        try {
            $response = $this->userRepository->delete(
                id: $request->id
            );
            DB::commit();
            return $this->httpResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->httpResponse(
                new ServiceResponse(false, $e->getMessage(), null, 500)
            );
        }
    }

    public function getProfile(GetProfileRequest $request)
    {
        $response = $this->userRepository->getProfile();
        return $this->httpResponse($response);
    }
}
