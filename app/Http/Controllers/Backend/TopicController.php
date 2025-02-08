<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Version;
use App\Rules\UniqueSlugPerVersion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{
    /**
     * Display a listing of the topics.
     */
    public function index(Request $request, Version $version)
    {
        if ($request->ajax()) {
            $data = Topic::where('version_id', $version->id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('slug', function ($row) {
                    return $row->slug;
                })
                ->addColumn('version', function ($row) {
                    return $row->versioning->identifier ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('backend.topic.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <a href="' . route('backend.topic-block.manage', $row->id) . '" class="manage btn btn-info btn-sm">Manage Topic Content</a>';
                    $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.topic.index', compact('version'));
    }

    /**
     * Show the form for creating a new topic.
     */
    public function create()
    {
        $versions = Version::all();
        return view('backend.topic.create', compact('versions'));
    }

    /**
     * Store a newly created topic in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'version_id' => 'required|exists:versions,id',
        ]);

        try {

            $slug = \Str::slug($request->name); // Generate slug from name
            $slug = $this->generateUniqueSlug($slug, $request->version_id); 

            Topic::create([
                'name' => $request->name,
                'slug' => $slug,
                'version_id' => $request->version_id,
            ]);

            $version = Version::find($request->version_id);

            app('App\Helpers\SystemUtils')->setVersionIdentifier($version)->clearCached('topics');

            return redirect()->back()->with('success', 'Topic created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    private function generateUniqueSlug($slug, $versionId, $count = 0)
    {
        $newSlug = $count ? "{$slug}-{$count}" : $slug;

        if (Topic::where('slug', $newSlug)->where('version_id', $versionId)->exists()) {
            return $this->generateUniqueSlug($slug, $versionId, $count + 1);
        }

        return $newSlug;
    }

    /**
     * Show the form for editing the specified topic.
     */
    public function edit(Topic $topic)
    {
        $versions = Version::all();
        return view('backend.topic.edit', compact('topic', 'versions'));
    }

    /**
     * Update the specified topic.
     */
    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'slug' => 'required|string|max:255|unique:topics,slug,' . $topic->id,
            'version_id' => 'required|exists:versions,id',
            'slug' => ['required', 'string', 'max:255', new UniqueSlugPerVersion($request->version_id, $topic->id)],
        ]);

        $topic->update($request->all());

        $version = Version::find($request->version_id);

        app('App\Helpers\SystemUtils')->setVersionIdentifier($version)->clearCached('topics');

        return redirect()->back()->with('success', 'Topic updated successfully.');
    }

    /**
     * Remove the specified topic.
     */
    public function destroy($id)
    {
        $topic = Topic::find($id);
        if ($topic) {
            $topic->delete();
            return response()->json(['success' => 'Topic deleted successfully.']);
        }
        return response()->json(['error' => 'Topic not found.'], 404);
    }
}
