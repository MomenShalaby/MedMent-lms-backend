<?php

namespace App\Enums\Enums;

enum SubscriptionType: string
{
    case STUDENT = 'student';
    case RESIDENT = 'resident';
    case CONSULTANT = 'consultant';
    case NONEGYPTIAN = 'nonegyptian';
}
