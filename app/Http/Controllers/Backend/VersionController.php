<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Version;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class VersionController extends Controller
{
    /**
     * Display a listing of the versions.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Version::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('identifier', function ($row) {
                    return $row->identifier;
                })
                ->addColumn('description', function ($row) {
                    return $row->description;
                })
                ->addColumn('notes', function ($row) {
                    return $row->notes;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('backend.version.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.versions.index');
    }

    /**
     * Show the form for creating a new version.
     */
    public function create()
    {
        $versions = Version::all();
        return view('backend.versions.create', compact('versions'));
    }

    /**
     * Store a newly created version in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|max:255|unique:versions,identifier',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'existing_version' => 'nullable|exists:versions,id',
        ]);

        try {
            $new_version = Version::create([
                'identifier' => $request->identifier,
                'description' => $request->description,
                'notes' => $request->notes,
            ]);

            if ($request->copy_content && $request->existing_version) {
                $existing_version = Version::find($request->existing_version);

                foreach ($existing_version->topics as $topic) {
                    $new_topic = $topic->replicate();
                    $new_topic->version_id = $new_version->id;
                    $new_topic->slug = Str::slug($new_topic->name);
                    $new_topic->save();

                    foreach ($topic->blocks as $block) {
                        $new_block = $block->replicate();
                        $new_block->topic_id = $new_topic->id;
                        $new_block->save();
                    }
                }
            }

            // app('App\Helpers\SystemUtils')->clearCached('versions');
            app('App\Helpers\SystemUtils')->clearAllCache();

            return redirect()->route('backend.version.index')->with('success', 'Version created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified version.
     */
    public function edit(Version $version)
    {
        return view('backend.versions.edit', compact('version'));
    }

    /**
     * Update the specified version.
     */
    public function update(Request $request, Version $version)
    {
        $request->validate([
            'identifier' => 'required|string|max:255|unique:versions,identifier,' . $version->id,
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $version->update($request->all());

        // app('App\Helpers\SystemUtils')->clearCached('versions');
        app('App\Helpers\SystemUtils')->clearAllCache();

        return redirect()->route('backend.version.index')
            ->with('success', 'Version updated successfully.');
    }

    /**
     * Remove the specified version.
     */
    public function destroy($id)
    {
        $version = Version::find($id);
        if ($version) {
            $version->delete();

            app('App\Helpers\SystemUtils')->clearAllCache();

            return response()->json(['success' => 'Version deleted successfully.']);
        }
        return response()->json(['error' => 'Version not found.'], 404);
    }
}
