<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use App\Models\User;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Notes::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $id = User::all()->first()->id;
        
        // try {
            $newNote = Notes::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id ? $request->user_id : $id
            ]);

            if ($newNote) {
                return response()->json('Note saved');
            } else {
                abort(400, 'Something went wrong');
            }
        // } catch (\Throwable $th) {
        //     abort(400, 'Something went wrong');
        // }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Notes $notes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notes $notes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notes $notes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notes $notes, $key)
    {
        // try {
            $note = Notes::find(intval($key));
            $note->delete();

            return response()->json('Note deleted');
        // } catch (\Throwable $th) {
        //     abort(400, 'Something went wrong');
        // }
    }
}
