<?php

namespace App\Services;

use App\Models\GnDivision;
use Illuminate\Support\Facades\DB;

class ApplicationStatistics
{
    protected static $tables = [
        'timber_cutting_permit_applications',
        'timber_transporting_applications',
        'individual_businesses',
        'firms',
        'income_certificates',
        'president_funds',
        'mahapolas',
        'excises',
        'valuations',
    ];

    public static function getApplicationCountsByGnDivision()
    {
        $countsByDivision = [];

        foreach (self::$tables as $table) {
            $results = DB::table($table)
                ->select('gn_division_id', DB::raw('count(*) as count'))
                ->groupBy('gn_division_id')
                ->get();

            foreach ($results as $result) {
                $gnDivisionId = $result->gn_division_id;
                $count = $result->count;

                if (!isset($countsByDivision[$gnDivisionId])) {
                    $countsByDivision[$gnDivisionId] = 0;
                }

                $countsByDivision[$gnDivisionId] += $count;
            }
        }

        // Fetch GN Division names
        $gnDivisions = DB::table('gn_divisions') // Assuming 'gn_divisions' is the table name
        ->whereIn('id', array_keys($countsByDivision))
            ->pluck('name', 'id')
            ->toArray();

        // Map counts to GN Division names
        $countsWithNames = [];
        foreach ($countsByDivision as $id => $count) {
            $countsWithNames[$gnDivisions[$id] ?? 'Unknown'] = $count;
        }

        return $countsWithNames;
    }

    public static function getApplicationCountsByStatus()
    {
        $statusCounts = [
            'Submitted' => 0,
            'Escalated' => 0,
            // Add other statuses if needed
        ];

        foreach (self::$tables as $table) {
            $results = DB::table($table)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            foreach ($results as $result) {
                $status = $result->status;
                $count = $result->count;

                if (array_key_exists($status, $statusCounts)) {
                    $statusCounts[$status] += $count;
                } else {
                    $statusCounts[$status] = $count;
                }
            }
        }

        return $statusCounts;
    }

    public function getIssuedApplicationCountsByGnDivision()
    {
        $results = [];

        foreach (self::$tables as $table) {
            $counts = DB::table($table)
                ->select('gn_division_id', DB::raw('count(*) as count'))
                ->where('status', 'issued')
                ->groupBy('gn_division_id')
                ->pluck('count', 'gn_division_id')
                ->toArray();

            foreach ($counts as $gnDivisionId => $count) {
                if (!isset($results[$gnDivisionId])) {
                    $results[$gnDivisionId] = 0;
                }
                $results[$gnDivisionId] += $count;
            }
        }

        return $this->transformDataForGraph($results);
    }

    protected function transformDataForGraph($data)
    {
        $graphData = [];

        foreach ($data as $gnDivisionId => $count) {
            $gnDivisionName = GnDivision::find($gnDivisionId)->name; // Fetch the GN division name
            $graphData[] = [
                'gn_division' => $gnDivisionName,
                'count' => $count
            ];
        }

        return $graphData;
    }

    public function getIssuedApplicationCountsByMonth()
    {
        $results = [];
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        foreach (self::$tables as $table) {
            $count = DB::table($table)
                ->where('status', 'issued')
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count();
            $results[$table] = $count;
        }

        return $results;
    }

    public static function getSubmittedApplicationCounts()
    {
        $countsByType = [];

        foreach (self::$tables as $table) {
            $count = DB::table($table)
                ->where('status', 'submitted')
                ->count();
            $countsByType[$table] = $count;
        }

        return $countsByType;
    }
}
