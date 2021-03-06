<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactCsvImportRequest;
use App\Repository\ContactRepositoryInterface;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @var \App\Repository\ContactRepositoryInterface
     */
    private $contactRepository;

    /**
     * @param \App\Repository\ContactRepositoryInterface
     */
    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => $this->contactRepository->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactCsvImportRequest $request)
    {
        $data = $request->persist();

        if (!$data) {
            abort(422, 'The CSV file you are trying to upload is not compatible or it contains no data.');
        }

        return response()->json([
            'data' => $data,
            'message' => 'CSV File has been imported successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'message' => 'Not implemented'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => 'Not implemented'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([
            'message' => 'Not implemented'
        ]);
    }
}
