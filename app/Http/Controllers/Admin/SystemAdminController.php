<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SystemAdminController extends Controller
{
    public function index()
    {
        $systems = System::latest()->paginate(20);

        return view('admin.systems.index', compact('systems'));
    }

    public function create()
    {
        return view('admin.systems.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:100'],
            'system_id' => ['required', 'string', 'max:50', 'unique:systems,system_id', 'regex:/^[a-z0-9_-]+$/'],
        ]);

        $apiKey = Str::random(40);

        System::create([
            'name'      => $request->name,
            'system_id' => $request->system_id,
            'api_key'   => $apiKey,
            'is_active' => true,
        ]);

        return redirect()->route('admin.systems.index')
            ->with('api_key', $apiKey)
            ->with('success', 'System created successfully. Save the API key shown below — it will not be shown again.');
    }

    public function edit(int $id)
    {
        $system = System::findOrFail($id);

        return view('admin.systems.edit', compact('system'));
    }

    public function update(Request $request, int $id)
    {
        $system = System::findOrFail($id);

        $request->validate([
            'name'      => ['required', 'string', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $system->update([
            'name'      => $request->name,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.systems.index')
            ->with('success', 'System updated successfully.');
    }

    public function regenerateKey(int $id)
    {
        $system = System::findOrFail($id);

        $newKey = Str::random(40);
        $system->update(['api_key' => $newKey]);

        return redirect()->back()
            ->with('api_key', $newKey)
            ->with('success', 'API key regenerated. Save the new key — it will not be shown again.');
    }
}
