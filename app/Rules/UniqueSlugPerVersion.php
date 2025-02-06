<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Topic;

class UniqueSlugPerVersion implements Rule
{
    protected $versionId;
    protected $topicId;

    public function __construct($versionId, $topicId = null)
    {
        $this->versionId = $versionId;
        $this->topicId = $topicId; // Null for create, topic ID for update
    }

    public function passes($attribute, $value)
    {
        $query = Topic::where('slug', $value)->where('version_id', $this->versionId);

        if ($this->topicId) {
            $query->where('id', '!=', $this->topicId); // Ignore current topic in update
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'The slug must be unique within the selected version.';
    }
}
