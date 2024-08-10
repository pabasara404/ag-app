<?php
namespace App\Http\Controllers;

use App\Services\ApplicationStatistics;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    protected $applicationStatistics;

    public function __construct(ApplicationStatistics $applicationStatistics)
    {
        $this->applicationStatistics = $applicationStatistics;
    }

    public function getApplicationCountsByGnDivision(Request $request)
    {
        $counts = $this->applicationStatistics->getApplicationCountsByGnDivision();
        return response()->json($counts);
    }

    public function getApplicationCountsByStatus(Request $request)
    {
        $counts = $this->applicationStatistics->getApplicationCountsByStatus();
        return response()->json($counts);
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

    public function getMonthlyTransportedAnimalCount()
    {
        $count = $this->applicationStatistics->getMonthlyTransportedAnimalCount();
        return response()->json(['count' => $count]);
    }

    public function getMonthlyTotalIncome()
    {
        $data = $this->applicationStatistics->getMonthlyTotalIncome();
        return response()->json($data);
    }
}
