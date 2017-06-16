<?php

declare(strict_types=1);

namespace Cortex\Taggable\Http\Requests\Backend;

use Cortex\Taggable\Models\Tag;
use Rinvex\Support\Http\Requests\FormRequest;

class TagFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tag = $this->route('tag') ?? new Tag();
        $tag->updateRulesUniques();

        return $tag->getRules();
    }
}
