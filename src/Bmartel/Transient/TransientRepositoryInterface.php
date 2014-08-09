<?php

namespace Bmartel\Transient;


interface TransientRepositoryInterface {

    public function findBySignature($signature);

    public function deleteBySignature($signature);

    public function expire($signature);

    public function store(TransientPropertyInterface $transient, $signature, $value, $expires);
} 