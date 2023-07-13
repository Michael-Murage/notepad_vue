<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use App\Http\Requests\NotesRequest;

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
    public function store(NotesRequest $request)
    {
        $unauthorised_status = config()->get('variables')['UNAUTHORISED_STATUS'];
        $bad_request_status = config()->get('variables')['BAD_REQUEST_STATUS'];
        
        if (!$request->user_id) {
            abort($unauthorised_status, 'Not logged in');
        }
        
        // try {
            $newNote = Notes::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id
            ]);

            if ($newNote) {
                return response()->json('Note saved');
            } else {
                abort($bad_request_status, 'Something went wrong');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $note = Notes::find(intval($request->id));
        if ($note->title !== $request->title) {
            $note->title = $request->title;
        }
        if ($note->content !== $request->content) {
            $note->content = $request->content;
        }
        $note->save();
        return response()->json('Edit successful');
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
