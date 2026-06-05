<?php

namespace App\Http\Resources\Traits;

use App\Models\User\User;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\UserFavoriteProduct;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Repositories\Contracts\Product\UserFavoriteProductRepositoryInterface;

/**
 * trait UserFavoriteProductTrait
 *
 * @package App\Http\Resources\Traits
 */
trait UserFavoriteProductTrait
{
    /**
     * @param Product $product
     * @param User|null $user
     *
     * @return bool
     *
     * @throws BindingResolutionException
     */
    private function isAuthenticatedUserFavoriteIt(Product $product, ?User $user = null): bool
    {
        if (! $user instanceof User) {
            $user = Auth::guard('api')->user();
        }
        if ($user instanceof User) {
            $userFavoriteProduct = app()->make(UserFavoriteProductRepositoryInterface::class)
                ->findByMetaData([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ], 'first');

            return $userFavoriteProduct instanceof UserFavoriteProduct;
        }

        return false;
    }
}
