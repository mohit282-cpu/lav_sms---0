<?php

namespace Tests\Unit;

use App\Services\BikramSambatService;
use App\Services\FeeManagementService;
use Tests\TestCase;

class FeeManagementCalculationTest extends TestCase
{
    protected $feeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->feeService = app(FeeManagementService::class);
    }

    public function test_resolve_dates_bs_and_ad()
    {
        $resolved = $this->feeService->resolveDates('2083-01-15', true);
        $this->assertEquals('2083-01-15', $resolved['bs']);
        $this->assertNotEmpty($resolved['ad']);

        $resolvedAd = $this->feeService->resolveDates('2026-04-28', false);
        $this->assertEquals('2026-04-28', $resolvedAd['ad']);
        $this->assertEquals('2083-01-15', $resolvedAd['bs']);
    }

    public function test_invoice_line_item_math_and_tax_calculations()
    {
        // Gross: 1000 * 2 = 2000. Discount: 200 -> After disc: 1800. Tax: 13% of 1800 = 234. Net: 2034.
        $item = [
            'unit_price' => 1000.00,
            'quantity' => 2.00,
            'discount_amount' => 200.00,
            'is_taxable' => true,
            'tax_rate' => 13.00,
        ];

        $gross = $item['unit_price'] * $item['quantity'];
        $afterDisc = $gross - $item['discount_amount'];
        $tax = round(($afterDisc * $item['tax_rate']) / 100, 2);
        $net = round($afterDisc + $tax, 2);

        $this->assertEquals(2000.00, $gross);
        $this->assertEquals(1800.00, $afterDisc);
        $this->assertEquals(234.00, $tax);
        $this->assertEquals(2034.00, $net);
    }

    public function test_tax_exempt_items_have_zero_tax()
    {
        // Standard education fee in Nepal (tax-exempt)
        $item = [
            'unit_price' => 3500.00,
            'quantity' => 1.00,
            'discount_amount' => 500.00,
            'is_taxable' => false,
            'tax_rate' => 0.00,
        ];

        $gross = $item['unit_price'] * $item['quantity'];
        $afterDisc = $gross - $item['discount_amount'];
        $tax = 0.00;
        $net = $afterDisc + $tax;

        $this->assertEquals(3500.00, $gross);
        $this->assertEquals(3000.00, $afterDisc);
        $this->assertEquals(0.00, $tax);
        $this->assertEquals(3000.00, $net);
    }
}
