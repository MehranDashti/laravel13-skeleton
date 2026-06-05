<?php

namespace App\Http\Filters;

use Agog\Osmose\Library\OsmoseFilter;
use Illuminate\Database\Eloquent\Builder;
use Agog\Osmose\Library\Services\Contracts\OsmoseFilterInterface;

/**
 * Class SampleFilter
 *
 * @package App\Http\Filters\CMS
 */
class SampleFilter extends OsmoseFilter implements OsmoseFilterInterface
{
    /**
     * Defines form elements and sieve values
     *
     * @return array
     */
    public function residue(): array
    {
        return [
            'code' => static function (Builder $query, $value) {
                return $query->where('code', '=', (int) $value);
            },
            'full_name' => static function (Builder $query, $value) {
                return $query->where('full_name', 'like', "%{$value}%");
            },
        ];
    }
}
