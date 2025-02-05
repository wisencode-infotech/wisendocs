<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Version;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{
    /**
     * Display a listing of the topics.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Topic::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('version', function ($row) {
                    return $row->versioning->identifier ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('backend.topic.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.topic.index');
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
            'name' => 'required|string|max:255|unique:topics,name',
            'version_id' => 'required|exists:versions,id',
        ]);

        try {
            Topic::create([
                'name' => $request->name,
                'slug' => \Str::slug($request->name),
                'version_id' => $request->version_id,
            ]);

            return redirect()->route('backend.topic.index')->with('success', 'Topic created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
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
            'name' => 'required|string|max:255|unique:topics,name,' . $topic->id,
            'version_id' => 'required|exists:versions,id',
        ]);

        $topic->update($request->all());

        return redirect()->route('backend.topic.index')->with('success', 'Topic updated successfully.');
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
