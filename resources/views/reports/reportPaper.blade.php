@extends('layouts.app-layout')

@section('content')
    <div class="flex flex-row justify-between pb-6 pr-16 text-white gap-x-5">
        <div>
            <button class="flex items-center px-4 py-2 space-x-2 text-black bg-gray-200 rounded hover:bg-gray-300"
                onclick="window.history.back()" aria-label="Go Back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M3.82843 6.9999H16V8.9999H3.82843L9.1924 14.3638L7.7782 15.778L0 7.9999L7.7782 0.22168L9.1924 1.63589L3.82843 6.9999Z"
                        fill="black" />
                </svg>
                <span>Back</span>
            </button>
        </div>
    </div>

    <div class="flex flex-row justify-end pb-6 pr-16 text-white gap-x-5">
        <button title="Edit" onclick=openEditFormModal() class="relative flex flex-col items-center px-3 py-2 space-y-1 font-bold text-blue-500 bg-blue-100 rounded-lg group hover:bg-blue-200 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
              </svg>              
        </button>
        <button title="Print" onclick=printReportPaper() class="relative flex flex-col items-center px-3 py-2 space-y-1 font-bold text-blue-500 bg-blue-100 rounded-lg group hover:bg-blue-200 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>           
        </button>
        <form id="exportForm" action={{ route('reports.exportExcel') }} method='GET'>

            <!-- Hidden field to hold the tableData -->
            <input type="hidden" name="tableData" id="tableData">
            <input type="hidden" name="title" id="exportTitle">
            <input type="hidden" name="fromDate" id="exportFromDate">
            <input type="hidden" name="toDate" id="exportToDate">
            <input type="hidden" name="physicianName" id="exportPhysicianName">
            <input type="hidden" name="position" id="exportPosition">
            <input type="hidden" name="unitDepartment" id="exportUnitDepartment">
            <input type="hidden" name="submissionDate" id="exportSubmissionDate">
            <input type="hidden" name="campusPhysician" id="exportCampusPhysician">
            <input type="hidden" name="campusNurse" id="exportCampusNurse">
            <input type="hidden" name="femaleStudent"   id="exportFemaleStudent">
            <input type="hidden" name="femaleFaculty"   id="exportFemaleFaculty">
            <input type="hidden" name="femaleAdmin"     id="exportFemaleAdmin">
            <input type="hidden" name="femaleDependent" id="exportFemaleDependent">
            <input type="hidden" name="femaleVisitor"   id="exportFemaleVisitor">
            <input type="hidden" name="femaleTotal"     id="exportFemaleTotal">
            <input type="hidden" name="maleStudent"   id="exportMaleStudent">
            <input type="hidden" name="maleFaculty"   id="exportMaleFaculty">
            <input type="hidden" name="maleAdmin"     id="exportMaleAdmin">
            <input type="hidden" name="maleDependent" id="exportMaleDependent">
            <input type="hidden" name="maleVisitor"   id="exportMaleVisitor">
            <input type="hidden" name="maleTotal"     id="exportMaleTotal">
            <input type="hidden" name="pwdStudent"   id="exportPWDStudent">
            <input type="hidden" name="pwdFaculty"   id="exportPWDFaculty">
            <input type="hidden" name="pwdAdmin"     id="exportPWDAdmin">
            <input type="hidden" name="pwdDependent" id="exportPWDDependent">
            <input type="hidden" name="pwdVisitor"   id="exportPWDVisitor">
            <input type="hidden" name="pwdTotal"     id="exportPWDTotal">
            <input type="hidden" name="seniorCitizenStudent"   id="exportSeniorCitizenStudent">
            <input type="hidden" name="seniorCitizenFaculty"   id="exportSeniorCitizenFaculty">
            <input type="hidden" name="seniorCitizenAdmin"     id="exportSeniorCitizenAdmin">
            <input type="hidden" name="seniorCitizenDependent" id="exportSeniorCitizenDependent">
            <input type="hidden" name="seniorCitizenVisitor"   id="exportSeniorCitizenVisitor">
            <input type="hidden" name="seniorCitizenTotal"     id="exportSeniorCitizenTotal">
            <input type="hidden" name="totalStudent" id="exportTotalStudent">
            <input type="hidden" name="totalFaculty" id="exportTotalFaculty">
            <input type="hidden" name="totalAdmin"   id="exportTotalAdmin">
            <input type="hidden" name="totalDependent" id="exportTotalDependent">
            <input type="hidden" name="totalVisitor" id="exportTotalVisitor">
            <input type="hidden" name="totalOverall" id="exportTotalOverall">
            <input type="hidden" name="bulletinUpdates" id="bulletinUpdates">


                <button type="submit" class="px-4 py-2 bg-blue-500 rounded-lg hover:bg-blue-600">
                    Export to Excel
                </button>
            </form>
        </div>
    </div>

    {{-- report paper --}}
    <div class="flex flex-row justify-center">
        <div id="reportPaperID" class="flex flex-col w-[90%] p-10 text-xs bg-white shadow-lg gap-y-2">
            {{-- header --}}
            <div class="flex flex-row items-center justify-end w-full">
                <div class="flex flex-row items-center gap-3 ">
                    <div class="flex flex-col">
                        <img id="pupLogo" alt="PUP Logo" src="{{ asset('images/puplogo.png') }}" class="w-24 h-24">
                    </div>
                    <div class="flex flex-col items-center">
                        <p class="font-sans font-bold">POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</p>
                        <p class="italic font-bold">Medical Services Department</p>
                        <p>Commonwealth, Quezon City</p>
                        <p class="mt-2" id="titleOut"></p>
                        <div class="flex flex-row items-center justify-center w-full gap-x-3">
                            <p id="fromDurationDateOut" class="mt-4"></p>
                            <p id="toDurationDateOut" class="mt-4"></p>
                        </div>
                    </div>
                </div>
                <div id="ctrlNumber" class="flex flex-col items-end justify-start w-64 h-full">
                    <div class="flex flex-col px-3 py-1 border-2 border-black border-solid">
                        <div class="flex flex-row"><p id="controlNumberOut" style="font-size: 10px;"></p></div>
                        <div class="flex flex-row"><p id="controlNumberDateOut" style="font-size: 10px;"></p></div>
                        <div class="flex flex-row"><p style="font-size: 10px;">Revision: </p><p id="controlNumberRevisionOut" style="font-size: 10px;"></p></div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-between px-6">
                <div class="flex flex-col">
                    <div class="flex flex-row">
                        <p class="pr-5 mr-3 font-bold">Name:</p>
                        <p id="physicianNameOut" class="underline"></p>
                    </div>
                    <div class="flex flex-row">
                        <p class="mr-5 font-bold">Position:</p>
                        <p id="positionOut" class="underline"></p>
                    </div>
                </div>
                <div class="flex flex-col pr-16">
                    <div class="flex flex-row">
                        <p class="mr-3 font-bold">Date of submission:</p>
                        <p id="submissionDateOut"></p>
                    </div>
                    <div class="flex flex-row">
                        <p class="mr-3 font-bold">Unit / Department:</p>
                        <p id="unitDepartmentOut"></p>
                    </div>
                </div>
            </div>
            {{-- table 1 --}}
            <table id="table1" class="border border-collapse border-black table-auto text-start">
                <thead>
                    <tr id="table-header" class="text-center bg-blue-100">
                        <th class="p-3 font-bold border border-black">MEDICAL SERVICES RENDERED</th>
                        <th class="p-3 font-bold border border-black">STUDENT</th>
                        <th class="p-3 font-bold border border-black">FACULTY</th>
                        <th class="p-3 font-bold border border-black">ADMIN</th>
                        <th class="p-3 font-bold border border-black">DEPENDENTS</th>
                        <th class="p-3 font-bold border border-black">VISITORS</th>
                        <th class="p-3 font-bold border border-black">REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- creates the table --}}
                    @foreach ($services as $service)
                        {{-- stop the loop when it comes to index 86 to separate the table --}}
                        @if ($loop->index == 86)
                            @break
                        @endif
                        <tr>
                            <td class="w-1/4 pl-5 border border-black 
                            {{-- adds custom styles to specific cells --}}
                            {{ in_array($loop->index, 
                            [2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 22, 23, 
                            24, 25, 26, 28, 29, 30, 31, 34, 35, 37, 38, 39, 40, 42, 44, 45, 46, 47, 
                            48, 49, 51, 52, 53, 54, 56, 57, 58, 61, 62, 63, 64, 65, 66, 68, 69, 71, 
                            72, 73, 74, 75, 77, 79, 80, 82, 83, 84, 85]) ? 'pl-9' : 
                            (in_array($loop->index, [0, 70, 76, 78, 81]) ? 'bg-blue-200 font-bold' :
                            (in_array($loop->index, [1, 11, 21, 27, 32, 33, 36, 41, 43, 50, 55, 59, 60, 67]) ? 'bg-yellow-100 font-bold' : '')) }}">{{ $service['name'] }}</td>
                            @foreach ($service['data'] as $data)
                                <td class="border border-black cells 
                                    {{ in_array($loop->parent->index, [0, 70, 76, 78, 81]) ? 'bg-blue-200 font-bold' :
                                    (in_array($loop->parent->index, [1, 11, 21, 27, 32, 33, 36, 41, 43, 50, 55, 59, 60, 67]) ? 'bg-yellow-100' : '') }}">
                                    @if ($loop->last)
                                        <input value="{{ $data }}" type="text" class="w-full pl-3 outline-none remarks-input
                                        {{ in_array($loop->parent->index, [0, 70, 76, 78, 81]) ? 'bg-blue-200 font-bold' :
                                        (in_array($loop->parent->index, [1, 11, 21, 27, 32, 33, 36, 41, 43, 50, 55, 59, 60, 67]) ? 'bg-yellow-100 font-bold' : '') }}">
                                    @else
                                        <p class="w-full text-center">{{ $data }}</p>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- table 2 --}}
            <table id="table2">
                <tbody>
                    @foreach($services as $service)
                        {{-- continue the table in a new table with different design --}}
                        @if ($loop->index < 86) 
                            @continue
                        @endif
                        <tr>
                            <td class="w-1/4 pl-5 border border-black
                            {{-- adds custom styles to specific cells --}}
                            {{ in_array($loop->index, [86, 90]) ? 'bg-yellow-100 font-bold' :
                            (in_array($loop->index, [87, 88, 89, 91, 92]) ? 'pl-9' : '')}}">
                                {{ $service['name'] }}  
                            </td>
                            @foreach($service['data'] as $data)
                                <td class="border border-black cells
                                {{ in_array($loop->parent->index, [86, 90]) ? 'bg-yellow-100' : ''}}">
                                    @if ($loop->last)
                                        <input value="{{ $data }}" type="text" class="w-full pl-3 outline-none remarks-input
                                        {{ in_array($loop->parent->index, [86, 90]) ? 'bg-yellow-100 font-bold' : ''}}">
                                    @else
                                        <p class="w-16 text-center">{{ $data }}</p>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- table 3 --}}
            <table id="table3" class="w-full border border-collapse border-black">
                <tr>
                    <td class="w-2/5 pl-5 font-bold bg-yellow-100 border border-black cells">VII. BULLETIN UPDATES</td>
                    <td class="w-24 bg-yellow-100 border border-black"></td>
                    <td class="w-24 bg-yellow-100 border border-black"></td>
                    <td class="w-24 bg-yellow-100 border border-black"></td>
                    <td class="w-24 bg-yellow-100 border border-black"></td>
                    <td class="w-1/5 bg-yellow-100 border border-black">
                        <input class="w-full pl-3 font-bold outline-none remarks-input">
                    </td>
                </tr>
                <tr>
                    <td class="w-2/5 border border-black"></td>
                    <td class="border border-black" colspan="5">
                        <textarea class="w-full pl-3 overflow-hidden resize-none textarea-input" oninput="autoExpand(this)"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="w-2/5 border border-black"></td>
                    <td class="border border-black w-1/10"></td>
                    <td class="border border-black w-1/10"></td>
                    <td class="border border-black w-1/10"></td>
                    <td class="border border-black w-1/10"></td>
                    <td class="w-1/5 border border-black">
                        <input class="w-full pl-3 outline-none remarks-input">
                    </td>
                </tr>
            </table>
            {{-- table 4 --}}
            <table id="table4" class="w-full table-fixed">
                <tbody>
                    <tr class="text-lg font-bold text-center bg-yellow-100">
                        <td class="w-8 border border-black">TOTAL</td>
                        <td class="w-8 border border-black"><p id="studentTotalOut"></p></td>
                        <td class="w-8 border border-black"><p id="facultyTotalOut"></p></td>
                        <td class="w-8 border border-black"><p id="adminTotalOut"></p></td>
                        <td class="w-8 border border-black"><p id="dependentTotalOut"></p></td>
                        <td class="w-8 border border-black"><p id="visitorTotalOut"></p></td>
                        <td class="w-8 border border-black"><p id="totalOut"></p></td>
                    </tr>
                </tbody>
            </table>
            {{-- table 5 --}}
            <table id="table5" class="w-full table-fixed">
                <thead>
                    <tr class="text-center bg-blue-100">
                        <th class="w-1/4 border border-black">GAD Consultation Census</th>
                        <th class="w-1/12 border border-black">Students</th>
                        <th class="w-1/12 border border-black">Faculty</th>
                        <th class="w-1/12 border border-black">Admin</th>
                        <th class="w-1/12 border border-black">Dependent</th>
                        <th class="w-1/12 border border-black">Visitor</th>
                        <th class="w-1/12 border border-black">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="pl-8 border border-black">Female</td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="femaleStudentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="femaleFacultyOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="femaleAdminOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="femaleDependentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="femaleVisitorOut"></input></td>
                        <td class="text-center border border-black"><input type="text" class="w-full text-center" readonly id="femaleTotalOut"></input></td>
                    </tr>
                    <tr>
                        <td class="pl-8 border border-black">Male</td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="maleStudentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="maleFacultyOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="maleAdminOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="maleDependentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="maleVisitorOut"></input></td>
                        <td class="text-center border border-black"><input type="text" class="w-full text-center" readonly id="maleTotalOut"></input></td>
                    </tr>
                    <tr>
                        <td class="pl-8 border border-black">PWD</td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="pwdStudentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="pwdFacultyOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="pwdAdminOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="pwdDependentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="pwdVisitorOut"></input></td>
                        <td class="text-center border border-black"><input type="text" class="w-full text-center" readonly id="pwdTotalOut"></input></td>
                    </tr>
                    <tr>
                        <td class="pl-8 border border-black">Senior Citizen</td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="seniorCitizenStudentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="seniorCitizenFacultyOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="seniorCitizenAdminOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="seniorCitizenDependentOut"></input></td>
                        <td class="text-center border border-black"><input type="number" class="w-full text-center" id="seniorCitizenVisitorOut"></input></td>
                        <td class="text-center border border-black"><input type="text" class="w-full text-center" readonly id="seniorCitizenTotalOut"></input></td>
                    </tr>
                    <tr class="text-lg font-bold text-center">
                        <td class="text-center border border-black">TOTAL</td>
                        <td class="text-center border border-black"><p id="totalStudentOut"></p></td>
                        <td class="text-center border border-black"><p id="totalFacultyOut"></p></td>
                        <td class="text-center border border-black"><p id="totalAdminOut"></p></td>
                        <td class="text-center border border-black"><p id="totalDependentOut"></p></td>
                        <td class="text-center border border-black"><p id="totalVisitorOut"></p></td>
                        <td class="text-center border border-black "><p id="totalTotalOut"></p></td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3">
                <p>Prepared by:</P>
            </div>
            <div id="approvalSection" class="w-[80%] flex flex-row gap-x-32 pl-10 pt-20 pb-20">
                <div class="flex flex-col">
                    <p class="font-bold underline" id="campusPhysicianOut"></p>
                    <p>Campus Physician</p>
                </div>
                <div class="flex flex-col">
                    <p class="font-bold underline" id="campusNurseOut"></p>
                    <p>Campus Nurse</p>
                </div>
            </div>
            <div class="flex flex-row gap-x-5">
                <div class="flex flex-col">
                    <div class="flex flex-row">
                        <p class="text-xs">Rothlehner Bldg., PUP Quezon City Campus, Don Fabian St., Commonwealth, Quezon City</p>
                    </div>
                    <div class="flex flex-row">
                        <p class="text-xs">Direct Line: 8287-82-04; 8952-78-18</p>
                    </div>
                    <div class="flex flex-row">
                        <p class="text-xs">Website: www.pup.edu.ph | Inquiries: <a href="https://bit.ly/PUPSINTA" target="_blank">https://bit.ly/PUPSINTA</a></p>
                    </div>
                    <div class="flex flex-row">
                        <p class="text-xl" style="font-family: 'Times New Roman'">THE COUNTRY'S 1<sup>st</sup> POLYTECHNIC U</p>
                    </div>
                </div>
                <div class="flex flex-row items-center gap-x-2">
                    <!-- Upload 1 -->
                    <div class="w-36">
                        <label for="dropzone-file-1" class="block cursor-pointer">
                        <div
                            id="preview-container-1"
                            style="border-style: dashed"
                            class="relative flex items-center justify-center h-20 border-2 border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500"
                        >
                            <img
                            id="preview-img-1"
                            src=""
                            alt="Your upload"
                            class="absolute inset-0 hidden object-contain w-full h-full rounded-lg"
                            />
                            <div id="placeholder-1" class="flex flex-col items-center justify-center">
                            <svg class="w-6 h-6 mb-2 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="text-xs font-semibold text-gray-500">Click to upload</p>
                            </div>
                        </div>
                        <input id="dropzone-file-1" type="file" accept="image/*" class="hidden" />
                        </label>
                    </div>
                    <!-- Upload 2 -->
                    <div class="w-36">
                        <label for="dropzone-file-2" class="block cursor-pointer">
                        <div
                            id="preview-container-2"
                            style="border-style: dashed"
                            class="relative flex items-center justify-center h-20 border-2 border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500"
                        >
                            <img
                            id="preview-img-2"
                            src=""
                            alt="Your upload"
                            class="absolute inset-0 hidden object-contain w-full h-full rounded-lg"
                            />
                            <div id="placeholder-2" class="flex flex-col items-center justify-center">
                            <svg class="w-6 h-6 mb-2 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="text-xs font-semibold text-gray-500">Click to upload</p>
                            </div>
                        </div>
                        <input id="dropzone-file-2" type="file" accept="image/*" class="hidden" />
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    @include('reports.edit-report')
    @stack('scripts')
    
