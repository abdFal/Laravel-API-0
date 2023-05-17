<?php

namespace App\Http\Resources;

use App\Models\Comments;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use NunoMaduro\Collision\Writer;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cringe = false;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'image' => $this->image,
            'writer' => $this->writer['username'],
            'created_at' => date_format($this->created_at,'Y-m-d H:i') ,
            'is_cringe' => $cringe,
            'total_comments' => $this->comments->count(),
            'isi_comment' => CommentResource::collection($this->comments)
        ];
    }

    /**
     * Get the comments that owns the NewsResource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
}
