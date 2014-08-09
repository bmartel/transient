<?php
/**
 * Created by PhpStorm.
 * User: brand_000
 * Date: 09/08/14
 * Time: 1:09 AM
 */

namespace Bmartel\Transient;


trait TransientPropertyTrait
{

    /**
     * Return a signature for the property.
     *
     * @param $property
     * @return string
     */
    public function signature($property)
    {
        return md5(json_encode(['id' => $this->getKey(), 'model' => static::class, 'property' => $property]));
    }

    /**
     * Relationship with the Transient object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transientProperties()
    {
        return $this->morphMany('Bmartel\Transient\Transient', 'property', 'model_type', 'model_id');
    }

} 