<?php

namespace Bmartel\Transient;


interface TransientRepositoryInterface {

    public function findBySignature($signature);

    public function deleteBySignature($signature);

    public function expire($signature);

    public function store(TransientPropertyInterface $transient, $property, $value, $expires);

    public function deleteByModel(TransientPropertyInterface $transient);

    public function deleteByProperty(array $transientProperties);

    public function deleteByModelProperty(TransientPropertyInterface $transient, array $transientProperties);

} 