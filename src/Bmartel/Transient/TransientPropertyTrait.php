<?php

namespace Bmartel\Transient;


use Config;

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
        $key = Config::get('app.key'); // Sign the signature with the app key to know it came from this app.

        $property = json_encode([
            'id' => $this->getKey(),
            'model' => static::class,
            'property' => $property,
            'created' => $this->created_at->timestamp
        ]);

        return urlencode(base64_encode(hash_hmac('sha256', $property, $key, true)));
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