<?php

declare(strict_types=1);

namespace Cortex\Tags\Transformers\Adminarea;

use Rinvex\Tags\Contracts\TagContract;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(TagContract $tag): array
    {
        return [
            'id' => (int) $tag->getKey(),
            'name' => (string) $tag->name,
            'slug' => (string) $tag->slug,
            'group' => (string) $tag->group,
            'sort_order' => (string) $tag->sort_order,
            'created_at' => (string) $tag->created_at,
            'updated_at' => (string) $tag->updated_at,
        ];
    }
}
