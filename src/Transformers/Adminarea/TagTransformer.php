<?php

declare(strict_types=1);

namespace Cortex\Tags\Transformers\Adminarea;

use Cortex\Tags\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Tag $tag): array
    {
        return [
            'id' => (string) $tag->getRouteKey(),
            'name' => (string) $tag->name,
            'group' => (string) $tag->group,
            'created_at' => (string) $tag->created_at,
            'updated_at' => (string) $tag->updated_at,
        ];
    }
}
