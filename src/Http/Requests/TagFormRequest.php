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
     * Process given request data before validation.
     *
     * @param array $data
     *
     * @return array
     */
    public function process($data)
    {
        // Sync categories
        if (! empty($data['categoryList'])) {
            $data['categories'] = $data['categoryList'];
        }

        return $data;
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
