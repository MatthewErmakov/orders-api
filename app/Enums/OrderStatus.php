<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum OrderStatus: string
{
    use EnumToArray;

    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case SENT = 'sent';
    case DELIVERED = 'delivered';
}
