<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueProductInCategory implements ValidationRule
{
    public $categoryId;

    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isProductExist = Product::where('category_id',$this->categoryId)->where('name',$value)->exists();
        if($isProductExist)
        {
            $fail("Product is already linked to the given category.");
        }

    }
}
