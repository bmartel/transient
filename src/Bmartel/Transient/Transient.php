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
	 * Don't manage the updated_at attribute manually.
	 *
	 * @param $value
	 */
	public function setUpdatedAtAttribute($value)
	{
		// Do nothing.
	}

    /**
     * Returns the relationship for retrieving the owning model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
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

    /**
     * Scope retrieving all transient values which are not expired.
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('expire', '>', Carbon::now());
    }
} 