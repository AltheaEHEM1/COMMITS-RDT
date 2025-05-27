@extends('layouts.app-layout')

@section('title', 'Excuse Letter')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>View | Excuse Letter</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Adjusting for print */

        /* Print-specific styles */
        @media print {
            .print\\:hidden {
                display: none !important;
            }

            @page {
                /* size: A4; */
                margin: 0;

            }

            .container {
                width: 100% !important;
                margin: 10 auto !important;
                padding: 10;
            }

            .page {
                margin-top: 10;
                /* Move the form up */
                position: relative;
                padding-top: 40px;
                /* padding-left: 10px; */
                padding-right: 10px;
                /* Adjust to move the form higher */

            }

            .container,
            .container * {
                visibility: visible;
            }

        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex space-x-10 justify-between mb-5 print:hidden">
        <button class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400 flex items-center space-x-2"
            onclick="goBack()" aria-label="Go Back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path
                    d="M3.82843 6.9999H16V8.9999H3.82843L9.1924 14.3638L7.7782 15.778L0 7.9999L7.7782 0.22168L9.1924 1.63589L3.82843 6.9999Z"
                    fill="black" />
            </svg>
            <span>Back</span>
        </button>

        <div>
            <button class="px-4 py-2 bg-[#7A0019] text-white rounded-md hover:bg-opacity-80 mr-5"
                onclick="printWaiver()" aria-label="Print the form">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20"
                    fill="none">
                    <path
                        d="M18.75 0.000488281C19.4404 0.000488281 20 0.448208 20 1.00049V5.00049H23.75C24.4404 5.00049 25 5.44821 25 6.00049V16.0005C25 16.5528 24.4404 17.0005 23.75 17.0005H20V19.0005C20 19.5528 19.4404 20.0005 18.75 20.0005H6.25C5.55965 20.0005 5 19.5528 5 19.0005V17.0005H1.25C0.55965 17.0005 0 16.5528 0 16.0005V6.00049C0 5.44821 0.55965 5.00049 1.25 5.00049H5V1.00049C5 0.448208 5.55965 0.000488281 6.25 0.000488281H18.75ZM17.5 15.0005H7.5V18.0005H17.5V15.0005ZM22.5 7.00049H2.5V15.0005H5V14.0005C5 13.4482 5.55965 13.0005 6.25 13.0005H18.75C19.4404 13.0005 20 13.4482 20 14.0005V15.0005H22.5V7.00049ZM7.5 8.00049V10.0005H3.75V8.00049H7.5ZM17.5 2.00049H7.5V5.00049H17.5V2.00049Z"
                        fill="white" />
                </svg>
            </button>
        </div>
    </div>

    <div class="container mx-auto bg-white md:py-20 md:px-20 w-[90%] md:w-[70%] lg:w-[70%]">
        <div class="page">
            <!-- Document Content -->
            <div class="container">
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $specificDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $specificDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($specificDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
                <div class="flex items-center justify-center mb-10">
                    <div class="mr-5">
                        <img src="{{ asset('Logo_image/logopup.png') }}" alt="University logo" class="w-28 mb-5">
                    </div>
                    <div class="text-center" style="font-family: 'Times New Roman', serif;">

                        <h1 class="text-sm font-normal">Republic of the Philippines</h1>
                        <h1 class="text-base font-normal">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h1>
                        <p class="text-sm mb-5">Quezon City</p>
                        <h2 class="text-xl font-semibold">EXCUSE LETTER</h2>
                    </div>
                </div>

                <!-- Body Content -->
                <!-- Body Content -->
                <div id="letterOutput" class="md:px-10" style="font-size: 14px">
                    <div class="mb-10 text-right text-base">
                        <label class="font-medium">Date: </label>
                        <span id="letterDate" class="underline">{{ \Carbon\Carbon::parse($specificDocument->date)->format('F j, Y') }} </span>
                    </div>
                    <div class="space-y-4">
                        <p class="text-lg">
                            Dear <span id="recipientName" class="underline">{{ $specificDocument->recipient }}</span>,
                        </p>
                        <p class="text-lg">
                            I, <span id="studentName" class="underline">{{ $specificDocument->patient_name }}</span>, a student of the
                            <span id="department" class="underline">{{ $specificDocument->department }}</span> Department, would
                            like to inform you that I was unable to attend class on <span
                                id="absenceDate" class="underline">{{ \Carbon\Carbon::parse($specificDocument->excuse_for)->format('F j, Y') }}</span> due to <span
                                id="reasons" class="underline">{{ $specificDocument->cause }}</span>.
                        </p>
                        <p class="text-lg">
                            Thank you for your consideration.
                        </p>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="flex justify-end mt-10">
                    <div class="w-11/30 text-left">
                        <p class="font-medium">Sincerely,</p>
                        <p id="studentSignature" class="underline">{{ $specificDocument->patient_name }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-10">
                    <div class="text-left">
                        <p id="physicianSignature" class="underline">{{ $specificDocument->doctorName }} <label class="font-medium">M.D. </label>
                        </p>

                        <p class="text-center font-medium">Clinic Physician</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-auto bg-white md:py-20 md:px-20 w-[90%] md:w-[70%] lg:w-[70%]">
            <div class="page">

                    <!-- Modal Script -->
                    <script>
                        function goBack() {
                            window.location.href = "{{ route('documents.index') }}";
                        }

                        function printWaiver() {
                            window.print();
                        }
                    </script>
            </div>
        </div>
    </div>
</body>

</html>
@endsection
