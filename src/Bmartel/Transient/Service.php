<?php
namespace Bmartel\Transient;

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

        $transient->delete();

        return $value;
    }

    /**
     * Expire
     * @param $signature
     * @return mixed
     */
    public function expire($signature)
    {
        return $this->transient->expire($signature);
    }

    /**
     * @param TransientPropertyInterface $transient
     * @param $property
     * @param $value
     * @param $expires
     * @return \Bmartel\Transient\Transient
     */
    public function generate(TransientPropertyInterface $transient, $property, $value, $expires)
    {
        $signature = $transient->signature($property);

        return $this->transient->store($transient, $signature, $property, $value, $expires);
    }

    /**
     * Determine if the provided signature is a valid signature.
     *
     * @param $signature
     * @return bool
     */
    public function validate($signature) {

        return (bool) $this->transient->findBySignature($signature);
    }
} 