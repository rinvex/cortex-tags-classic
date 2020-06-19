<?php

declare(strict_types=1);

namespace Cortex\Tags\Models;

use Rinvex\Support\Traits\Macroable;
use Rinvex\Tags\Models\Tag as BaseTag;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Cortex\Foundation\Events\ModelCreated;
use Cortex\Foundation\Events\ModelDeleted;
use Cortex\Foundation\Events\ModelUpdated;
use Cortex\Foundation\Events\ModelRestored;
use Spatie\Activitylog\Traits\LogsActivity;
use Cortex\Foundation\Traits\FiresCustomModelEvent;

/**
 * Cortex\Tags\Models\Tag.
 *
 * @property int                                                                           $id
 * @property string                                                                        $slug
 * @property array                                                                         $name
 * @property array                                                                         $description
 * @property int                                                                           $sort_order
 * @property string                                                                        $group
 * @property string                                                                        $style
 * @property string                                                                        $icon
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property \Carbon\Carbon|null                                                           $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Tags\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends BaseTag
{
    use Auditable;
    use Macroable;
    use HashidsTrait;
    use LogsActivity;
    use FiresCustomModelEvent;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
        'deleted' => ModelDeleted::class,
        'restored' => ModelRestored::class,
        'updated' => ModelUpdated::class,
    ];

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
    protected static $logFillable = true;

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

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable(['style', 'icon']);

        $this->mergeCasts(['style' => 'string', 'icon' => 'string']);

        $this->mergeRules(['style' => 'nullable|string|strip_tags|max:150', 'icon' => 'nullable|string|strip_tags|max:150']);

        $this->setTable(config('rinvex.tags.tables.tags'));
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
