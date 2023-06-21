<?php

namespace App\Constants;

use App\Constants\Enum;

/**
 * @method static PreferenceType SOURCES()
 * @method static PreferenceType CATEGORIES()
 * @method static PreferenceType AUTHORS()
 */
class PreferenceType extends Enum
{
    private const SOURCES = 'source';
    private const CATEGORIES = 'categories';
    private const AUTHORS = 'authors';
}