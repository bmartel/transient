<?php

namespace Bmartel\Transient;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Transient extends Model
{
    public $table = 'transients';

    public $fillable = ['model_type', 'model_id', 'signature', 'property', 'value', 'expire'];

    /**
     * Relationship for models to hook into, to store their transient properties.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function property()
    {
        return $this->morphTo();
    }

    /**
     * Expire the transient
     *
     * @return bool|int
     */
    public function expire()
    {
        return $this->update(['expire' => Carbon::now()]);
    }

    /**
     * Scope retrieving all transient values which have expired.
     *
     * @param $query
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->where('expire', '<', Carbon::now());
    }

} 