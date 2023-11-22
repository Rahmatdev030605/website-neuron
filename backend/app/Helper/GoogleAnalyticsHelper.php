<?php
namespace App\Helper;

use App\Http\Controllers\Controller;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient as BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange as DateRange;
use Google\Analytics\Data\V1beta\Dimension as Dimension;
use Google\Analytics\Data\V1beta\Metric as Metric;
use Google\Analytics\Data\V1beta\RunReportRequest as RunReportRequest;
use Google\Analytics\Data\V1beta\OrderBy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use stdClass;

class GAnalytics extends Controller{
    //function Google Analytics
    private static $analyticsClient;

    public function __construct(){
         // Credentials Authorization
        self::$analyticsClient = new BetaAnalyticsDataClient([
            'credentials' => base_path('/app/Analytics/'.env('ANALYTICS_CREDENTIALS'))
        ]);
    }

    public static function getVisitor(){
        // Configurasi Permintaan yang ingin diminta
        $analyticsConfig = (new RunReportRequest())
            ->setProperty('properties/' . env('ANALYTICS_PROPERTY_ID'))
            // Jarak Waktu Yang diambil
            ->setDateRanges([
                new DateRange([
                    'start_date' => '2023-01-01',
                    'end_date' => 'today',
                ]),
            ])
            // Detail Tambahan
            ->setDimensions([new Dimension([
                    'name' => 'country',
                ]),
            ])
            // Mengambil Data
            ->setMetrics([new Metric([
                    'name' => 'activeUsers',
                ])
            ]);

        // Mengirimkan request ke Google Analytic Properties
        $analyticsData = self::$analyticsClient->runReport($analyticsConfig);
        if (!empty($analyticsData->getRows())) {
            $activeUsers = 0;
            for($i = 0; $i < $analyticsData->getRowCount(); $i++) {
                // Akses baris pertama (karena Anda hanya memiliki satu baris)
                $firstRow = $analyticsData->getRows()[$i];

                // Akses metrik dalam baris pertama
                $metrics = $firstRow->getMetricValues();

                // Mengambil banyak visitor
                $activeUsers = $activeUsers + $metrics[0]->getValue();
            }
        } else {
            $activeUsers = null;
        }
        return $activeUsers;
    }

    public static function getGraphAnalytics(Request $request){
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if($startDate==null){
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if($endDate==null){
            $endDate = 'today';
        }

        // return [$startDate, $endDate];
        // Configurasi Permintaan yang ingin diminta
        $analyticsConfig = (new RunReportRequest())
            ->setProperty('properties/' . env('ANALYTICS_PROPERTY_ID'))
            // Jarak Waktu Yang diambil
            ->setDateRanges([
                new DateRange([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]),
            ])
            // Detail Tambahan
            ->setDimensions([new Dimension([
                    'name' => 'date',
                ]),
            ])
            ->setOrderBys([new OrderBy([
                'dimension' => new OrderBy\DimensionOrderBy([
                    'dimension_name' => 'date', // your dimension here
                    'order_type' => OrderBy\DimensionOrderBy\OrderType::ALPHANUMERIC
                ]),'desc' => false,
            ]),
            ])
            // Mengambil Data
            ->setMetrics([new Metric([
                    'name' => 'activeUsers',
                ])
            ]);

        // Mengirimkan request ke Google Analytic Properties
        $analyticsData = self::$analyticsClient->runReport($analyticsConfig);
        // return $analyticsData;
        $analyticData = [];
        $dimensionData =[];
        $metricData =[];
        if (!empty($analyticsData->getRows())) {
            $dimensionBefore=null;
            for($i = 0; $i < $analyticsData->getRowCount(); $i++) {
                // Akses baris pertama (karena Anda hanya memiliki satu baris)
                $firstRow = $analyticsData->getRows()[$i];

                // Akses metrik dalam baris pertama
                $dimensionValue = $firstRow->getDimensionValues()[0]->getValue();

                if ($dimensionBefore !== null) {
                    $dateBefore = Carbon::createFromFormat('Ymd', $dimensionBefore);
                    $dateCurrent = Carbon::createFromFormat('Ymd', $dimensionValue);

                    // Periksa perbedaan tanggal dan tambahkan tanggal yang terlewat jika perlu
                    while ($dateBefore->addDay()->lt($dateCurrent)) {
                        $dateNew = $dateBefore->copy(); // Salin objek agar tidak merubah $dateBefore
                        array_push($dimensionData, $dateNew->format('D j M'));
                        array_push($metricData, "0");
                    }
                }

                $date = \Carbon\Carbon::createFromFormat('Ymd', $dimensionValue)->format('D j M');
                array_push($dimensionData, $date);
                $metricsValue = $firstRow->getMetricValues()[0]->getValue();
                array_push($metricData, $metricsValue);
                $dimensionBefore = $dimensionValue;
            }
        } else {
            $analyticData = "error";
        }

        array_push($analyticData, $dimensionData, $metricData);
        return $analyticData;
    }




    public static function getMapAnalytics(Request $request){
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if($startDate==null){
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if($endDate==null){
            $endDate = 'today';
        }

        // return [$startDate, $endDate];
        // Configurasi Permintaan yang ingin diminta
        $analyticsConfig = (new RunReportRequest())
            ->setProperty('properties/' . env('ANALYTICS_PROPERTY_ID'))
            // Jarak Waktu Yang diambil
            ->setDateRanges([
                new DateRange([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]),
            ])
            // Detail Tambahan
            ->setDimensions([new Dimension([
                    'name' => 'region',
                ]),
            ])
            // Mengambil Data
            ->setMetrics([new Metric([
                    'name' => 'activeUsers',
                ])
            ]);

        // Mengirimkan request ke Google Analytic Properties
        $analyticsData = self::$analyticsClient->runReport($analyticsConfig);
        // return $analyticsData;
        $analyticData = [];
        $dimensionData =[];
        $metricData =[];
        if (!empty($analyticsData->getRows())) {
            for($i = 0; $i < $analyticsData->getRowCount(); $i++) {
                // Akses baris pertama (karena Anda hanya memiliki satu baris)
                $firstRow = $analyticsData->getRows()[$i];

                // Akses metrik dalam baris pertama
                $dimensionValue = $firstRow->getDimensionValues()[0]->getValue();
                array_push($dimensionData, $dimensionValue);
                $metricsValue = $firstRow->getMetricValues()[0]->getValue();
                array_push($metricData, $metricsValue);
            }
        } else {
            $analyticData = "error";
        }

        array_push($analyticData, $dimensionData, $metricData);
        return $analyticData;
    }
}
?>
