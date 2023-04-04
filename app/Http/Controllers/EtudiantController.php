<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use Illuminate\http\Request;
use Exception;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Etudiant::query();
        $perPage = 2;
        $page = $request->input('page', 1);
        $search = $request->input('search');

        if ($search) {
            $query->whereRaw("nom LIKE '% " . $search . " %'");
        }
        $total = $query->count();
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();
        try {

            return response()->json([
                'status' => 200,
                'message' => 'liste des étudiants récupérés',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result

            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function getEtudiant($id)
    {
        //
        $etudiant = Etudiant::where('id', $id)->exists();
        if ($etudiant) {
            $info = Etudiant::find($id);
            return response()->json([
                "status" => 1,
                "message" => "étudiant trouvé",
                "data" =>  $info
            ], 200);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "aucun étudiant  trouvé"

            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreEtudiantRequest $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEtudiantRequest $request)
    {
        //

        try {
            $etudiant = new Etudiant();
            $etudiant->nom = $request->nom;
            $etudiant->email = $request->email;
            $etudiant->motdepass = $request->motdepass;
            $etudiant->save();
            return response()->json([
                "status_code" => 200,
                "status_massage" => "Etudiant ajouté",
                "data" => $etudiant
            ]);
        } catch (Exception $e) {

            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function listEtudiant(Etudiant $etudiant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $etudiant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEtudiantRequest $request, Etudiant $id)
    {
        $etudiant = Etudiant::where('id', $id)->exists();

        if ($etudiant) {
            $info = Etudiant::find($id);

            $info->nom = $request->nom;
            $info->email = $request->email;
            $info->motdepass = $request->motdepass;
            $info->update();

            return response()->json([
                "status" => 1,
                "massage" => "Etudiant mis à jour"

            ], 404);
        } else {
            return  response()->json([
                "status" => 0,
                "message" => "Aucun étudiant   à mis à jour trouvé"

            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Etudiant $id)
    {
        try {
            $etudiant = Etudiant::where('id', $id)->exists();


            if ($etudiant) {
                $etudiant = Etudiant::find($id)->first();

                $etudiant->delete();

                return response()->json([
                    "status" => 1,
                    "message" => "etudiant supprimé"
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "message" => "l'etudiant n'existe pas"
                ]);
            };
        } catch (Exception $e) {
            return response($e);
        }
    }
}
