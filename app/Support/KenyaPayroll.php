<?php

namespace App\Support;

/**
 * Kenyan statutory payroll deductions.
 *
 * Rates as of the Finance Act 2023 / SHIF Act 2023 / NSSF Act 2013 (year 3 limits, Feb 2025):
 *  - NSSF: 6% of pensionable pay, Tier I up to KES 8,000 and Tier II up to KES 72,000.
 *  - SHIF: 2.75% of gross, minimum KES 300.
 *  - Affordable Housing Levy: 1.5% of gross.
 *  - PAYE: monthly bands below, less personal relief of KES 2,400. NSSF, SHIF and the
 *    housing levy are deductible before PAYE is computed.
 * Review these constants whenever KRA/NSSF/SHA publish new rates.
 */
class KenyaPayroll
{
    public const NSSF_RATE = 0.06;
    public const NSSF_UPPER_LIMIT = 72000;
    public const SHIF_RATE = 0.0275;
    public const SHIF_MINIMUM = 300;
    public const HOUSING_LEVY_RATE = 0.015;
    public const PERSONAL_RELIEF = 2400;

    /** [upper bound of band, rate]; null upper bound = no limit. */
    public const PAYE_BANDS = [
        [24000, 0.10],
        [32333, 0.25],
        [500000, 0.30],
        [800000, 0.325],
        [null, 0.35],
    ];

    public static function calculate(float $gross): array
    {
        if ($gross <= 0) {
            return ['nssf' => 0, 'shif' => 0, 'housing_levy' => 0, 'paye' => 0, 'total' => 0];
        }

        $nssf = round(min($gross, self::NSSF_UPPER_LIMIT) * self::NSSF_RATE, 2);
        $shif = round(max($gross * self::SHIF_RATE, self::SHIF_MINIMUM), 2);
        $housingLevy = round($gross * self::HOUSING_LEVY_RATE, 2);

        $taxable = max(0, $gross - $nssf - $shif - $housingLevy);
        $paye = max(0, round(self::incomeTax($taxable) - self::PERSONAL_RELIEF, 2));

        return [
            'nssf' => $nssf,
            'shif' => $shif,
            'housing_levy' => $housingLevy,
            'paye' => $paye,
            'total' => round($nssf + $shif + $housingLevy + $paye, 2),
        ];
    }

    private static function incomeTax(float $taxable): float
    {
        $tax = 0;
        $lower = 0;
        foreach (self::PAYE_BANDS as [$upper, $rate]) {
            if ($taxable <= $lower) {
                break;
            }
            $portion = ($upper === null ? $taxable : min($taxable, $upper)) - $lower;
            $tax += $portion * $rate;
            $lower = $upper ?? $taxable;
        }

        return $tax;
    }
}
