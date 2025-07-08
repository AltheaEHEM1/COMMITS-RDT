@extends('layouts.app-layout')

@section('title', 'Waver for Pulmonary Case Form')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Waiver For Pulmonary Case Form</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Adjusting for print */
        @media print {
            @page {
                size: A4; /* O palitan ng 'Letter' kung Letter size ang gamit */
                margin: 0; /* Tanggalin ang margin */
            }

            body, html {
                margin: 0 !important;
                padding: 0 !important;
                height: 100% !important;
                overflow: hidden !important;
            }


            .page {
                margin: 0; /* Siguraduhing walang margin ang page */
                padding: 0; /* Siguraduhing walang padding ang page */
                position: relative;
                top: -130px; /* Alisin ang offset */
            }
                body {
                font-family: Arial;
                font-size: 13px;
            }
            .container {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
          }
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Buttons (Optional for print view, you can hide them when printing) -->
    <div class="flex space-x-10 justify-between mb-5">
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
            <button class="px-4 py-2 bg-[#7A0019] text-white rounded-md hover:bg-[#7A0019] hover:bg-opacity-80 mr-5"
                onclick="printWaiver()" aria-label="Print the form">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20" fill="none">
                    <path
                        d="M18.75 0.000488281C19.4404 0.000488281 20 0.448208 20 1.00049V5.00049H23.75C24.4404 5.00049 25 5.44821 25 6.00049V16.0005C25 16.5528 24.4404 17.0005 23.75 17.0005H20V19.0005C20 19.5528 19.4404 20.0005 18.75 20.0005H6.25C5.55965 20.0005 5 19.5528 5 19.0005V17.0005H1.25C0.55965 17.0005 0 16.5528 0 16.0005V6.00049C0 5.44821 0.55965 5.00049 1.25 5.00049H5V1.00049C5 0.448208 5.55965 0.000488281 6.25 0.000488281H18.75ZM17.5 15.0005H7.5V18.0005H17.5V15.0005ZM22.5 7.00049H2.5V15.0005H5V14.0005C5 13.4482 5.55965 13.0005 6.25 13.0005H18.75C19.4404 13.0005 20 13.4482 20 14.0005V15.0005H22.5V7.00049ZM7.5 8.00049V10.0005H3.75V8.00049H7.5ZM17.5 2.00049H7.5V5.00049H17.5V2.00049Z"
                        fill="white" />
                </svg>
            </button>
        </div>
    </div>

    <div class="container mx-auto bg-white md:py-20 md:px-20 w-[90%] md:w-[70%] lg:w-[70%]">
        <div class="page">
            <div class="container">
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $specificDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $specificDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($specificDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
                <div class="flex items-center justify-center mb-5">
                    <div class="mr-5">
                        <img src="{{ asset('Logo_image/logopup.png') }}" alt="Logo" class="w-28 mb-5">
                    </div>
                    <div class="text-center" style="font-family: 'Times New Roman', serif;">
                        <h1 class="text-sm font-normal">Republic of the Philippines</h1>
                        <h1 class="text-base font-normal">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h1>
                        <p class="text-sm mb-5">Quezon City</p>
                        <h2 class="text-xl font-semibold">WAIVER PULMONARY CASE</h2>
                    </div>
                </div>
                <div class="text-right my-10 mb-8 font-Arial">
                    <label class="font-medium">Date: </label>
                     <span id="date-placeholder" class="underline">{{ $specificDocument->date ? \Carbon\Carbon::parse($specificDocument->date)->format('F j, Y') : '__________' }}
                    </span>
                </div>

                <div class="space-y-4 font-Arial ">

                    <p class="indent-8">
                        I, <span id="name-placeholder" class="underline">
                        {{ $specificDocument->patient_name ?? '__________' }}</span>
                        student from the College of <span id="school" class="underline">{{ $specificDocument->collegeName ?? '__________' }}</span>, school year
                        <span id="department" class="underline">{{ $specificDocument->year ?? '__________' }}</span>, am aware that as per medical advice from the
                        University Medical Clinic, should submit by myself for
                        follow-up medical check-up on <span id="date" class="underline">{{ $specificDocument->followUpDate ? \Carbon\Carbon::parse($specificDocument->followUpDate)->format('F j, Y') : '__________' }}</span> and that
                        additional clearance must be secured prior to the next
                        semester's enrollment.
                    </p>
                </div>

                <div class="flex justify-end pt-5">
                    <div class="w-11/30 text-left">
                        <p>_______________________________</p>
                        <p class="text-center">Signature</p>
                    </div>
                </div>

                <div class="flex justify-start p-0">
                    <div class="w-11/30 text-left">
                        <p>Comforme:</p><br>
                        <p>_______________________________</p>
                        <p class="text-center">Parent / Guardian</p>
                    </div>
                </div>
            </div>


            <!-- Document 2 (duplicate the structure as needed) -->
            <div class="container2 mt-15">
                        <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                            <p>{{ $specificDocument->control_number ?? '__________' }}</p>
                            <p>Rev. {{ $specificDocument->revision ?? '_________'}}</p>
                            <p>{{ \Carbon\Carbon::parse($specificDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                        </div>
                <div class="flex items-center justify-center mb-5">
                    <div class="mr-5">
                        <img src="{{ asset('Logo_image/logopup.png') }}" alt="Logo" class="w-28 mb-5">
                    </div>
                    <!-- Center-aligned text block with a serif font -->
                    <div class="text-center" style="font-family: 'Times New Roman', serif;">
                        <!-- Republic heading -->
                        <h1 class="text-sm font-normal">Republic of the Philippines</h1>
                        <!-- University heading -->
                        <h1 class="text-base font-normal">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h1>
                        <!-- Location -->
                        <p class="text-sm mb-5">Quezon City</p>
                        <!-- Medical clearance title -->
                        <h2 class="text-xl font-semibold">WAIVER PULMONARY CASE</h2>
                    </div>

                </div>

                <div class="text-right my-10 mb-8 font-Arial">
                        <label class="font-medium">Date: </label>
                        <span id="date-placeholder" class="underline">{{ $specificDocument->additional_date ? \Carbon\Carbon::parse($specificDocument->additional_date)->format('F j, Y') : '__________' }}
                        </span>
                    </div>
                <div class="space-y-4 font-Arial ">
                    <p class="indent-8">
                        I, <span id="name-placeholder2" class="underline">
                        {{ $specificDocument->additional_patient_name ?? '__________' }}</span> student from
                        the College of <span id="school2" class="underline">{{ $specificDocument->additional_collegeName ?? '__________' }}</span> , school year
                        <span id="department2" class="underline">{{ $specificDocument->additional_year ?? '__________' }}</span>, am aware that as per medical advice from the
                        University Medical Clinic, should submit by myself for
                        follow-up medical check-up on
                        <span id="date2" class="underline">{{ $specificDocument->additional_date ? \Carbon\Carbon::parse($specificDocument->additional_date)->format('F j, Y') : '__________' }}</span> and that additional clearance must be secured prior
                        to the next
                        semester's enrollment.
                </div>

                <div class="flex justify-end pt-5">
                    <div class="w-11/30 text-left">
                        <p>_______________________________</p>
                        <p class="text-center">Signature</p>
                    </div>
                </div>

                <div class="flex justify-start p-0">
                    <div class="w-11/30 text-left">
                        <p>Comforme:</p><br>
                        <p>_______________________________</p>
                        <p class="text-center">Parent / Guardian</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        function printWaiver() {
            window.print();
        }

        function goBack() {
            window.location.href = "{{ route('documents.index') }}";
        }

    </script>

</body>

</html>
@endsection
