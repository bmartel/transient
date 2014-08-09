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
        $key = Config::get('app.key');

        $property = json_encode(['id' => $this->getKey(), 'model' => static::class, 'property' => $property]);
        $id = base64_encode(hash_hmac('sha256', $property, $key, true));

        return urlencode($id);
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