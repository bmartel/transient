<?php
namespace Bmartel\Transient;


use Illuminate\Database\Eloquent\Model;

class Service
{
    /**
     * @var TransientRepositoryInterface
     */
    private $transient;

    public function __construct(TransientRepositoryInterface $transient)
    {
        $this->transient = $transient;
    }

    /**
     * Consume the signature to retrieve the transient value one time.
     *
     * @param $signature
     * @return null|string
     */
    public function consume($signature)
    {
        $transient = $this->transient->findBySignature($signature);

        if (!$transient)
            return null;

        $value = $transient->value;

        $this->transient->deleteBySignature($signature);

        return $value;
    }

    public function expire($signature)
    {
        return $this->transient->expire($signature);
    }

    /**
     * @param TransientPropertyInterface $transient
     * @param $property
     * @param $value
     * @param $expires
     * @return mixed
     */
    public function generate(TransientPropertyInterface $transient, $property, $value, $expires)
    {
        return $this->transient->store($transient, $property, $value, $expires);
    }
} 