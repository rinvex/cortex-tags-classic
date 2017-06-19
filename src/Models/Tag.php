<?php

declare(strict_types=1);

namespace Cortex\Taggable\Models;

use Rinvex\Taggable\Tag as BaseTag;

/**
 * Cortex\Taggable\Models\Tag.
 *
 * @property int                 $id
 * @property string              $slug
 * @property array               $name
 * @property array               $description
 * @property int                 $sort_order
 * @property string|null         $group
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Taggable\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Taggable\Tag withGroup($group = null)
 * @mixin \Eloquent
 */
class Tag extends BaseTag
{
    //
}
