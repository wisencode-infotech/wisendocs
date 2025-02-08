<?php

namespace App\Http\Controllers\Backend;

use App\Models\TopicBlock;
use App\Models\Topic;
use App\Models\BlockType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ManageTopicBlockController extends Controller
{
    public function index(Request $request, Topic $topic)
    {
        $block_types = BlockType::all();

        $topic_blocks = TopicBlock::where('topic_id', $topic->id)
            ->whereNull('parent_id')
            ->with('children.blockType')
            ->orderBy('order')
            ->get();

        $block_html = $this->generateNestedList($topic_blocks, true);

        return view('backend.manage-topic-block.manage', compact('topic', 'block_types', 'block_html'));
    }

    private function generateNestedList($blocks, $isMain = false)
    {
        if ($blocks->isEmpty()) return '';

        $ulClass = $isMain ? 'list-group min-vh-50 border ui-sortable' : 'nested-list ui-sortable';
        $ulId = $isMain ? 'id="middle-list"' : '';

        $html = "<ul class=\"$ulClass\" $ulId>";

        foreach ($blocks as $block) {
            $level = $block->start_content_level;
            $type = $block->blockType->type ?? 'Unknown';

            $html .= "<li class=\"list-group-item selected-block level-$level\" 
                         data-type=\"$type\" 
                         data-attribute='" . htmlspecialchars($block->attributes, ENT_QUOTES, 'UTF-8') . "' 
                         data-level=\"$level\" 
                         data-id=\"$block->id\">";

            $html .= "<span class=\"item-content\">$type</span>";

            $html .= " <button class=\"btn btn-sm btn-success edit-block rounded-circle\"><i class=\"bx bx-pencil\"></i></button>";
            $html .= " <button class=\"btn btn-sm btn-danger rounded-circle remove-block\"><i class=\"bx bx-x\"></i></button>";
            $html .= "<ul class=\"nested-list\"></ul>";

            if ($block->children->isNotEmpty()) {
                $html .= $this->generateNestedList($block->children);
            }

            $html .= "</li>";
        
        }

        $html .= "</ul>";

        return $html;
    }
    
    // public function index(Request $request, Topic $topic)
    // {
    //     if ($request->ajax()) {

    //         $data = TopicBlock::where('topic_id', $topic->id)->orderBy('order', 'asc')->get();
            
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('block_type', function ($row) {
    //                 return $row->blockType->type ?? 'N/A';
    //             })
    //             ->addColumn('attributes', function ($row) {
    //                 return $row->attributes ?? 'N/A';
    //             })
    //             ->addColumn('order', function ($row) {
    //                 return $row->order ?? 'N/A';
    //             })
    //             ->addColumn('start_content_level', function ($row) {
    //                 return $row->start_content_level ?? 'N/A';
    //             })
    //             ->addColumn('action', function ($row) use ($topic) {
    //                 $btn = '<a href="' . route('backend.manage-topic-block.edit', ['topic' => $topic->id, 'topic_block' => $row->id]) . '" class="edit btn btn-primary btn-sm">Edit</a>';
    //                 $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('backend.manage-topic-block.index', compact('topic'));
    // }

    /**
     * Show the form for creating a new topic block.
     */
    public function create()
    {
        $block_types = BlockType::all();
        return view('backend.manage-topic-block.create', compact('block_types'));
    }

    /**
     * Store a newly created topic block in storage.
     */
    public function store(Request $request)
    {
        

    }

    /**
     * Show the form for editing the specified topic block.
     */
    public function edit(Topic $topic, TopicBlock $topic_block)
    {
        dump($topic);
        dd($topic_block);
        $block_types = BlockType::all();
        return view('backend.topic-block.edit', compact('topic_block', 'block_types'));
    }

    /**
     * Update the specified topic block.
     */
    public function update(Request $request, TopicBlock $topicBlock)
    {
        
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
