<?php

namespace App\Utility;

use DateTime;

trait PropertyView
{

    public function isJsonArray(?string $jsonString): bool {
        if ($jsonString === null) {
            return false;
        }

        $decoded = json_decode($jsonString, true);

        return json_last_error() === JSON_ERROR_NONE && is_array($decoded);
    }

}