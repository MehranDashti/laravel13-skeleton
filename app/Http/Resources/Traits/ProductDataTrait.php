<?php

namespace App\Http\Resources\Traits;

use App\Models\User\User;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\ProductContent;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Http\Resources\Client\Warehouse\WarehouseInventoryResource;
use App\Repositories\Contracts\Warehouse\WarehouseInventoryRepositoryInterface;

/**
 * trait ProductDataTrait
 *
 * @package App\Http\Resources\Traits
 */
trait ProductDataTrait
{
    /**
     * @param ProductContent $productContent
     *
     * @return array
     */
    protected function calcProductPricing(ProductContent $productContent): array
    {
        return [
            'price' => $productContent->price,
            'currency_unit' => $productContent->currency_unit,
            'production_price' => $productContent->production_price,
            'payable_price' => $productContent->price,
        ];
    }

    /**
     * @param Product $product
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    protected function getProductInventories(Product $product): array
    {
        $authenticatedUser = Auth::guard('api')->user();
        $inventories = app()->make(WarehouseInventoryRepositoryInterface::class)
            ->getByProductAndWarehouseTypeAndStatus(
                $product->id,
                Warehouse::BRANCH_TYPE,
                Warehouse::ACTIVE_STATUS
            );
        $totalInventory = $inventories->sum('physical_count');
        $totalInventory = max($totalInventory, 0);
        if ($authenticatedUser instanceof User && $authenticatedUser->user_type === User::AGENT_TYPE) {
            $calcInventory = $totalInventory;
        } else {
            $calcInventory = min($totalInventory, 10);
        }

        return [
            'limit_buy_inventory' => $calcInventory,
            'total_inventory' => $calcInventory,
            'inventories' => WarehouseInventoryResource::collection($inventories),
            'is_available' => $calcInventory > 0,
        ];
    }
}
