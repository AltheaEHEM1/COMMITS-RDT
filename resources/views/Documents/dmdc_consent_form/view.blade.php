@extends('layouts.app-layout')

@section('title', 'DMDC Consent Form')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>DMDC Consent Form</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Adjusting for print */
        .underlined {
            text-decoration: underline;
            text-decoration-color: #000;
            text-decoration-style: solid;
        }


        @media print {
    .header-print img {
        margin-left: -20px; /* Adjust this value to decrease the left margin */
    }

    .header-print {
        padding-left: 0;
        /* Remove or reduce left padding if needed */
    }

    .header-print p {
        font-size: 12px;
        line-height: 1.3;
        /* Adjust line spacing for paragraphs */
    }

    .header-print h2 {
        font-size: 14px;
        line-height: 1.2;
    }

    @page {
        margin: 0;
    }

    .page {
        margin-top: 0;
        padding-top: 0;
        position: relative;
        top: -70px;
        padding-right: 10px;
    }

    body {
        font-family: Arial;
        font-size: 12px;
    }

    body * {
        visibility: hidden;
    }

    .container,
    .container * {
        visibility: visible;
    }

    .page {
        display: block;
        height: 100%;
    }

    .flex-container {
        flex-direction: column;
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

    <div class="container mx-auto bg-white md:py-20 md:px-10 w-[90%] md:w-[70%] lg:w-[70%]">
        <div class="page">
            <!-- Document 2 (duplicate the structure as needed) -->
            <div class="container">
                    <div class="flex flex-col items-end text-xs leading-tight text-gray-800">
                        <p>{{ $specificDocument->control_number ?? '__________' }}</p>
                        <p>Rev. {{ $specificDocument->revision ?? '_________'}}</p>
                        <p>{{ \Carbon\Carbon::parse($specificDocument->date_issued)->format('F j, Y') ?? '__________' }} </p>
                    </div>
                <div class="flex items-center">
                    <div class="mr-5">
                        <img src="{{ asset('Logo_image/logopup.png') }}" alt="Logo" class="w-24 ">
                    </div>
                    <div style="font-family: 'Times New Roman', serif;" class="header-print">
                        <!-- Republic heading -->
                        <p class="text-sm font-normal">Republic of the Philippines</p>
                        <!-- University heading -->
                        <h2 class="text-base font-bold">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</h2>
                        <p class="text-base font-normal">OFFICE OF THE VICE PRESIDENT FOR CAMPUSES</p>
                        <!-- Location -->
                        <h2 class="text-base font-bold">QUEZON CITY CAMPUS</h2>
                    </div>

                    <!-- Medical clearance title -->

                </div>
            </div>

            <div class="md:px-10" style="font-size: 14px">
                <p class="border-b border-black w-full mb-8 ">&nbsp;</p>
                <h2 class="text-center text-lg font-bold mb-10">Declaration of Medical Information and Data Subject
                    Consent Form</h2>

                <p class="mb-8 text-justify">
                    I hereby certify that the medical health information given to the physician and nurse of this
                    campus, during my on-site consultation for the issuance of medical clearance for off-campus
                    activity/ies are true, correct and complete to the best of my knowledge. I have fully disclosed
                    all the medical conditions that may affect the assessment to endorse my participation in the
                    <span id="activityname" class="underline font-semibold">{{ $specificDocument->event_name}}</span> as a student of PUP.
                </p>
                <p class="mb-8 text-justify">
                    I also understand that the PUP Medical Services and University will not be liable for any
                    untoward incident that may arise due to my failure to disclose accurate information or
                    intentionally providing false and deceptive information.
                </p>
                <p class="mb-10 text-justify">
                    In compliance with the Data Privacy Act of 2012 and its implementing Rules and Regulations, I
                    voluntarily consent to the collection, processing, and storage of my personal and health
                    information for the purpose/s of health assessment, treatment, or research (following research
                    ethics guidelines) for the improvement of healthcare services.
                </p>

                <div class="flex flex-col gap-6 pt-10">
                    <div class="flex justify-end">
                        <div class="w-1/2 text-left">
                            <p class="border-b border-black w-full">&nbsp;</p>
                            <p class="text-center mt-2">Student's Signature Over Printed Name/Age/Date</p>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <div class="w-1/2 text-left">
                            <p class="text-left mt-2">Remarks:</p> <!-- Center aligned remarks -->
                        </div>
                    </div>

                    <div class="flex justify-end pl-10">
                        <div class="w-1/2 text-left ">
                            <p class="border-b border-black w-full">&nbsp;</p>
                            <p class="text-center mt-2">Guardian's Signature Over Printed Name/Date</p>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <div class="w-1/2 text-left">
                            <p class="font-bold italic">* Both student and guardian will affix their signature if
                                the student is aged below 18 years old.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    <script>
        // Function to print the document
        function printWaiver() {
            window.print();
        }

        // Function to go back to the previous page
        function goBack() {
            window.location.href = "{{ route('documents.index') }}";
        }


    </script>

</body>

</html>
@endsection
