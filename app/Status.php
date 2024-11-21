<?php

namespace App;

enum Status: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Expired = 'expired';
}
