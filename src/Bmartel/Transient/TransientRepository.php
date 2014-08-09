<?php
namespace Bmartel\Transient;


class TransientRepository implements TransientRepositoryInterface {

    /**
     * Find a Transient by its signature.
     *
     * @param $signature
     * @return null|\Bmartel\Transient\Transient
     */
    public function findBySignature($signature)
    {
        return Transient::where('signature',$signature)->first();
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
        return Transient::expire();
    }

    /**
     * Generate and store a new transient value.
     *
     * @param \Bmartel\Transient\TransientPropertyInterface $transient
     * @param $signature
     * @param $value
     * @param $expires
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(TransientPropertyInterface $transient, $signature, $value, $expires)
    {
        return $transient->transientProperties()->create(compact('signature','value','expires'));
    }

} 