<style>
    /* Custom CSS to hide the spinners */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="number"] {
        -moz-appearance: textfield;
        appearance: textfield;
    }

</style>

@endsection

@push('scripts')
    <script>
        // Get the data from the controller
        let tableData = null;
        // Image upload and preview handling
        document.addEventListener('DOMContentLoaded', function() {
            // Setup for upload 1
            const dropzoneFile1 = document.getElementById('dropzone-file-1');
            const previewImg1 = document.getElementById('preview-img-1');
            const placeholder1 = document.getElementById('placeholder-1');
            const previewContainer1 = document.getElementById('preview-container-1');
            // Setup for upload 2
            const dropzoneFile2 = document.getElementById('dropzone-file-2');
            const previewImg2 = document.getElementById('preview-img-2');
            const placeholder2 = document.getElementById('placeholder-2');
            const previewContainer2 = document.getElementById('preview-container-2');
            // Handle file upload for container 1
            dropzoneFile1.addEventListener('change', function(e) {
                handleFileUpload(e, previewImg1, placeholder1, previewContainer1);
            });
            // Handle file upload for container 2
            dropzoneFile2.addEventListener('change', function(e) {
                handleFileUpload(e, previewImg2, placeholder2, previewContainer2);
            });
            // Function to handle file upload
            function handleFileUpload(e, previewImg, placeholder, previewContainer) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(event) {
                        // Show preview image
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('hidden');
                        // Hide placeholder
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    // If no file is selected (like when a user cancels the file dialog)
                    resetImagePreview(previewImg, placeholder, previewContainer);
                }
            }
            // Function to reset image preview
            function resetImagePreview(previewImg, placeholder, previewContainer) {
                // Clear the image source
                previewImg.src = '';
                previewImg.classList.add('hidden');
                // Show the placeholder
                placeholder.classList.remove('hidden');
                // Reset container styles if needed
                previewContainer.style.borderStyle = 'dashed';
            }
            // Function to manually reset the image state if needed
            window.resetImageContainer = function(containerNum) {
                if (containerNum === 1) {
                    resetImagePreview(previewImg1, placeholder1, previewContainer1);
                    dropzoneFile1.value = '';
                } else if (containerNum === 2) {
                    resetImagePreview(previewImg2, placeholder2, previewContainer2);
                    dropzoneFile2.value = '';
                }
            };
        });
        // expands the text area in VII. BULLETIN UPDATES
        function autoExpand(field) {
            field.style.height = 'auto';
            field.style.height = field.scrollHeight + 'px';
        }
        // print report paper
        function printReportPaper() {
            // Update the remarks input's attribute so the printed HTML contains the current value
            const remarkInputs = document.querySelectorAll('.remarks-input');
            remarkInputs.forEach(function(input) {
                input.setAttribute('value', input.value);
            });
            // Update the table5 to have their values in the printed HTML
            const table5Inputs = document.querySelectorAll('#table5 input[type="number"], #table5 input[type="text"]');
            table5Inputs.forEach(function(input) {
                input.setAttribute('value', input.value);
            });
            // Update the textarea in table3 to include its values in the printed HTML
            const textareas = document.querySelectorAll('.textarea-input');
            textareas.forEach(function(ta) {
                ta.textContent = ta.value;
            });

            // Function to convert image to data URL
            const imageToDataURL = (img) => {
                if (!img || img.classList.contains('hidden') || !img.src) {
                    return null;
                }
                try {
                    // Create a canvas element
                    const canvas = document.createElement('canvas');
                    canvas.width = img.naturalWidth || 300;
                    canvas.height = img.naturalHeight || 200;
                    // Draw the image onto the canvas
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    // Return the data URL
                    return canvas.toDataURL('image/png');
                } catch (error) {
                    console.error("Error converting image to data URL:", error);
                    return null;
                }
            };
            // Get references to the image elements
            const img1 = document.getElementById('preview-img-1');
            const img2 = document.getElementById('preview-img-2');
            const container1 = document.getElementById('preview-container-1').parentElement;
            const container2 = document.getElementById('preview-container-2').parentElement;
            // Store original values
            const originalDisplay1 = container1.style.display;
            const originalDisplay2 = container2.style.display;
            const originalSrc1 = img1.src;
            const originalSrc2 = img2.src;
            // Convert images to data URLs if they exist
            const dataURL1 = imageToDataURL(img1);
            const dataURL2 = imageToDataURL(img2);
            // Update image sources to data URLs or hide containers
            if (dataURL1) {
                img1.src = dataURL1;
                img1.classList.remove('hidden');
            } else {
                container1.style.display = 'none';
            }
            if (dataURL2) {
                img2.src = dataURL2;
                img2.classList.remove('hidden');
            } else {
                container2.style.display = 'none';
            }
            // Get the content for printing (with data URLs for images)
            const content = document.getElementById('reportPaperID').outerHTML;
            
            // Restore original values
            container1.style.display = originalDisplay1;
            container2.style.display = originalDisplay2;
            img1.src = originalSrc1;
            img2.src = originalSrc2;
            
            // Open a new print window
            const printWindow = window.open('', '', 'height=800,width=1000');
            printWindow.document.write(`
            <html>
                <head>
                    <title>Print Report</title>
                    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
                    <style>
                        @media print {
                            @page {
                                size: auto;
                                margin: 0;
                            }
                            body {
                                display: flex !important;
                                justify-content: center !important;
                                align-items: center !important;
                                margin-right: 50px;
                                margin-left: 15px;
                                margin-top: 20px;
                                margin-bottom: 0px;
                                padding: 0;
                            }
                            #ctrlNumber {
                                width: 180px;
                                height: 100px;
                            }
                            #reportPaperID {
                                box-shadow: none !important;
                                width: 100% !important;
                                margin: 0 auto !important;
                                padding: 0 !important;
                                box-sizing: border-box !important;
                            }                      
                            td, th {
                                word-wrap: break-word;
                                overflow-wrap: break-word;
                                text-align: center !important;
                            }
                            input[type="text"], 
                            input[type="number"], 
                            textarea {
                                width: 100% !important;
                                box-sizing: border-box;
                            }
                            #table1, #table2, #table3, #table4, #table5 {
                                width: 100% !important;
                            }
                            #table2, #table3, #table4, #table5 {
                                margin-left: 20px;
                            }
                            #table-header {
                                text-align: center;
                            }
                            #pupLogo{
                                width: 100px;
                                height: 100px;
                            }
                            #approvalSection {
                                padding-top: 150px;
                            }
                            .font-semibold {
                                text-align: left;
                                padding-left: 10px;
                            }
                            .cells {
                                padding-left: 10px;
                            }
                            #preview-img-1:not(.hidden),
                            #preview-img-2:not(.hidden) {
                                display: block !important;
                                width: 100%;
                                height: auto;
                                max-height: 80px;
                                object-fit: contain;
                            }
                            #preview-container-1,
                            #preview-container-2 {
                                border: none !important;
                                background: white !important;
                            }
                        }
                    </style>
                </head>
                <body>${content}</body>
            </html>
            `);
            
            // Ensure the styles are fully loaded before printing
            printWindow.document.close();
            printWindow.onload = () => {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            };
        }
        function openEditFormModal() { 
            // Get the values from the form
            let modal = document.getElementById("editFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.remove("hidden");
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalContent.classList.remove("scale-95");
                modalContent.classList.add("scale-100");
            }, 10);
        }
        function closeEditFormModal() { 
            let modal = document.getElementById("editFormModal");
            let modalContent = modal.querySelector("div.relative");

            modal.classList.add("opacity-0");
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
            }, 300); 
        }
        function saveEdit(e) {
            e.preventDefault();  
            const title = document.getElementById('title');
            const physicianName = document.getElementById('physicianName');
            const position = document.getElementById('position');
            const unitDepartment = document.getElementById('unitDepartment');
            const fromDurationDate = document.getElementById('fromDurationDate');
            const toDurationDate = document.getElementById('toDurationDate');
            const submissionDate = document.getElementById('submissionDate');
            const campusPhysician = document.getElementById('campusPhysician');
            const campusNurse = document.getElementById('campusNurse');
            const controlNumber = document.getElementById('controlNumber');
            const controlNumberDate = document.getElementById('controlNumberDate');
            const controlNumberRevision = document.getElementById('controlNumberRevision');
            
            // Outputs
            const titleOut = document.getElementById('titleOut');
            const physicianNameOut = document.getElementById('physicianNameOut');
            const positionOut = document.getElementById('positionOut');
            const unitDepartmentOut = document.getElementById('unitDepartmentOut');
            const fromDurationDateOut = document.getElementById('fromDurationDateOut');
            const toDurationDateOut = document.getElementById('toDurationDateOut');
            const submissionDateOut = document.getElementById('submissionDateOut');
            const campusPhysicianOut = document.getElementById('campusPhysicianOut');
            const campusNurseOut = document.getElementById('campusNurseOut');
            const controlNumberOut = document.getElementById('controlNumberOut');
            const controlNumberDateOut = document.getElementById('controlNumberDateOut');
            const controlNumberRevisionOut = document.getElementById('controlNumberRevisionOut');

            // Check if any field is empty
            if (!title.value || !physicianName.value || !position.value || !unitDepartment.value || !fromDurationDate.value 
            || !toDurationDate.value || !submissionDate.value || !campusPhysician.value 
            || !campusNurse.value || !controlNumber.value || !controlNumberDate.value || !controlNumberRevision.value) {
                alert('Please fill out all fields.');
                return; // Prevent form submission
            }

            // Helper: extract date parts
            const getDateParts = (dateStr) => {
            const dateObj = new Date(dateStr.split('T')[0]);
                return {
                    month: dateObj.toLocaleString('en-US', { month: 'long' }),
                    day: dateObj.getDate(),
                    year: dateObj.getFullYear()
                };
            };

            // Helper: format the date range based on common parts
            const formatDateRange = (fromStr, toStr) => {
            const from = getDateParts(fromStr);
            const to = getDateParts(toStr);
                
                // If both dates are exactly the same, return one date.
                if (from.day === to.day && from.month === to.month && from.year === to.year) {
                    return `${from.month} ${from.day}, ${from.year}`;
                }
                // If month and year are the same, only display the day for the "to" date.
                if (from.month === to.month && from.year === to.year) {
                    return `${from.month} ${from.day} to ${to.day}, ${from.year}`;
                }
                // If the year is the same but months differ.
                if (from.year === to.year) {
                    return `${from.month} ${from.day} to ${to.month} ${to.day}, ${from.year}`;
                }
                // If years differ, return full dates for both.
                return `${from.month} ${from.day}, ${from.year} to ${to.month} ${to.day}, ${to.year}`;
            };

            // Update the values in the report paper
            titleOut.innerHTML = title.value;
            physicianNameOut.innerHTML = physicianName.value;
            positionOut.innerHTML = position.value;
            unitDepartmentOut.innerHTML = unitDepartment.value;
            fromDurationDateOut.innerHTML = formatDateRange(fromDurationDate.value, toDurationDate.value);
            // Clear the separate "to" output if not needed.
            toDurationDateOut.innerHTML = "";
            submissionDateOut.innerHTML = new Date(submissionDate.value.split('T')[0])
                .toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            campusPhysicianOut.innerHTML = campusPhysician.value;
            campusNurseOut.innerHTML = campusNurse.value;
            controlNumberOut.innerHTML = controlNumber.value;
            controlNumberDateOut.innerHTML = new Date(controlNumberDate.value.split('T')[0])
                .toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            controlNumberRevisionOut.innerHTML = controlNumberRevision.value;


            // AJAX request to send data to the controller
            const data = {
                title: title.value,
                physicianName: physicianName.value,
                position: position.value,
                unitDepartment: unitDepartment.value,
                fromDurationDate: fromDurationDate.value,
                toDurationDate: toDurationDate.value,
                submissionDate: submissionDate.value,
                campusPhysician: campusPhysician.value,
                campusNurse: campusNurse.value,
                controlNumber: controlNumber.value,
                controlNumberDate: controlNumberDate.value,
                controlNumberRevision: controlNumberRevision.value,
                category: document.getElementById('category') ? document.getElementById('category').value : '', // if available in the form
                _token: '{{ csrf_token() }}' // Include CSRF token if needed
            };

            fetch('{{ route("reports.filterAndCountReports") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                console.log('Success:', response);
                const services = response.services || response; 
                tableData = services;

                document.getElementById('tableData').value = JSON.stringify(tableData);
                
                // Handle success response
                // Update table inputs based on the returned services array.
                // populates the table1
                const table1Rows = document.querySelectorAll('#table1 tbody tr');
                services.forEach((service, serviceIndex) => {
                    if (table1Rows[serviceIndex]) {
                    const pEls = table1Rows[serviceIndex].querySelectorAll('td.cells p');
                    service.data.forEach((count, i) => {
                        if (pEls[i]) pEls[i].innerText = count;
                    });
                    }
                });
                // populates the table2
                const table2Rows = document.querySelectorAll('#table2 tbody tr');
                services.forEach((service, serviceIndex) => {
                    if (serviceIndex >= 86) {
                        const idx2 = serviceIndex - 86;
                        const row = table2Rows[idx2];
                        if (!row) return;    

                        const pEls = row.querySelectorAll('td.cells p');
                        service.data.forEach((count, i) => {
                        if (pEls[i]) {
                            pEls[i].innerText = count;
                        }
                        });
                    }
                });

                if (response.totals) {
                    // Update the total cells
                    document.getElementById('studentTotalOut').innerText = response.totals.students;
                    document.getElementById('facultyTotalOut').innerText = response.totals.faculty;
                    document.getElementById('adminTotalOut').innerText = response.totals.administrative;
                    document.getElementById('dependentTotalOut').innerText = response.totals.dependents;
                    document.getElementById('visitorTotalOut').innerText = response.totals.visitors;
                    document.getElementById('totalOut').innerText = response.totals.overall;
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });

            closeEditFormModal();
        }
        function setupAutoSum() {
            const groups = ['female', 'male', 'pwd', 'seniorCitizen'];
            const categories = ['Student', 'Faculty', 'Admin', 'Dependent', 'Visitor'];

            function updateSums() {
            let columnSums = {
                Student: 0, Faculty: 0, Admin: 0, Dependent: 0, Visitor: 0, Total: 0
            };

            groups.forEach(group => {
                let rowSum = 0;

                categories.forEach(category => {
                const input = document.getElementById(`${group}${category}Out`);
                const value = parseFloat(input.value) || 0;
                rowSum += value;
                columnSums[category] += value;
                });

                document.getElementById(`${group}TotalOut`).value = rowSum;
                columnSums['Total'] += rowSum;
            });

            // Update column totals
            categories.forEach(category => {
                document.getElementById(`total${category}Out`).textContent = columnSums[category];
            });
            document.getElementById('totalTotalOut').textContent = columnSums['Total'];
            }

            // Attach input listeners
            groups.forEach(group => {
            categories.forEach(category => {
                const input = document.getElementById(`${group}${category}Out`);
                input.addEventListener('input', updateSums);
            });
            });
        }
        function initImagePreview(inputId, imgId, placeholderId, containerId) {
            const inputEl = document.getElementById(inputId);
            const imgEl = document.getElementById(imgId);
            const placeholderEl = document.getElementById(placeholderId);
            const containerEl = document.getElementById(containerId);

            if (!inputEl || !imgEl || !placeholderEl || !containerEl) return;

            inputEl.addEventListener('change', () => {
                const file = inputEl.files[0];
                if (!file) return;

                const url = URL.createObjectURL(file);
                imgEl.src = url;
                imgEl.classList.remove('hidden');
                placeholderEl.classList.add('hidden');

                // Remove dashed border
                containerEl.classList.remove(
                'border-2',
                'border-gray-300',
                'dark:border-gray-600',
                'dark:hover:border-gray-500'
                );
                containerEl.style.borderStyle = 'none';

                // Change background to white
                containerEl.classList.remove(
                'bg-gray-50',
                'hover:bg-gray-100',
                'dark:bg-gray-700',
                'dark:hover:bg-gray-800'
                );
                containerEl.classList.add('bg-white');

                imgEl.onload = () => URL.revokeObjectURL(url);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            initImagePreview('dropzone-file-1', 'preview-img-1', 'placeholder-1', 'preview-container-1');
            initImagePreview('dropzone-file-2', 'preview-img-2', 'placeholder-2', 'preview-container-2');
        });
        document.addEventListener('DOMContentLoaded', setupAutoSum);

        document.getElementById('exportForm').addEventListener('submit', function(event) {
            
            const remarksInputs = document.querySelectorAll('.remarks-input');
            
            remarksInputs.forEach((input, index) => {
                if (tableData[index] && Array.isArray(tableData[index].data)) {
                    // Update the remark field; assuming the last element of data is for remarks
                    tableData[index].data[tableData[index].data.length - 1] = input.value;
                }
            });

            const textareaValue = document.querySelector('.textarea-input')?.value || '';
            document.getElementById('bulletinUpdates').value = textareaValue;
            
            // Update the hidden input with the updated services array
            document.getElementById('tableData').value = JSON.stringify(tableData);
        
            // Also update other hidden inputs with the values from the report paper
            document.getElementById('exportTitle').value = document.getElementById('titleOut').innerText;
            document.getElementById('exportFromDate').value = document.getElementById('fromDurationDateOut').innerText;
            document.getElementById('exportToDate').value = document.getElementById('toDurationDateOut').innerText;
            document.getElementById('exportPhysicianName').value = document.getElementById('physicianNameOut').innerText;
            document.getElementById('exportPosition').value = document.getElementById('positionOut').innerText;
            document.getElementById('exportUnitDepartment').value = document.getElementById('unitDepartmentOut').innerText;
            document.getElementById('exportSubmissionDate').value = document.getElementById('submissionDateOut').innerText;
            document.getElementById('exportCampusPhysician').value = document.getElementById('campusPhysicianOut').innerText;
            document.getElementById('exportCampusNurse').value = document.getElementById('campusNurseOut').innerText;
            // Female data
            document.getElementById('exportFemaleStudent').value = document.getElementById('femaleStudentOut').value;
            document.getElementById('exportFemaleFaculty').value = document.getElementById('femaleFacultyOut').value;
            document.getElementById('exportFemaleAdmin').value = document.getElementById('femaleAdminOut').value;
            document.getElementById('exportFemaleDependent').value = document.getElementById('femaleDependentOut').value;
            document.getElementById('exportFemaleVisitor').value = document.getElementById('femaleVisitorOut').value;
            document.getElementById('exportFemaleTotal').value = document.getElementById('femaleTotalOut').value;
            // Male data
            document.getElementById('exportMaleStudent').value = document.getElementById('maleStudentOut').value;
            document.getElementById('exportMaleFaculty').value = document.getElementById('maleFacultyOut').value;
            document.getElementById('exportMaleAdmin').value = document.getElementById('maleAdminOut').value;
            document.getElementById('exportMaleDependent').value = document.getElementById('maleDependentOut').value;
            document.getElementById('exportMaleVisitor').value = document.getElementById('maleVisitorOut').value;
            document.getElementById('exportMaleTotal').value = document.getElementById('maleTotalOut').value;
            // PWD data
            document.getElementById('exportPWDStudent').value = document.getElementById('pwdStudentOut').value;
            document.getElementById('exportPWDFaculty').value = document.getElementById('pwdFacultyOut').value;
            document.getElementById('exportPWDAdmin').value = document.getElementById('pwdAdminOut').value;
            document.getElementById('exportPWDDependent').value = document.getElementById('pwdDependentOut').value;
            document.getElementById('exportPWDVisitor').value = document.getElementById('pwdVisitorOut').value;
            document.getElementById('exportPWDTotal').value = document.getElementById('pwdTotalOut').value;
            // Senior Citizen data
            document.getElementById('exportSeniorCitizenStudent').value = document.getElementById('seniorCitizenStudentOut').value;
            document.getElementById('exportSeniorCitizenFaculty').value = document.getElementById('seniorCitizenFacultyOut').value;
            document.getElementById('exportSeniorCitizenAdmin').value = document.getElementById('seniorCitizenAdminOut').value;
            document.getElementById('exportSeniorCitizenDependent').value = document.getElementById('seniorCitizenDependentOut').value;
            document.getElementById('exportSeniorCitizenVisitor').value = document.getElementById('seniorCitizenVisitorOut').value;
            document.getElementById('exportSeniorCitizenTotal').value = document.getElementById('seniorCitizenTotalOut').value;
            // Total row
            document.getElementById('exportTotalStudent').value = document.getElementById('totalStudentOut').textContent;
            document.getElementById('exportTotalFaculty').value = document.getElementById('totalFacultyOut').textContent;
            document.getElementById('exportTotalAdmin').value = document.getElementById('totalAdminOut').textContent;
            document.getElementById('exportTotalDependent').value = document.getElementById('totalDependentOut').textContent;
            document.getElementById('exportTotalVisitor').value = document.getElementById('totalVisitorOut').textContent;
            document.getElementById('exportTotalOverall').value = document.getElementById('totalTotalOut').textContent;
        });

    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Success!",
                text: `{!! session('success') !!}`,
                icon: "success"
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: "Error!",
                text: `{!! session('error') !!}`,
                icon: "error"
            });
        </script>
    @endif
@endpush