<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Supply;
use App\Models\Equipment;
use App\Models\Document;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check for expiring medicines first
        $this->checkExpiringMedicines();

        // Handle search functionality
        $searchTerm = $request->input('search');
        $searchResults = null;

        if ($searchTerm) {
            // Initialize collections for different types of results
            // Patient search
            $patients = Patient::where(function ($q) use ($searchTerm) {
                $q->where('firstName', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('lastName', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('middleName', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('student_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('contactDetails', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('patientType', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('year_course_dept', 'LIKE', "%{$searchTerm}%")
                    ->orWhereRaw("CONCAT(firstName, ' ', lastName) LIKE ?", ["%{$searchTerm}%"])
                    ->orWhereRaw("CONCAT(lastName, ', ', firstName) LIKE ?", ["%{$searchTerm}%"]);
            })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($patient) {
                    // Add a formatted full name for display
                    $patient->fullName = $patient->lastName . ', ' . $patient->firstName .
                        ($patient->middleName ? ' ' . $patient->middleName : '');
                    return $patient;
                });

            // Medicine search
            $medicines = Medicine::where(function ($q) use ($searchTerm) {
                $q->where('medicine_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('unit', 'LIKE', "%{$searchTerm}%");
            })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($medicine) {
                    // Format remaining quantity for display
                    $medicine->formattedQuantity = number_format($medicine->remaining_quantity, 2) . ' ' . $medicine->unit;
                    // Format expiration date
                    $medicine->formattedExpiry = Carbon::parse($medicine->expiration_date)->format('M d, Y');
                    return $medicine;
                });

            // Supply search
            $supplies = Supply::where(function ($q) use ($searchTerm) {
                $q->where('supply_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('unit', 'LIKE', "%{$searchTerm}%");
            })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($supply) {
                    // Format remaining quantity for display
                    $supply->formattedQuantity = number_format($supply->remaining_quantity, 2) . ' ' . $supply->unit;
                    // Format expiration date
                    $supply->formattedExpiry = Carbon::parse($supply->expiration_date)->format('M d, Y');
                    return $supply;
                });

            // Report search
            $reports = Report::where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('complaint', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('diagnosis', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('category', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('remarks', 'LIKE', "%{$searchTerm}%");
            })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($report) {
                    // Format report date
                    $report->formattedDate = Carbon::parse($report->date)->format('M d, Y');
                    // Format report created date
                    $report->formattedCreatedDate = Carbon::parse($report->created_at)->format('M d, Y');
                    // Format complaint preview
                    $report->complaintPreview = \Str::limit(strip_tags($report->complaint), 80);
                    // Format diagnosis preview
                    $report->diagnosisPreview = \Str::limit(strip_tags($report->diagnosis), 80);
                    // Build patient info string
                    $report->patientInfo = $report->name . ' (' . $report->age . ', ' . $report->sex . ')';
                    return $report;
                });

            // Document search
            $documents = Document::select('documents.*')
                ->where(function ($query) use ($searchTerm) {
                    // First search in the main documents table
                    $query->where('documents.document_type', 'LIKE', "%{$searchTerm}%");
                })
                // Join with excuseletter table
                ->leftJoin('excuseletter', function ($join) use ($searchTerm) {
                    $join->on('documents.id', '=', 'excuseletter.document_id')
                        ->where(function ($q) use ($searchTerm) {
                            $q->where('excuseletter.patient_name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('excuseletter.recipient', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('excuseletter.cause', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('excuseletter.department', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('excuseletter.doctorName', 'LIKE', "%{$searchTerm}%");
                        });
                })
                // Join with annual_medical_clearances table
                ->leftJoin('annual_medical_clearances', function ($join) use ($searchTerm) {
                    $join->on('documents.id', '=', 'annual_medical_clearances.document_id')
                        ->where(function ($q) use ($searchTerm) {
                            $q->where('annual_medical_clearances.patient_name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('annual_medical_clearances.doctorName', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('annual_medical_clearances.license_number', 'LIKE', "%{$searchTerm}%");
                        });
                })
                // Join with waiver table
                ->leftJoin('waiver', function ($join) use ($searchTerm) {
                    $join->on('documents.id', '=', 'waiver.document_id')
                        ->where(function ($q) use ($searchTerm) {
                            $q->where('waiver.name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('waiver.collegeName', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('waiver.department', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('waiver.diagnosedIllness', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('waiver.doctorName', 'LIKE', "%{$searchTerm}%");
                        });
                })
                // Join with medical_certificates table
                ->leftJoin('medical_certificates', function ($join) use ($searchTerm) {
                    $join->on('documents.id', '=', 'medical_certificates.document_id')
                        ->where(function ($q) use ($searchTerm) {
                            $q->where('medical_certificates.patient_name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('medical_certificates.sickness', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('medical_certificates.reason', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('medical_certificates.doctorName', 'LIKE', "%{$searchTerm}%");
                        });
                })
                // Join with medical_clearances table
                ->leftJoin('medical_clearances', function ($join) use ($searchTerm) {
                    $join->on('documents.id', '=', 'medical_clearances.document_id')
                        ->where(function ($q) use ($searchTerm) {
                            $q->where('medical_clearances.patient_name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('medical_clearances.vaccination_status', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('medical_clearances.excuse', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('medical_clearances.position', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('medical_clearances.doctorName', 'LIKE', "%{$searchTerm}%");
                        });
                })
                // Join with dmdc_consent_forms table
                ->leftJoin('dmdc_consent_forms', function ($join) use ($searchTerm) {
                    $join->on('documents.id', '=', 'dmdc_consent_forms.document_id')
                        ->where(function ($q) use ($searchTerm) {
                            $q->where('dmdc_consent_forms.event_name', 'LIKE', "%{$searchTerm}%");
                        });
                })
                // Join with waiver_for_pulmonary_cases table
                ->leftJoin('waiver_for_pulmonary_cases', function ($join) use ($searchTerm) {
                    $join->on('documents.id', '=', 'waiver_for_pulmonary_cases.document_id')
                        ->where(function ($q) use ($searchTerm) {
                            $q->where('waiver_for_pulmonary_cases.patient_name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('waiver_for_pulmonary_cases.collegeName', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('waiver_for_pulmonary_cases.year', 'LIKE', "%{$searchTerm}%");
                        });
                })
                ->distinct() // Avoid duplicate documents
                ->orderBy('documents.created_at', 'desc')
                ->take(5)
                ->get();

            // Now enhance the results with additional info from specific document types
            $formattedDocuments = $documents->map(function ($document) {
                // Get the specific document details based on type
                $documentDetails = null;
                $patientName = null;
                $doctorName = null;

                switch ($document->document_type) {
                    case 'excuseletter':
                        $documentDetails = DB::table('excuseletter')->where('document_id', $document->id)->first();
                        $patientName = $documentDetails->patient_name ?? null;
                        $doctorName = $documentDetails->doctorName ?? null;
                        break;
                    case 'annual_medical_clearance':
                        $documentDetails = DB::table('annual_medical_clearances')->where('document_id', $document->id)->first();
                        $patientName = $documentDetails->patient_name ?? null;
                        $doctorName = $documentDetails->doctorName ?? null;
                        break;
                    case 'waiver':
                        $documentDetails = DB::table('waiver')->where('document_id', $document->id)->first();
                        $patientName = $documentDetails->name ?? null;
                        $doctorName = $documentDetails->doctorName ?? null;
                        break;
                    case 'medical_certificate':
                        $documentDetails = DB::table('medical_certificates')->where('document_id', $document->id)->first();
                        $patientName = $documentDetails->patient_name ?? null;
                        $doctorName = $documentDetails->doctorName ?? null;
                        break;
                    case 'medical_clearance':
                        $documentDetails = DB::table('medical_clearances')->where('document_id', $document->id)->first();
                        $patientName = $documentDetails->patient_name ?? null;
                        $doctorName = $documentDetails->doctorName ?? null;
                        break;
                    case 'waiver_for_pulmonary_cases':
                        $documentDetails = DB::table('waiver_for_pulmonary_cases')->where('document_id', $document->id)->first();
                        $patientName = $documentDetails->patient_name ?? null;
                        $doctorName = null;
                        break;
                    case 'dmdc_consent_form':
                        $documentDetails = DB::table('dmdc_consent_forms')->where('document_id', $document->id)->first();
                        $patientName = null;
                        $doctorName = null;
                        break;
                }

                // Format document type for display
                $document->documentTypeFormatted = ucwords(str_replace('_', ' ', $document->document_type));

                // Add formatted date
                $document->formattedDate = Carbon::parse($document->created_at)->format('M d, Y');

                // Add patient name and doctor name if available
                $document->patientName = $patientName;
                $document->doctorName = $doctorName;

                // For specific document types, add additional details
                if ($documentDetails) {
                    if (isset($documentDetails->date)) {
                        $document->documentDate = Carbon::parse($documentDetails->date)->format('M d, Y');
                    }

                    $document->specificDetails = $documentDetails;
                }

                return $document;
            });

            // Combine search results into categories
            $searchResults = [
                'patients' => $patients,
                'medicines' => $medicines,
                'supplies' => $supplies,
                'reports' => $reports,
                'documents' => $formattedDocuments,
                'hasResults' => $patients->count() + $medicines->count() + $supplies->count() +
                    $reports->count() + $formattedDocuments->count() > 0,
                'totalCount' => $patients->count() + $medicines->count() + $supplies->count() +
                    $reports->count() + $formattedDocuments->count()
            ];

            // Log search for analytics
            Log::info('Dashboard search performed', [
                'search_term' => $searchTerm,
                'results_count' => $searchResults['totalCount'],
                'user_id' => auth()->id() ?? 'guest'
            ]);
        }

        // Get total patient count
        $totalPatients = Patient::count();

        // Get total medicines count (only for boxes that are not returned)
        $totalMedicines = Medicine::whereHas('box', function ($query) {
            $query->where('isReturned', 0);
        })->count();

        // You can also get counts by patient type
        $patientCounts = [
            'students' => Patient::where('patientType', 'Student')->count(),
            'faculty' => Patient::where('patientType', 'Faculty')->count(),
            'dependents' => Patient::where('patientType', 'Dependent')->count(),
            'admin' => Patient::where('patientType', 'Admin')->count(),
            'visitors' => Patient::where('patientType', 'Visitor')->count(),
        ];

        // Get monthly patient counts for current year
        $monthlyPatients = Patient::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill in missing months with zero
        $monthlyPatientCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyPatientCounts[] = $monthlyPatients[$month] ?? 0;
        }

        // Get returned and not returned medicine counts
        $medicineStatus = [
            'returned' => Medicine::whereHas('box', function ($query) {
                $query->where('isReturned', 1);
            })->count(),
            'active' => Medicine::whereHas('box', function ($query) {
                $query->where('isReturned', 0);
            })->count()
        ];

        // Get top consumed medicines
        $topMedicines = Medicine::select('medicine_name', 'consumed_quantity', 'unit')
            ->orderByDesc('consumed_quantity')
            ->limit(10)
            ->get();

        // If we have less than 10 medicines, pad the arrays with empty values
        $medicineNames = array_pad($topMedicines->pluck('medicine_name')->toArray(), 10, 'No Medicine');
        $medicineQuantities = array_pad($topMedicines->pluck('consumed_quantity')->toArray(), 10, 0);
        $medicineUnits = array_pad($topMedicines->pluck('unit')->toArray(), 10, '');

        // Get supplies quantities
        $suppliesStatus = [
            'initial' => Supply::sum('initial_quantity'),
            'consumed' => Supply::sum('consumed_quantity')
        ];

        // Get equipment status counts
        $equipmentStatus = [
            'serviceable' => Equipment::where('serviceable', 1)->sum('quantity'),
            'for_repair' => Equipment::where('for_repair', 1)->sum('quantity'),
            'for_condemn' => Equipment::where('for_condemn', 1)->sum('quantity'),
            'need_replacement' => Equipment::where('need_replacement', 1)->sum('quantity')
        ];

        // Get total documents count (excluding soft deleted)
        $totalDocuments = Document::count();  // This automatically excludes soft deleted records

        $totalReports = Report::count();

        return view('dashboard.dashboard_index', compact(
            'totalPatients',
            'patientCounts',
            'totalMedicines',
            'monthlyPatientCounts',
            'medicineStatus',
            'medicineNames',
            'medicineQuantities',
            'medicineUnits',
            'suppliesStatus',
            'equipmentStatus',
            'totalDocuments',
            'totalReports',
            'searchResults',
            'searchTerm'
        ));
    }

    private function createNotification($title, $message, $type, $userIds, $medicineId)
    {
        try {
            $notification = Notification::create([
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'reference_id' => $medicineId
            ]);

            // Attach users to the notification using pivot table
            $notification->users()->attach($userIds);

            Log::info('Successfully created notification', [
                'notification_id' => $notification->id,
                'type' => $type
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error("Error creating {$type} notification", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    private function checkExpiringMedicines()
    {
        try {
            $today = Carbon::today('Asia/Manila');
            $userIds = User::pluck('id')->toArray();

            Log::info('Starting medicine expiry check', [
                'today' => $today->format('Y-m-d'),
                'users' => count($userIds)
            ]);

            $medicines = Medicine::whereNotNull('expiration_date')
                ->whereHas('box', function ($query) {
                    $query->where('isReturned', 0);
                })
                ->get();

            Log::info('Found medicines to check', ['count' => $medicines->count()]);

            foreach ($medicines as $medicine) {
                $expiryDate = Carbon::parse($medicine->expiration_date)->startOfDay();
                $daysRemaining = $today->diffInDays($expiryDate);

                Log::info('Checking medicine', [
                    'id' => $medicine->id,
                    'name' => $medicine->medicine_name,
                    'expiry_date' => $expiryDate->format('Y-m-d'),
                    'days_remaining' => $daysRemaining
                ]);

                // Quarterly notification (31-90 days)
                if ($daysRemaining <= 90 && $daysRemaining > 30 && !$medicine->notified_quarterly) {
                    try {
                        $this->createNotification(
                            'Medicine Expiring within 3 Months',
                            "{$medicine->medicine_name} will expire in {$daysRemaining} " .
                                ($daysRemaining == 1 ? 'day' : 'days') . " on " .
                                $expiryDate->format('M d, Y') . "",
                            'warning',
                            $userIds,
                            $medicine->id
                        );

                        $medicine->notified_quarterly = true;
                        $medicine->save();
                    } catch (\Exception $e) {
                        Log::error('Error creating monthly notification', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }

                // Monthly notification (8-30 days)
                if ($daysRemaining <= 30 && $daysRemaining > 7 && !$medicine->notified_monthly) {
                    try {
                        $this->createNotification(
                            'Medicine Expiring in a Month',
                            "{$medicine->medicine_name} will expire in {$daysRemaining} " .
                                ($daysRemaining == 1 ? 'day' : 'days') . " on " .
                                $expiryDate->format('M d, Y') . "",
                            'warning',
                            $userIds,
                            $medicine->id
                        );

                        $medicine->notified_monthly = true;
                        $medicine->save();
                    } catch (\Exception $e) {
                        Log::error('Error creating monthly notification', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }

                // Weekly notification (2-7 days)
                if ($daysRemaining <= 7 && $daysRemaining >= 1 && !$medicine->notified_weekly) {
                    try {
                        $this->createNotification(
                            'Medicine Expiring This Week',
                            "{$medicine->medicine_name} will expire in {$daysRemaining} " .
                                ($daysRemaining == 1 ? 'day' : 'days') . " on " .
                                $expiryDate->format('M d, Y') . ".",
                            'danger',
                            $userIds,
                            $medicine->id
                        );

                        $medicine->notified_weekly = true;
                        $medicine->save();
                    } catch (\Exception $e) {
                        Log::error('Error creating weekly notification', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }

                // Daily Missed (< 0 day)
                if ($daysRemaining < 0 && !$medicine->notified_today) {
                    try {
                        $this->createNotification(
                            'Medicine Has Expired',
                            "{$medicine->medicine_name} has expired on " . $expiryDate->format('M d, Y') .
                                " and is not usable anymore. Please dispose of properly.",
                            'deleted',
                            $userIds,
                            $medicine->id
                        );

                        $medicine->notified_today = true;
                        $medicine->save();
                    } catch (\Exception $e) {
                        Log::error('Error creating expired notification', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }

                // Daily notification (0 day)
                if ($daysRemaining == 0 && !$medicine->notified_today) {
                    try {
                        $this->createNotification(
                            'Medicine Expiring Today',
                            "{$medicine->medicine_name} will expire today " . $expiryDate->format('M d, Y') . ".",
                            'deleted',
                            $userIds,
                            $medicine->id
                        );

                        $medicine->notified_today = true;
                        $medicine->save();
                    } catch (\Exception $e) {
                        Log::error('Error creating daily notification', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
            }

            Log::info('Completed medicine expiry check');
        } catch (\Exception $e) {
            Log::error('Error checking expiring medicines', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function superadminDashboard()
    {
        $total_users = User::all()->count();
        $total_active_users = User::where('status', 'active')->count();
        $total_inactive_users = User::where('status', 'inactive')->count();

        return view('SuperAdmin.Superadmin_dashboard', compact('total_users', 'total_active_users', 'total_inactive_users'));
    }
}
