<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Cache\CacheControl;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $getPeople = CacheControl::peopleRedis("get", false);

            return response()->json([
                'data' => $getPeople
            ], 200);

        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Somethings went wrong',
                'error' => $e
            ], 500);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $incomeData = $request->all();
            $validator = Validator::make($incomeData, [
                'name' => 'required|string|max:255',
                'birthday' => 'required',
                'gender' => 'required|string|max:55',
                'address' => 'required|string|max:255',
                'post_code' => 'required|string|max:55',
                'city_name' => 'required|string|max:55',
                'country_name' => 'required|string|max:55'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ], 400);
            } else {
                $data = $validator->validated();

                $personCreate = People::create($incomeData);
                $personCreate->addresses()->create($incomeData);

                CacheControl::clearRedis("people:all:get");

                return response()->json([
                    'message' => 'Person successfully added'
                ], 200);
            }

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Somethings went wrong',
                'error' => $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $getPerson = CacheControl::peopleRedis(['person_id' => $id], true);

            return response()->json([
                'data' => $getPerson
            ], 200);

        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Somethings went wrong',
                'error' => $e
            ], 500);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $incomeData = $request->all();
            $validator = Validator::make($incomeData, [
                'name' => 'required|string|max:255',
                'birthday' => 'required',
                'gender' => 'required|string|max:55',
                'address' => 'required|string|max:255',
                'post_code' => 'required|string|max:55',
                'city_name' => 'required|string|max:55',
                'country_name' => 'required|string|max:55'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ], 400);
            } else {
                $data = $validator->validated();
                $person = People::find($id);
                $person->update($incomeData);
                $person->addresses()->update([
                        'address' => $incomeData['address'],
                        'post_code' => $incomeData['post_code'],
                        'city_name' => $incomeData['city_name'],
                        'country_name' => $incomeData['country_name']
                    ]
                );

                CacheControl::clearRedis("people:person_id-$id:first");
                CacheControl::clearRedis("people:all:get");

                return response()->json([
                    'message' => 'Person successfully updated'
                ], 200);
            }

        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Somethings went wrong',
                'error' => $e
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $person = People::find($id);
            $person->addresses()->delete();

            $person->delete();

            CacheControl::clearRedis("people:person_id-$id:first");
            CacheControl::clearRedis("people:all:get");

            return response()->json([
                'message' => 'Person successfully deleted'
            ], 200);


        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Somethings went wrong',
                'error' => $e
            ], 500);

        }
    }
}
