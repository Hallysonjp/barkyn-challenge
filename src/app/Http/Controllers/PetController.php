<?php
namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\PetRequest;
use App\Http\Resources\Pet as PetResource;
use App\Models\Pet;

class PetController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $pets = Pet::with('user')->get();
        return $this->sendResponse(PetResource::collection($pets), 'Pets retrieved succesfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PetRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PetRequest $request)
    {
        $pet = (new Pet())->createPet($request);
        return $this->sendResponse(new PetResource($pet), 'Pet saved succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $pet = Pet::find($id);

        if (is_null($pet)) {
            return $this->sendError('Pet not found.');
        }

        return $this->sendResponse(new PetResource($pet), 'Pet retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PetRequest  $request
     * @param  Pet  $pet
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PetRequest $request, Pet $pet)
    {
        $input  = $request->validated();

        $pet->name       = $input['name'];
        $pet->email      = $input['email'];
        $pet->gender     = $input['gender'];
        $pet->birth_date = $input['birth_date'];
        $pet->save();

        return $this->sendResponse(new PetResource($pet), 'Aluno atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $customer = Pet::find($id);
        $customer->subscription()->delete();
        $customer->delete();

        return $this->sendResponse([], 'Pet deleted succesfully.');
    }
}
