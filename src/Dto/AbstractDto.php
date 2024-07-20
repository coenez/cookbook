<?php

namespace App\Dto;

abstract class AbstractDto {
    public function __construct(mixed $data) {
        foreach($data as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }
}
