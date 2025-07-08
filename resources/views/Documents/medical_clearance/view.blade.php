@extends('layouts.app-layout')

@section('title', 'Medical Clearance')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Waiver Form</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Adjusting for print */
        @media print {
            header {
                padding: 0;
            }

            @page {
                size: A4;
                margin: 0;

            }

            .page {

                margin-top: 0;
                /* Move the form up */
                position: relative;
                top: -140px;
                /* Adjust to move the form higher */
                margin-top: 0;

            }

            body {
                zoom: 0.95;
                font-family: Arial;
                font-size: 12px;
            }

            /* Hide all content except the container */
            body * {
                visibility: hidden;
            }

            .container,
            .container * {

                visibility: visible;
                padding-top: 0;
                margin-top: 0;
            }
            .page:last-child {
                page-break-after: auto;
            }

            .page {
                display: block;
                height: 100%;

            }

            body {
                overflow: hidden;
            }


            .flex-container {
                flex-direction: column;
                /* gap: 5px; */
            }
            body, html {
                margin: 0 !important;
                padding: 0 !important;
                height: 100% !important;
                overflow: hidden !important;
            }

        }

        /* Make the modal scrollable */
        .modal-content1 {
            max-height: 80vh;
            /* Limit the height to 80% of the viewport */
            overflow-y: auto;
            /* Enable vertical scrolling if content exceeds */
            padding-right: 15px;
            /* Add space for scrollbar */
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
                <!-- Document 2 (duplicate the structure as needed) -->
                <div class="container">
                        <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                            <p>{{ $specificDocument->control_number ?? '__________' }}</p>
                            <p>Rev. {{ $specificDocument->revision ?? '_________'}}</p>
                            <p>{{ \Carbon\Carbon::parse($specificDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                        </div>
                    <div class="flex items-center justify-center mb-4">
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
                            <h2 class="text-xl font-semibold">MEDICAL CLEARANCE</h2>
                        </div>

                    </div>

                    <div class="text-right my-0 mb-8 font-Arial">
                        <label class="font-medium">Date: </label>
                        <span id="date-placeholder" class="underline">{{ $specificDocument->date ? \Carbon\Carbon::parse($specificDocument->date)->format('F j, Y') : '__________' }}
                        </span>
                    </div>

                    <div class="space-y-4 font-Arial mb-5">
                        <p>To Whom It May Concern:</p>
                        <p class="indent-8">
                            This is to clarify that <span id="name-placeholder" class="underline">
                            {{ $specificDocument->patient_name ?? '______________' }}</span>
                            has been examined by the undersigned and found to be physically fit at the time of examination.
                        </p>
                        <p class="indent-8">
                            This certification is issued upon his/her request for <span id="excuse-placeholder"
                                class="underline">{{ $specificDocument->excuse ?? '_____________' }}</span> purposes but not for medico-legal
                            reason.
                        </p>

                    </div>
                    <!-- Flex Row for COVID Status and Signature -->
                    <div class="flex justify-between pt-10">
                        <div id="" class="w-1/2 text-left">
                            <p>COVID-19 Vaccination Status:</p>
                            <p><span class="checkbox" id="status-unvaccinated">{{ $specificDocument->vaccination_status == 'Unvaccinated' ? '___✓___' : '_____' }}</span> Unvaccinated</p>
                            <p><span class="checkbox" id="status-incomplete">{{ $specificDocument->vaccination_status == 'Primary Incomplete' ? '___✓___' : '_____' }}</span> Primary series incomplete</p>
                            <p><span class="checkbox" id="status-completed">{{ $specificDocument->vaccination_status == 'Primary Complete' ? '___✓___' : '_____' }}</span> Primary dose / series completed</p>
                            <p><span class="checkbox" id="status-boosters">{{ $specificDocument->vaccination_status == 'Boosters' ? '___✓___' : '_____' }}</span> 1st / second Boosters</p>
                        </div>
                        <div class="w-11/30 text-left">
                        <p><span id="x-ray-placeholder2" class="underline">{{ $specificDocument->doctorName ?? '__________' }}</span><label class="font-medium"> M.D. </label></p>
                        <p><span id="x-ray-placeholder2" class="font-medium">{{ $specificDocument->position ?? '__________' }}</span> </p>
                        <p><label class="font-medium">Lic No. </label> <span id="lic_no-placeholder2" class="underline">
                        {{ $specificDocument->license_number ?? '__________' }}</span></p>
                    </div>
                    </div>
                </div>
            </div>


            <div class="page">
                <!-- Document 2 (duplicate the structure as needed) -->
                <div class="container">
                        <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                            <p>{{ $specificDocument->control_number ?? '__________' }}</p>
                            <p>Rev. {{ $specificDocument->revision ?? '_________'}}</p>
                            <p>{{ \Carbon\Carbon::parse($specificDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                        </div>
                    <div class="flex items-center justify-center mb-4">
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
                            <h2 class="text-xl font-semibold">MEDICAL CLEARANCE</h2>
                        </div>

                    </div>

                    <div class="text-right my-0 mb-8 font-Arial">
                        <label class="font-medium">Date: </label>
                        <span id="date-placeholder" class="underline">{{ $specificDocument->additional_date ? \Carbon\Carbon::parse($specificDocument->additional_date)->format('F j, Y') : '__________' }}
                        </span>
                    </div>

                    <div class="space-y-4 font-Arial mb-5">
                        <p>To Whom It May Concern:</p>
                        <p class="indent-8">
                            This is to clarify that <span id="name-placeholder" class="underline">
                            {{ $specificDocument->additional_patient_name ?? '______________' }}</span>
                            has been examined by the undersigned and found to be physically fit at the time of examination.
                        </p>
                        <p class="indent-8">
                            This certification is issued upon his/her request for <span id="excuse-placeholder"
                                class="underline">{{ $specificDocument->additional_excuse ?? '_____________' }}</span> purposes but not for medico-legal
                            reason.
                        </p>
                        <div class="mt-5">
                            <span>X-ray Result: <span id="x-ray-placeholder2" class="underline">
                                {{ $specificDocument->xray_result ?? '_____________' }}</span>
                        </div>
                    </div>
                    <!-- Flex Row for COVID Status and Signature -->
                    <div class="flex justify-between pt-10 mb-0 pb-0">
                        <div id="" class="w-1/2 text-left">
                            <p>COVID-19 Vaccination Status:</p>
                            <p><span class="checkbox" id="status-unvaccinated">{{ $specificDocument->additional_vaccination_status == 'Unvaccinated' ? '___✓___' : '_____' }}</span> Unvaccinated</p>
                            <p><span class="checkbox" id="status-incomplete">{{ $specificDocument->additional_vaccination_status == 'Primary Incomplete' ? '___✓___' : '_____' }}</span> Primary series incomplete</p>
                            <p><span class="checkbox" id="status-completed">{{ $specificDocument->additional_vaccination_status == 'Primary Complete' ? '___✓___' : '_____' }}</span> Primary dose / series completed</p>
                            <p><span class="checkbox" id="status-boosters">{{ $specificDocument->additional_vaccination_status == 'Boosters' ? '___✓___' : '_____' }}</span> 1st / second Boosters</p>
                        </div>
                        <div class="w-11/30 text-left">
                        <p><span id="x-ray-placeholder2" class="underline">{{ $specificDocument->additional_doctorName ?? '__________' }}</span><label class="font-medium"> M.D. </label></p>
                        <p><span id="x-ray-placeholder2" class="font-medium">{{ $specificDocument->additional_position ?? '__________' }}</span> </p>
                        <p><label class="font-medium">Lic No. </label> <span id="lic_no-placeholder2" class="underline">
                        {{ $specificDocument->additional_license_number ?? '__________' }}</span></p>
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
