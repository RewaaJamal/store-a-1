<?php

namespace App\Rules;

use App\Category;
use Illuminate\Contracts\Validation\Rule;

class CheckParent implements Rule
{

    protected $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $id=$this->id;
        $parents = Category::where('id','<>', $id)
    ->where (function($query) use ($id){
        $query->where('parent_id','<>', $id)
        ->orWhereNull('parent_id');

    })
    ->pluck('id')
    ->toArray();
    return in_array($value, $parents);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid parent.';
    }
}
