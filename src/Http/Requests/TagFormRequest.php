<?php

declare(strict_types=1);

namespace Cortex\Taggable\Http\Requests\Backend;

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
        $tag = $this->route('tag') ?? app('rinvex.taggable.tag');
        $tag->updateRulesUniques();

        return $tag->getRules();
    }
}
