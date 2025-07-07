<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportPaper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Report::query();

        // Use pagination instead of get()
        $reports = $query->orderBy('created_at', 'desc')->paginate(10);

        // to pass the services array to the view
        $services = $this->getDefaultServices();

        return view('reports.index', compact('reports'), compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'name' => 'required',
                'age' => 'required|numeric',
                'sex' => 'required|in:Male,Female',
                'complaint' => 'required|string|max:255',
                'diagnosis' => 'required',
                'remarks' => 'nullable|string|max:255',
                'category' => 'required|in:Students,Faculty,Administrative,Dependents,Visitors',
            ]);

            // Create a new report
            $isSuccess = Report::create([
                'title' => $request->title,
                'name' => $request->name,
                'age' => $request->age,
                'sex' => $request->sex,
                'complaint' => $request->complaint,
                'diagnosis' => $request->diagnosis,
                'remarks' => $request->remarks,
                'category' => $request->category,
                'date' => Carbon::today(),
            ]);

            if ($isSuccess) {
                return redirect()->route('reports.index')->with('success', 'Report added successfully');
            } else {
                return redirect()->route('reports.index')->with('error', 'Failed to add report');
            }
        } catch (\Throwable $th) {
            return redirect()->route('reports.index')->with('error', 'Failed to add report');
        }
    }

    // Show a single report
    public function show($id)
    {
        $report = Report::findOrFail($id);

        return view('reports.show', compact('report'));
    }
    // update report
    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:reports,id',
                'name' => 'required',
                'age' => 'required|numeric',
                'sex' => 'required|in:Male,Female',
                'complaint' => 'required|string|max:255',
                'diagnosis' => 'required',
                'remarks' => 'nullable|string|max:255',
                'category' => 'required|in:Students,Faculty,Administrative,Dependents,Visitors',
            ]);

            $report = Report::findOrFail($request->id);

            $isSuccess = $report->update($request->all());

            if ($isSuccess) {
                return redirect()->route('reports.index')->with('success', 'Report updated successfully');
            } else {
                return redirect()->route('reports.index')->with('error', 'Failed to update report');
            }
        } catch (\Throwable $th) {
            return redirect()->route('reports.index')->with('error', 'Failed to update report');
        }
    }

    // Delete a report
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:reports,id'
            ]);

            $report = Report::findOrFail($request->id);
            $isSuccess = $report->delete();

            if ($isSuccess) {
                return redirect()->route('reports.index')->with('success', 'Report deleted successfully');
            }
            else {
                return redirect()->route('reports.index')->with('error', 'Failed to delete report');
            }
        } catch (\Throwable $th) {
            return redirect()->route('reports.index')->with('error', 'Failed to delete report');
        }
    }

    public function showReportPaper()
    {

        $services = $this->getDefaultServices();

        return view('reports.reportPaper', compact('services'));
    }

    public function filterAndCountReports(Request $request)
    {
        $request->validate([
            'fromDurationDate' => 'required|date',
            'toDurationDate'   => 'required|date',
        ]);

        // Convert the incoming date strings to Carbon instances and ensure they cover the full day.
        $from = Carbon::parse($request->input('fromDurationDate'))->startOfDay();
        $to = Carbon::parse($request->input('toDurationDate'))->endOfDay();

        // Query the reports table for reports created between $from and $to,
        // grouping by 'diagnosis' and 'category', and counting how many reports are in each group.
        $results = Report::whereBetween('date', [$from, $to])
            ->select('diagnosis', 'category', DB::raw('COUNT(*) as report_count'))
            ->groupBy('diagnosis', 'category')
            ->get();

        $services = $this->getDefaultServices();

        $categoryMapping = [
            'students'       => 0,
            'faculty'        => 1,
            'administrative' => 2,
            'dependents'     => 3,
            'visitors'       => 4
        ];

        // Loop over the query results and update services array
        foreach ($results as $result) {
            foreach ($services as &$service) {
                if ($service['name'] === $result->diagnosis) {
                    $cat = strtolower($result->category);
                    if (isset($categoryMapping[$cat])) {
                        $index = $categoryMapping[$cat];
                        $service['data'][$index] = $result->report_count;
                    }
                }
            }
        }

        // Initialize totals array
        $totals = [
            'students' => 0,
            'faculty' => 0,
            'administrative' => 0,
            'dependents' => 0,
            'visitors' => 0,
            'overall' => 0
        ];

        // Loop over the query results and update services array
        foreach ($results as $result) {
            foreach ($services as &$service) {
                if ($service['name'] === $result->diagnosis) {
                    $cat = strtolower($result->category);
                    if (isset($categoryMapping[$cat])) {
                        $index = $categoryMapping[$cat];
                        $service['data'][$index] = $result->report_count;
                        
                        // Add to totals
                        $totals[$cat] += $result->report_count;
                        $totals['overall'] += $result->report_count;
                    }
                }
            }
        }

        return response()->json([
            'services' => $services,
            'totals' => $totals
        ]);
    }

    // to initialize the services array once
    private function getDefaultServices(): array
    {
        return [
            [
                'name' => 'I. CONSULTATION / TREATMENT',
                'data' => ['', '', '', '', '', 'I.']
            ],
            [
                'name' => 'A. RESPIRATORY DISORDER',
                'data' => ['', '', '', '', '', 'A.']
            ],
            [
                'name' => '1. URTI',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. T/C URTI',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. PTB IV',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. Pneumonia',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '5. T/C Allergic Pharyngitis',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '6. PTB III',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '7. Allergic Rhinitis',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '8. Exudative Tonsillopharyngitis',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '9. T/C Bacterial Lymphadenitis, submandibular area',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'B. GI DISORDER',
                'data' => ['', '', '', '', '', 'B.']
            ],
            [
                'name' => '1. Dyshidrosis',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. T/C Cero',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. NERD',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. AGE',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '5. T/C AGE',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '6. T/C Dyspepsia',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '7. R/O Abdominal Colic',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '8. T/C Abdominal Colic',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '9. T/C Food Intolerance',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'C. MUSCULOSKELETAL DISORDER',
                'data' => ['', '', '', '', '', 'C.']
            ],
            [
                'name' => '1. Thoracolumbar Scoliosis, Sever',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. Muscle Strain',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. T/C Muscle Strain',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. Muscle Spasm',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '5. T/C Muscle Spasm',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'D. BP MONITORING',
                'data' => ['', '', '', '', '', 'D.']
            ],
            [
                'name' => '1. BP Assessment',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. HTN 2',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. HCVD',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. HTN 1',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'E. CARDIOVASCULAR DISORDER',
                'data' => ['', '', '', '', '', 'E.']
            ],
            [
                'name' => 'F. CNS DISORDER',
                'data' => ['', '', '', '', '', 'F.']
            ],
            [
                'name' => '1. Tension Headache',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. T/C Common Migraine',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'G. Viral Viral Infections',
                'data' => ['', '', '', '', '', 'G.']
            ],
            [
                'name' => '1. T/C Acute Viral Illness',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. Acute Viral Illness',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. Varicella Zoster',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. Dengue Fever',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'H. DERMA DISORDERS',
                'data' => ['', '', '', '', '', 'H.']
            ],
            [
                'name' => '1. Abscess, Right axilla',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'I. SURGERY / TRAUMA',
                'data' => ['', '', '', '', '', 'I']
            ],
            [
                'name' => '1. S/P Tendon Sheat Incision',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. Infected Ingrown Toenail',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. Incised Wound',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. Dog Bite, CAT III',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '5. Infected Wound, left leg',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '6. Abrasion, Left knee',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'J. EENT DISORDERS',
                'data' => ['', '', '', '', '', 'J.']
            ],
            [
                'name' => '1. T/C Allergic Conjunctivitis',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. R/O Nasal Polyps',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. T/C Mineare\'s Disease',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. Acute Otitis Media',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'K. REPRODUCTIVE DISORDERS',
                'data' => ['', '', '', '', '', 'K.']
            ],
            [
                'name' => '1. Dysmenorrhea',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. Abnormal Uterine Bleeding',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. T/C Fibroadenoma',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'L. NUTRITIONAL DEFICIENCY',
                'data' => ['', '', '', '', '', 'L.']
            ],
            [
                'name' => 'M. ENDOCRINE DISORDERS',
                'data' => ['', '', '', '', '', 'M.']
            ],
            [
                'name' => '1. T2DM',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. Pre-Diabetes',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. T/C Pre-Diabetes',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. R/O Pre-Diabetes',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '5. Dyslipidemia',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '6. T/C Dyslipidemia',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'N. URINARY DISORDERS',
                'data' => ['', '', '', '', '', 'N.']
            ],
            [
                'name' => '1. UTI',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. Nephorolithiasis',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'II. MEDICAL CERTIFICATE',
                'data' => ['', '', '', '', '', 'II.']
            ],
            [
                'name' => '1. Medical Clearance (Returning Student)',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '2. Medical Clearance (For APE)',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '3. Medical Clearance (OJT)',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '4. Medical Certificate (Excuse Slip)',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => '5. Off-Campus',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'III. INJECTIONS',
                'data' => ['', '', '', '', '', 'III.']
            ],
            [
                'name' => '1. IM Injections',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'IV. REFERRALS',
                'data' => ['', '', '', '', '', 'IV.']
            ],
            [
                'name' => 'a. Ref to Hospital w/o Nurse',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'b. Ref. to Hospital w/ Nurse',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'V. OTHERS',
                'data' => ['', '', '', '', '', 'V.']
            ],
            [
                'name' => 'a. E/N at the time of examination',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'b. Dental Canes',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'c. T/C Acute Anxiety Reaction',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'd. T/C Heat Exhaustion',
                'data' => ['', '', '', '', '', '']
            ],
            [
                'name' => 'VI. ON-LINE CONSULTATION',
                'data' => ['', '', '', '', 'VI.']
            ],
            [
                'name' => 'a. Consultation',
                'data' => ['', '', '', '', '']
            ],
            [
                'name' => 'b. Medical certificate',
                'data' => ['', '', '', '', '']
            ],
            [
                'name' => 'c. Others',
                'data' => ['', '', '', '', '']
            ],
            [
                'name' => 'VII. TRIAGE SURVEY',
                'data' => ['', '', '', '', 'VII.']
            ],
        ];
    }

    public function exportExcel(Request $request)
    {
        // will get the count values of each category and services
        $tableDatas = $request->input('tableData') 
        ? json_decode($request->input('tableData'), true) 
        : $this->getDefaultServices();

        $bulletinUpdates = str_replace("\n", "\r\n", $request->input('bulletinUpdates'));

        // initialize totals
        $totals = [
            'students'       => 0,
            'faculty'        => 0,
            'administrative' => 0,
            'dependents'     => 0,
            'visitors'       => 0,
            'overall'        => 0,
        ];

        // sum up each column
        foreach ($tableDatas as $service) {
            foreach ($service['data'] as $idx => $count) {
                // map index to key
                switch ($idx) {
                    case 0: $key = 'students'; break;
                    case 1: $key = 'faculty'; break;
                    case 2: $key = 'administrative'; break;
                    case 3: $key = 'dependents'; break;
                    case 4: $key = 'visitors'; break;
                    default: continue 2;
                }
                $totals[$key] += (int) $count;
                $totals['overall'] += (int) $count;
            }
        }
        
        // Prepare data for the export view
        $data = [
            'title' => $request->title,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'physicianName' => $request->physicianName,
            'submissionDate' => $request->submissionDate,
            'position' => $request->position,
            'unitDepartment' => $request->unitDepartment,
            'tableDatas' => $tableDatas,
            'campusPhysician' => $request->campusPhysician,
            'campusNurse' => $request->campusNurse,
            'bulletinUpdates' => $bulletinUpdates,
            'totals' => $totals,
            'female'        => [
                'Student'   => $request->femaleStudent,
                'Faculty'   => $request->femaleFaculty,
                'Admin'     => $request->femaleAdmin,
                'Dependent' => $request->femaleDependent,
                'Visitor'   => $request->femaleVisitor,
                'Total'     => $request->femaleTotal,
            ],
            'male'          => [
                'Student'   => $request->maleStudent,
                'Faculty'   => $request->maleFaculty,
                'Admin'     => $request->maleAdmin,
                'Dependent' => $request->maleDependent,
                'Visitor'   => $request->maleVisitor,
                'Total'     => $request->maleTotal, 
            ],
            'pwd'           => [
                'Student'   => $request->pwdStudent,
                'Faculty'   => $request->pwdFaculty,
                'Admin'     => $request->pwdAdmin,
                'Dependent' => $request->pwdDependent,
                'Visitor'   => $request->pwdVisitor,
                'Total'     => $request->pwdTotal,
             ],
            'seniorCitizen' => [
                'Student'   => $request->seniorCitizenStudent,
                'Faculty'   => $request->seniorCitizenFaculty,
                'Admin'     => $request->seniorCitizenAdmin,
                'Dependent' => $request->seniorCitizenDependent,
                'Visitor'   => $request->seniorCitizenVisitor,
                'Total'     => $request->seniorCitizenTotal,
             ],
            'total'       => [
                'Student'   => $request->totalStudent,
                'Faculty'   => $request->totalFaculty,
                'Admin'     => $request->totalAdmin,
                'Dependent' => $request->totalDependent,
                'Visitor'   => $request->totalVisitor,
                'Overall'     => $request->totalOverall,
            ],
        ];

        return Excel::download(new ReportsExport($data), 'medical_report.xlsx');
    }
}