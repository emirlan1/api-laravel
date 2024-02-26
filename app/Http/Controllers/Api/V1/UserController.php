<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Resources\V1\CarResource;
use App\Http\Resources\V1\UserResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new UserFilter();
        $queryItems = $filter->transform($request);

        if (count($queryItems) == 0) {
            return UserResource::collection(User::paginate());
        } else {
            $users = User::where($queryItems)->paginate();
            return UserResource::collection($users->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function link(User $user, $carId)
    {
        if ($user->car()) {
            // Отвязываем текущую машину от пользователя
            $user->car()->update(['user_id' => null]);
        }

        $car = Car::find($carId);

        if ($car) {
            // Привязываем машину к пользователю
            $car->user_id = $user->id;
            $car->save();

            // Возвращаем ресурс с привязанной машиной
            return new UserResource($user);
        } else {
            // Возвращаем ошибку или что-то еще в случае, если машина не найдена
            return response()->json(['error' => 'Машина не найдена'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
