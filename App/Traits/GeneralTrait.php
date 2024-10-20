<?php

declare(strict_types=1);

namespace App\Traits;

trait GeneralTrait
{
    function formatPriceDollarSign($value): string
    {
        return "$value $";
    }
}
