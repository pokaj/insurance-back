<?php

namespace App;

enum PolicyType: string
{
    case Health = 'health';
    case Life = 'life';
    case Auto = 'auto';
    case Property = 'property';
    case Travel = 'travel';
}
