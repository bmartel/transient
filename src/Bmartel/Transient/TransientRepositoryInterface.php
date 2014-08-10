<?php

namespace Bmartel\Transient;


interface TransientRepositoryInterface {

    public function findBySignature($signature);

    public function deleteBySignature($signature);

    public function expire($signature);

    public function store(TransientPropertyInterface $transient, $property, $value, $expires);

    public function deleteByModel(TransientPropertyInterface $transient, $expiredOnly = true);

    public function deleteByProperty(array $transientProperties, $expiredOnly = true);

    public function deleteByModelProperty(TransientPropertyInterface $transient, array $transientProperties, $expiredOnly = true);

} 