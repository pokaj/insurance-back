<?php

namespace App;

enum Role: string
{
    case Admin = 'admin';
    case Agent = 'agent';
}
