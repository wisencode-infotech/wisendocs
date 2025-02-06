<?php

namespace App\Http\Controllers\Backend;

use App\Models\TopicBlock;
use App\Models\Topic;
use App\Models\BlockType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Version;
use Yajra\DataTables\Facades\DataTables;

class TopicBlockController extends Controller
{
    /**
     * Display a listing of the topic blocks.
     */
    public function index(Request $request, Version $version)
    {
        if ($request->ajax()) {

            $data = TopicBlock::whereHas('topic', function ($query) use ($version) {
                $query->where('version_id', $version->id);
            })->latest()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('topic', function ($row) {
                    return $row->topic->name ?? 'N/A';
                })
                ->addColumn('block_type', function ($row) {
                    return $row->blockType->type ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('backend.topic-block.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.topic-block.index', compact('version'));
    }

    /**
     * Show the form for creating a new topic block.
     */
    public function create()
    {
        $topics = Topic::all();
        $blockTypes = BlockType::all();
        return view('backend.topic-block.create', compact('topics', 'blockTypes'));
    }

    /**
     * Store a newly created topic block in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'block_type_id' => 'required|exists:block_types,id',
            'name' => 'required|string|max:255',
            'attributes' => 'nullable|array',
        ]);

        TopicBlock::create([
            'topic_id' => $request->topic_id,
            'block_type_id' => $request->block_type_id,
            'name' => $request->name,
            'attributes' => json_encode($request->attributes), // Store attributes as JSON
        ]);

        return redirect()->back()->with('success', 'Topic block created successfully.');
    }

    /**
     * Show the form for editing the specified topic block.
     */
    public function edit(TopicBlock $topicBlock)
    {
        $topics = Topic::all();
        $blockTypes = BlockType::all();
        return view('backend.topic-block.edit', compact('topicBlock', 'topics', 'blockTypes'));
    }

    /**
     * Update the specified topic block.
     */
    public function update(Request $request, TopicBlock $topicBlock)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'block_type_id' => 'required|exists:block_types,id',
            'name' => 'required|string|max:255',
            'attributes' => 'nullable|array',
        ]);

        $topicBlock->update([
            'topic_id' => $request->topic_id,
            'block_type_id' => $request->block_type_id,
            'name' => $request->name,
            'attributes' => json_encode($request->attributes), // Update attributes as JSON
        ]);

        return redirect()->back()->with('success', 'Topic block updated successfully.');
    }

    /**
     * Remove the specified topic block.
     */
    public function destroy(TopicBlock $topicBlock)
    {
        if ($topicBlock) {
            $topicBlock->delete();
            return response()->json(['success' => 'Topic Block deleted successfully.']);
        }

        return response()->json(['error' => 'Topic Block not found.'], 404);
    }
}
