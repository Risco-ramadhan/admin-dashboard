<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Itam\Asset;
use App\Models\Itam\Contract;
use App\Models\Itam\ContractVendor;
use App\Models\Itam\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function countCardDashboard()
    {
        $customers = [
            'customer_count' => Contract::whereNull('deleted_at')
                ->count(),
            'customer_created' => optional(Contract::orderBy('created_at', 'desc')->first())->created_at
        ];

        $assets = [
            'asset_count' => Asset::whereNull('deleted_at')
                // ->groupBy('_snipeit_functionality_37')
                ->count(),
            'asset_created' => optional(Asset::orderBy('created_at', 'desc')->first())->created_at
        ];

        $licenses = [
            'license_count' => License::whereNull('deleted_at')
                ->count(),
            'license_created' => optional(License::orderBy('created_at', 'desc')->first())->created_at
        ];

        $contractVendor = [
            'contract_vendor_count' => ContractVendor::whereNull('deleted_at')
                ->count(),
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
            'contract_vendor_created' => $contractVendor['contract_vendor_created'] ? $contractVendor['contract_vendor_created']->diffForHumans() : null,
        ];

        return response()->json([
            'success' => true,
            'render' => $data
        ]);
    }

    public function getLicense()
    {
        $licensesTable = License::query()
            ->with(['company', 'category', 'manufacturer', 'seats'])
            ->select([
                'licenses.id',
                'licenses.name',
                'licenses.seats',
                'licenses.expiration_date',
                DB::raw('DATEDIFF(licenses.expiration_date, NOW()) AS sisa_hari'),
                'companies.name as Companies__name',
                'categories.name as Categories__name',
                'manufacturers.name as Manufacturers__name',
                DB::raw("
            licenses.seats - (
                SELECT COUNT(*)
                FROM license_seats
                WHERE license_seats.license_id = licenses.id
                    AND (
                        (license_seats.assigned_to IS NOT NULL AND license_seats.asset_id IS NULL)
                        OR (license_seats.assigned_to IS NULL AND license_seats.asset_id IS NOT NULL)
                        OR (license_seats.assigned_to IS NOT NULL AND license_seats.asset_id IS NOT NULL)
                    )
            ) AS sisa_license
        ")
            ])
            ->leftJoin('companies', 'licenses.company_id', '=', 'companies.id')
            ->leftJoin('categories', 'licenses.category_id', '=', 'categories.id')
            ->leftJoin('manufacturers', 'licenses.manufacturer_id', '=', 'manufacturers.id')
            ->whereNull('licenses.deleted_at')
            ->whereNotNull('licenses.expiration_date')
            ->where('licenses.maintained', true)
            ->orderBy('licenses.expiration_date', 'asc')
            ->get()
            ->filter(function ($license) {
                // Filter di level PHP, menggantikan klausa HAVING
                return $license->sisa_hari < 60;
            });

        $formattedData = $licensesTable->map(function ($license) {
            return [
                'company_name' => $license->Companies__name,
                'license_name' => $license->name,
                'seats' => $license->seats,
                'category_name' => $license->Categories__name,
                'manufactur_name' => $license->Manufacturers__name,
                'expiration_date' => date('d M Y', strtotime($license->expiration_date)),
                'remaining_seats' => $license->sisa_license,
                'days_remaining' => $license->sisa_hari,
            ];
        });

        $data = [
            'license_table' => $formattedData
        ];

        return response()->json([
            'success' => true,
            'render' => $data
        ]);
    }

    public function getChart()
    {
        $fetchSummary = json_decode($this->countCardDashboard()->getContent(), true);

        $chart = [
            [
                'name' => 'CUSTOMER',
                'y' => $fetchSummary['render']['customer_count']
            ],
            [
                'name' => 'ASSET',
                'y' => $fetchSummary['render']['asset_count']
            ],
            [
                'name' => 'LICENSE',
                'y' => $fetchSummary['render']['license_count']
            ],
            [
                'name' => 'CONTRACT VENDOR',
                'y' => $fetchSummary['render']['contract_vendor_count']
            ]
        ];

        $data = [
            'charts' => [
                'chart' => ($chart),
                'colors' => [
                    '#FF4757',  // Bright red (merah cerah)
                    '#00BFFF',   // Deep sky blue (terang biru)
                    '#FFBF00',  // Vivid amber (terang kuning keemasan)
                    '#32CD32',  // Lime green (terang hijau)
                ]
            ]
        ];

        return response()->json([
            'success' => true,
            'render' => $data
        ]);
    }

    public function detailSummaryCards($type)
    {
        switch ($type) {
            case 'customer':
                $data = Contract::whereNull('deleted_at')
                    ->get();
                break;
            case 'asset':
                $data = Asset::whereNull('deleted_at')
                    ->get();
                break;
            case 'license':
                $data = License::whereNull('deleted_at')
                    ->get();
                break;
            case 'contract':
                $data = ContractVendor::whereNull('deleted_at')
                    ->get();
                break;
            default:
                $data = [];
        }

        return response()->json([
            'success' => true,
            'type' => $type,
            'render' => $data,
        ]);
    }
}
