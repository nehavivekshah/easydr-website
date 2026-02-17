@extends('frontend.layout')

@section('content')
    <main>
        <section class="pt-100 pb-40">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        @include('frontend.inc.user_sidebar')
                    </div>

                    <!-- Content Area -->
                    <div class="col-lg-9">
                        <div class="dashboard_content">
                            <div class="dashboard_profile">
                                <h4 class="mb-0">Profile information</h4>
                                <a class="btn btn-sm btn-primary text-white px-3" href="/my-profile"><i
                                        class="fas fa-edit pe-1"></i> edit</a>
                                <ul>
                                    <li><span>Name:</span> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</li>
                                    <li><span>Mobile No.:</span> {{ Auth::user()->mobile }}, {{ Auth::user()->altr_mobile }}
                                    </li>
                                    <li><span>Email:</span> {{ Auth::user()->email }}</li>
                                    <li><span>DOB:</span>
                                        {{ Auth::user()->dob ? date('d M, Y', strtotime(Auth::user()->dob)) : 'Not Specified' }}
                                    </li>
                                    <li><span>Gender:</span>
                                        {{ Auth::user()->gender == 1 ? 'Male' : (Auth::user()->gender == 2 ? 'Female' : 'Other') ?? 'Not Specified' }}
                                    </li>
                                    @if(isset($userAddress))

                                        @if (Auth::user()->role == 5)
                                            <li><span>Aadhar No.:</span> <strong
                                                    class="{{ !empty($userAddress->adhar) ? 'text-success' : 'text-danger' }}">{{ $userAddress->adhar ?? 'Not Set' }}</strong>
                                            </li>
                                        @endif

                                        <li><span>Address:</span> {{ $userAddress->address ?? 'Not Set' }}</li>
                                        <li><span>City:</span> {{ $userAddress->city ?? 'Not Set' }}</li>
                                        <li><span>State:</span> {{ $userAddress->state ?? 'Not Set' }}</li>
                                        <li><span>Country:</span> {{ $userAddress->country ?? 'Not Set' }}</li>
                                        <li><span>Pincode:</span> {{ $userAddress->pincode ?? 'Not Set' }}</li>
                                    @endif
                                </ul>

                                @if(Auth::user()->role == 5 && isset($patient))
                                    <h5>Medical Information</h5>
                                    <ul>
                                        <li><span>Blood Group:</span>
                                            {{ !empty($patient->blood_group) ? $patient->blood_group : 'Not Set' }}</li>
                                        <li><span>Height:</span> {{ !empty($patient->height) ? $patient->height : 'Not Set' }}
                                        </li>
                                        <li><span>Weight:</span>
                                            {{ !empty($patient->weight) ? $patient->weight . ' Kg' : 'Not Set' }}</li>
                                        <li><span>Marital Status:</span>
                                            @if($patient->marital_status == 1) Single @elseif($patient->marital_status == 2)
                                            Married @elseif($patient->marital_status == 3) Divorced @else Not Set @endif
                                        </li>
                                        <li><span>Family Doctor:</span>
                                            @if($patient->familyDoctor)
                                                <strong class="text-success">{{ $patient->familyDoctor->first_name }}
                                                    {{ $patient->familyDoctor->last_name }}</strong>
                                            @else
                                                <strong class="text-danger">Not Set</strong>
                                            @endif
                                        </li>
                                        <li><span>Health Card No.:</span>
                                            @if(!empty($patient->health_card))
                                                <strong class="text-success">{{ $patient->health_card }}</strong>
                                            @else
                                                <strong class="text-danger">Not Set</strong>
                                            @endif
                                        </li>
                                        @if(!empty($patient->health_card_file))
                                            <li><span>Health Card File:</span>
                                                <a href="{{ asset('public/assets/images/healthCards/' . $patient->health_card_file) }}"
                                                    target="_blank" class="text-primary"><i class="fas fa-file-medical"></i> View
                                                    Card</a>
                                            </li>
                                        @endif
                                    </ul>
                                @elseif(Auth::user()->role == 4 && isset($doctorInfo))
                                    <h5>Professional Details</h5>
                                    <ul>
                                        <li><span>Specialist:</span> {{ $doctorInfo->specialist ?? 'Not Set' }}</li>
                                        <li><span>Experience:</span> {{ $doctorInfo->experience ?? 'Not Set' }}</li>
                                        <li><span>License:</span> {{ $doctorInfo->license ?? 'Not Set' }}</li>
                                        <li><span>Education:</span> {{ $doctorInfo->education ?? 'Not Set' }}</li>
                                        <li><span>Fees:</span> {{ $doctorInfo->fees ? '$' . $doctorInfo->fees : 'Not Set' }}
                                        </li>
                                        <li class="mt-2"><span>About:</span>
                                            {{ $doctorInfo->about ?? 'No About Available' }}
                                        </li>
                                    </ul>
                                    @if(isset($doctorAvailability))
                                        <!-- <h5 class="mt-3">Availability</h5>
                                            <ul>
                                                <li><span>Days:</span>
                                                    {{ implode(', ', json_decode($doctorAvailability->available_days) ?? []) }}</li>
                                                <li><span>Time:</span> {{ date('g:i A', strtotime($doctorAvailability->start_time)) }} -
                                                    {{ date('g:i A', strtotime($doctorAvailability->end_time)) }}
                                                </li>
                                                <li><span>Duration:</span> {{ $doctorAvailability->duration }} mins</li>
                                            </ul> -->
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection