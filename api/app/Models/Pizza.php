<?php

namespace App\Models {

    use Illuminate\Database\Eloquent\Model;

    class Pizza extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
          'name',
          'price',
          'properties'
        ];

        const VALID_PROPERTIES = [
          'vegan',
          'vegetarian',
          'glutenfree',
          'spicy',
          'sweet'
        ];

        public function properties($sorted = true)
        {
            $arr = explode(',', $this->properties);
            if ($sorted) {
                sort($arr);
            }
            return $arr;
        }

        public function hasProperty($property)
        {
            return in_array($property, $this->properties());
        }

        public function isValidProperty($property)
        {
            return in_array($property, self::VALID_PROPERTIES);
        }


        public function addProperty($property)
        {
            if (!$this->isValidProperty($property)) {
                throw new Pizza\InvalidPropertyException('"' . $property . '" is not a valid property');
            }

            if (!$this->hasProperty($property)) {
                $this->properties = $this->properties . ',' . $property;
                $this->save();
                return true;
            }

            return false;
        }
    }
}

namespace App\Models\Pizza {
    class InvalidPropertyException extends \Exception {};
}
