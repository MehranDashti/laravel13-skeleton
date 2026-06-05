<?php

namespace App\Http\Requests\Traits;

use Closure;

/**
 * trait CheckMobileTrait
 *
 * @package App\Http\Requests\Trait
 */
trait CheckMobileTrait
{
    public const IRANIAN_COUNTRY_CODE_PREFIX = '+98';
    public const AFGHANISTAN_COUNTRY_CODE_PREFIX = '+93';
    public const IRAQ_COUNTRY_CODE_PREFIX = '+964';
    public const TURKEY_COUNTRY_CODE_PREFIX = '+90';

    public const ALL_COUNTRY_CODE_PREFIX = [
        self::IRANIAN_COUNTRY_CODE_PREFIX,
        self::AFGHANISTAN_COUNTRY_CODE_PREFIX,
        self::IRAQ_COUNTRY_CODE_PREFIX,
        self::TURKEY_COUNTRY_CODE_PREFIX,
    ];

    /**
     * @param Closure $fail
     *
     * @return void
     */
    public function checkValidMobileWithPrefix(Closure $fail)
    {
        $mobile = (int) $this->input('mobile');
        $mobileLength = strlen('0' . $mobile);
        if ($this->input('country_code_prefix') === self::IRANIAN_COUNTRY_CODE_PREFIX && $mobileLength !== 11) {
            $fail(trans('messages.mobile_number_is_not_valid'));
        }
    }
}
