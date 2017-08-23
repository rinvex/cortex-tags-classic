<?php

declare(strict_types=1);

namespace Cortex\Taggable\Transformers\Backend;

use League\Fractal\TransformerAbstract;
use Rinvex\Taggable\Contracts\TagContract;

class TagTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(TagContract $tag)
    {
        return [
            'id' => (int) $tag->id,
            'name' => (string) $tag->name,
            'slug' => (string) $tag->slug,
            'group' => (string) $tag->group,
            'sort_order' => (string) $tag->sort_order,
            'created_at' => (string) $tag->created_at,
            'updated_at' => (string) $tag->updated_at,
        ];
    }
}
