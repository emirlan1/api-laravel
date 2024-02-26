<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CarFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCarRequest;
use App\Http\Requests\V1\UpdateCarRequest;
use App\Http\Resources\V1\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CarFilter();
        $queryItems = $filter->transform($request);

        if (count($queryItems) == 0) {
            return CarResource::collection(Car::paginate());
        } else {
            $users = Car::where($queryItems)->paginate();
            return CarResource::collection($users->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        return new CarResource(Car::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return new CarResource($car);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->all());

        return new CarResource($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
