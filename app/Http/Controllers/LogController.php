<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Requests\LogRequest;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $role = session('role');
        $logs = Log::orderBy('id', 'asc')->get();
        return view('admin.a_log.index', compact('logs', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        return view('admin.a_log.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(Log $log)
    {
        $role = session('role');
        return view('logs.show', compact('log', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Log $log)
    {
        $role = session('role');
        return view('logs.edit', compact('log', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(LogRequest $request)
{
    $data = $request->validated();
    Log::create($data);

    return redirect()->route('logs.index')->with('success', 'Log entry created successfully.');
}

public function update(LogRequest $request, $id)
{
    $log = Log::findOrFail($id);
    $data = $request->validated();
    $log->update($data);

    return redirect()->route('logs.index')->with('success', 'Log entry updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log)
    {
        if ($log->delete()) {
            return redirect()->route('logs.index')->with('success', 'Log deleted successfully');
        } else {
            return redirect()->route('logs.index')->with('failed', 'Failed to delete log');
        }
    }
}
