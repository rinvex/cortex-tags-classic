<?php

declare(strict_types=1);

namespace Cortex\Taggable\Models;

use Rinvex\Taggable\Models\Tag as BaseTag;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Cortex\Taggable\Models\Tag.
 *
 * @property int                                                                           $id
 * @property string                                                                        $slug
 * @property array                                                                         $name
 * @property array                                                                         $description
 * @property int                                                                           $sort_order
 * @property string                                                                        $group
 * @property \Carbon\Carbon                                                                $created_at
 * @property \Carbon\Carbon                                                                $updated_at
 * @property \Carbon\Carbon                                                                $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Taggable\Models\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Taggable\Models\Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Taggable\Models\Tag withGroup($group = null)
 * @mixin \Eloquent
 */
class Tag extends BaseTag
{
    use LogsActivity;

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logAttributes = [
        'slug',
        'name',
        'description',
        'sort_order',
        'group',
    ];

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
