<?php

namespace App\Services;

class PhoneService
{
    public function getCountryFromPhone(string $phone): string|null
    {
        $prefixes = config('phone_prefixes.prefixes');

        foreach ($prefixes as $prefix => $country) {
            if (str_starts_with($phone, $prefix)) {
                return $country;
            }
        }

        return null;
    }
}
