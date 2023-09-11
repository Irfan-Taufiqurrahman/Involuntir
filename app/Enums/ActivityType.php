<?php

namespace App\Enums;

enum ActivityType: string
{
    case PAID = 'paid';
    case FREE = 'free';

    public function equals(...$others): bool
    {
        foreach ($others as $other) {
            if (
                get_class($this) === get_class($other)
                && $this->value === $other->value
            ) {
                return true;
            }
        }

        return false;
    }
}
