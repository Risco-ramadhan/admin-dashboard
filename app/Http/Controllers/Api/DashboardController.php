<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Itam\Asset;
use App\Models\Itam\Contract;
use App\Models\Itam\ContractVendor;
use App\Models\Itam\License;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function countCardDashboard()
    {
        $customers = [
            'customer_count' => Contract::count(),
            'customer_created' => optional(Contract::orderBy('created_at', 'desc')->first())->created_at
        ];

        $assets = [
            'asset_count' => Asset::count(),
            'asset_created' => optional(Asset::orderBy('created_at', 'desc')->first())->created_at
        ];

        $licenses = [
            'license_count' => License::count(),
            'license_created' => optional(License::orderBy('created_at', 'desc')->first())->created_at
        ];

        $contractVendor = [
            'contract_vendor_count' => ContractVendor::count(),
            'contract_vendor_created' => optional(ContractVendor::orderBy('created_at', 'desc')->first())->created_at
        ];

        $data = [
            'customer_count' => $customers['customer_count'],
            'customer_created' => $customers['customer_created'] ? $customers['customer_created']->diffForHumans() : null,
            'asset_count' => $assets['asset_count'],
            'asset_created' => $assets['asset_created'] ? $assets['asset_created']->diffForHumans() : null,
            'license_count' => $licenses['license_count'],
            'license_created' => $licenses['license_created'] ? $licenses['license_created']->diffForHumans() : null,
            'contract_vendor_count' => $contractVendor['contract_vendor_count'],
            'contract_vendor_created' => $contractVendor['contract_vendor_created'] ? $contractVendor['contract_vendor_created']->diffForHumans() : null
        ];

        return response()->json([
            'success' => true,
            'render' => $data
        ]);
    }
}
