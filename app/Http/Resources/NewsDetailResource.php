<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post_id' => $this->id,
            'title' => $this->title,
            'writer' => $this->whenLoaded('writer', function(){
                return $this->writer['username'];
            }),
            'news_content' => $this->news_content,
            'image' => $this->image,
            'created_at' => date_format($this->created_at, 'Y-m-d H:i'),
            'total_comments' => $this->comments->count(),
            'isi_comment' => CommentResource::collection($this->comments)
        ];
    }
}
