<?php
namespace Bmartel\Transient;


interface TransientPropertyInterface {

    /**
     * Return a signature for the property.
     *
     * @param $property
     * @return string
     */
    public function signature($property);

    /**
     * Relationship with the Transient object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transientProperties();
} 