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

    /**
     * Delete all properties attached to a given model.
     *
     * @param TransientPropertyInterface $transient
     * @return mixed
     */
    public function deleteByModel(TransientPropertyInterface $transient)
    {
        return $transient->transientProperties()->delete();
    }

    /**
     * Delete all properties by given array of property names.
     *
     * @param array $transientProperties
     * @return int
     */
    public function deleteByProperty(array $transientProperties)
    {
        if ($transientProperties) {
            $transient = Transient::query();

            foreach ($transientProperties as $property)
                $transient->orWhere('property', $property);

            return $transient->delete();
        }

        // If no arguments are provided, dont delete anything.
        return 0;
    }

    /**
     * Delete all properties listed in the array and attached to the defined model.
     *
     * @param TransientPropertyInterface $transient
     * @param array $transientProperties
     * @return int
     */
    public function deleteByModelProperty(TransientPropertyInterface $transient, array $transientProperties)
    {
        if ($transientProperties) {

            return $transient->transientProperties()->where(function($q) use($transientProperties){
                foreach ($transientProperties as $property)
                    $q->orWhere('property', $property);
            })->delete();
        }

        // If no arguments are provided, dont delete anything.
        return 0;
    }

} 