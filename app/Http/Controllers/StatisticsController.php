<?php
namespace App\Http\Controllers;

use App\Services\ApplicationStatistics;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getApplicationCountsByGnDivision(Request $request)
    {
        $counts = ApplicationStatistics::getApplicationCountsByGnDivision();
        return response()->json($counts);
    }

    public function getApplicationCountsByStatus(Request $request)
    {
        $counts = ApplicationStatistics::getApplicationCountsByStatus();
        return response()->json($counts);
    }

    protected $applicationStatistics;

    public function __construct(ApplicationStatistics $applicationStatistics)
    {
        $this->applicationStatistics = $applicationStatistics;
    }

    public function getIssuedApplicationCounts()
    {
        $data = $this->applicationStatistics->getIssuedApplicationCountsByGnDivision();
        return response()->json($data);
    }

    public function getIssuedApplicationCountsByMonth()
    {
        $data = $this->applicationStatistics->getIssuedApplicationCountsByMonth();
        return response()->json($data);
    }

    public function getSubmittedApplicationCounts()
    {
        $data = $this->applicationStatistics->getSubmittedApplicationCounts();
        return response()->json($data);
    }
}
