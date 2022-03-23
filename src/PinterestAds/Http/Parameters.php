<?php

namespace PinterestAds\Http;

use ArrayObject;

class Parameters extends ArrayObject
{
    public function enhance(array $data) {
        foreach ($data as $key => $value) {
            $this[$key] = $value;
        }
    }

    protected function exportNonScalar($value): string {
        try {
            return json_encode($value, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
        }
    }

    public function export(): array {
        $data = array();
        foreach ($this as $key => $value) {
            $data[$key] = is_null($value) || is_scalar($value)
                ? $value
                : $this->exportNonScalar($value);
        }
        return $data;
    }
}