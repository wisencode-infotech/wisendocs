<?php

namespace App\Http\Controllers\Backend;

use App\Models\TopicBlock;
use App\Models\Topic;
use App\Models\BlockType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlockAttribute;
use Yajra\DataTables\Facades\DataTables;

class ManageTopicBlockController extends Controller
{
    public function manage(Request $request, Topic $topic)
    {
        $block_types = BlockType::all();

        $topic_blocks = TopicBlock::where('topic_id', $topic->id)
            ->whereNull('parent_id')
            ->with('children.blockType')
            ->orderBy('order')
            ->get();

        $block_html = $this->generateNestedList($topic_blocks, true);

        $block_attributes = BlockAttribute::all()->mapWithKeys(function ($item) {
            return [
                $item->blockType->type => is_array($item->attributes) ? array_values($item->attributes) : []
            ];
        });

        return view('backend.topic-block.manage', compact('topic', 'block_types', 'block_html', 'block_attributes'));
    }

    private function generateNestedList($blocks, $isMain = false)
    {
        $html = '';

        if ($blocks->isEmpty()) 
            return '';

        return $html;
    }

    public function saveAttributes(Request $request, Topic $topic)
    {
        $request->validate([
            'block_type_id' => 'required',
            'topic_id' => 'required',
            'topic_block_attributes' => 'required'
        ]);

        $topic_block_id = $request->topic_block_id ?? 0;
        $topic_id = $request->topic_id ?? 0;
        $block_type_id = $request->block_type_id ?? null;

        if (empty($topic_block_id))
            $topic_block = new TopicBlock();
        else
            $topic_block = TopicBlock::find($topic_block_id);

        $topic_block->topic_id = $topic_id;
        $topic_block->block_type_id = $block_type_id;

        $topic_block->attributes = json_encode($request->topic_block_attributes ?? []);

        $topic_block->save();

        app('App\Helpers\SystemUtils')->clearAllCache();

        return response()->json([
            'status' => true,
            'message' => 'Attributes saved successfully.',
            'data' => [
                'topic_block' => $topic_block
            ]
        ]);
    }

   
    public function publish(Request $request)
    {
        $topicId = $request->input('topic_id');
        $blocks = json_decode($request->input('blocks'), true);

        // Handle blocks recursively
        $this->processBlocks($blocks, $topicId, null); // Start with parent blocks

        return response()->json(['success' => true]);
    }

    /**
     * Recursively process blocks and insert/update records
     */
    private function processBlocks(array $blocks, int $topicId, ?int $parentId = null)
    {
        foreach ($blocks as $block) {
            // Save or update the topic block
            $topicBlock = TopicBlock::updateOrCreate(
                ['id' => $block['topic_block_id'] ?? null], // Only update if ID exists
                [
                    'topic_id' => $topicId,
                    'block_type_id' => $block['block_type_id'],
                    'parent_id' => $parentId, // Maintain hierarchy
                    'order' => $block['order'],
                    'start_content_level' => $block['start_content_level'],
                ]
            );

            // If the block has children, process them recursively
            if (!empty($block['children'])) {
                $this->processBlocks($block['children'], $topicId, $topicBlock->id);
            }
        }
    }

    /**
     * Remove the specified topic block.
     */
    // public function destroy(TopicBlock $topic_block)
    // {

    //     if ($topic_block) {
    //         $topic_block->delete();
    //         return response()->json(['status' => true, 'message' => 'Topic Block deleted successfully.']);
    //     }

    //     return response()->json(['error' => 'Topic Block not found.'], 404);
    // }

    public function destroy(Request $request, $topic)
    {
        $topicBlock = TopicBlock::find($request->id);
        // dd($topicBlock);

        if (!$topicBlock) {
            return response()->json(['status' => true, 'message' => 'Block deleted successfully']);
        }

        $topicBlock->delete();

        return response()->json(['status' => true, 'message' => 'Block deleted successfully']);
    }
}
