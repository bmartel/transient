<?php
namespace Bmartel\Transient;


class TransientRepository implements TransientRepositoryInterface
{

    /**
     * Find a Transient by its signature.
     *
     * @param $signature
     * @return null|\Bmartel\Transient\Transient
     */
    public function findBySignature($signature)
    {
        return Transient::where('signature', $signature)->first();
    }

    /**
     * Delete a transient by its signature.
     *
     * @param $signature
     * @return mixed
     */
    public function deleteBySignature($signature)
    {
        return Transient::where('signature', $signature)->delete();
    }

    /**
     * Expire the transient by its signature.
     *
     * @param $signature
     * @return bool|int
     */
    public function expire($signature)
    {
        $transient = Transient::where('signature', $signature)->first();

        return ($transient) ? $transient->expire() : false;
    }

    /**
     * Generate and store a new transient value.
     *
     * @param \Bmartel\Transient\TransientPropertyInterface $transient
     * @param $property
     * @param $value
     * @param $expires
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(TransientPropertyInterface $transient, $property, $value, $expires)
    {
        $signature = $transient->signature($property);

        return $transient->transientProperties()->create(compact('signature', 'property', 'value', 'expires'));
    }

} 