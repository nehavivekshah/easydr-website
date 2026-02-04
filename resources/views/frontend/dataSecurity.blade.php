@extends('frontend.layout')

@section('content')
    <!-- main-area -->
    <main>
        <!-- breadcrumb-area -->
        {{-- Keeping the existing breadcrumb style as it uses background images effectively --}}
        <section class="breadcrumb-area d-flex align-items-center"
            style="background-image:url(public/assets/frontend/img/testimonial/test-bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title mb-30">
                                <h2 class="breadcrumb-main-title">Data Security & Your Privacy</h2> {{-- Added class for
                                potential styling --}}
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent justify-content-center p-0"> {{-- Make breadcrumb
                                    transparent --}}
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Security</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->

        <!-- Data Security Content Area -->
        <section class="data-security-area py-5"> {{-- Use py-5 for vertical padding --}}
            <div class="container">

                {{-- Introduction Section (Jumbotron Style) --}}
                <div class="intro-section bg-light p-4 p-md-5 rounded text-center mb-5 shadow-sm">
                    <!-- <img src="public/assets/frontend/img/icons/security-shield.png" alt="Security Shield" class="mb-4" style="max-height: 90px;"> -->
                    <h3 class="display-5 font-weight-bold mb-3">Your Trust is Our Foundation</h3> {{-- More impactful
                    heading --}}
                    <p class="lead mb-4">
                        At <strong>Easy Doctor</strong>, safeguarding your personal and health information is paramount. We
                        are deeply committed to maintaining robust security protocols to protect your data whenever you
                        interact with our services.
                    </p>
                    <p class="mb-0">Explore the measures we take to ensure the confidentiality and integrity of your
                        valuable information.</p>
                </div>

                {{-- Key Security Measures Section --}}
                <div class="key-measures-section mb-5">
                    <h4 class="text-center mb-5 section-heading-bs4">How We Protect Your Data</h4>
                    <div class="row">

                        {{-- Measure 1: Encryption --}}
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow-sm border-light security-measure-card">
                                <div class="card-body">
                                    <div class="media">
                                        <span class="me-3 fa-2x text-primary"><i class="fas fa-lock"></i></span>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 card-title-enhanced">Data Encryption</h5>
                                            <p class="mb-0 card-text-enhanced">Sensitive data (personal details,
                                                prescriptions, payments) is encrypted during transmission using
                                                industry-standard SSL/TLS. Stored sensitive information is also encrypted
                                                within our secure databases.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Measure 2: Secure Infrastructure --}}
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow-sm border-light security-measure-card">
                                <div class="card-body">
                                    <div class="media">
                                        <span class="me-3 fa-2x text-success"><i class="fas fa-server"></i></span>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 card-title-enhanced">Secure Servers & Network</h5>
                                            <p class="mb-0 card-text-enhanced">Our platform resides in secure data centers
                                                with strict physical/network security, firewalls, intrusion detection, and
                                                continuous monitoring to prevent unauthorized access.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Measure 3: Access Control --}}
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow-sm border-light security-measure-card">
                                <div class="card-body">
                                    <div class="media">
                                        <span class="me-3 fa-2x text-warning"><i class="fas fa-user-shield"></i></span>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 card-title-enhanced">Strict Access Controls</h5>
                                            <p class="mb-0 card-text-enhanced">Access to your personal and health data is
                                                limited to authorized personnel (e.g., pharmacists) on a strict need-to-know
                                                basis, enforced through role-based controls and regular permission reviews.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Measure 4: Payment Security --}}
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow-sm border-light security-measure-card">
                                <div class="card-body">
                                    <div class="media">
                                        <span class="me-3 fa-2x text-info"><i class="fas fa-credit-card"></i></span>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 card-title-enhanced">Payment Security (PCI-DSS)</h5>
                                            <p class="mb-0 card-text-enhanced">We use reputable, PCI-DSS compliant payment
                                                processors. Your full payment card details are not stored on our servers
                                                post-transaction, ensuring enhanced financial data safety.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Measure 5: Regular Audits & Updates --}}
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow-sm border-light security-measure-card">
                                <div class="card-body">
                                    <div class="media">
                                        <span class="me-3 fa-2x text-danger"><i class="fas fa-sync-alt"></i></span>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 card-title-enhanced">Continuous Monitoring & Updates</h5>
                                            <p class="mb-0 card-text-enhanced">We actively monitor our systems for
                                                vulnerabilities, applying security patches and updates promptly to maintain
                                                a robust defense against emerging threats.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Measure 6: Privacy Policy & Compliance --}}
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow-sm border-light security-measure-card">
                                <div class="card-body">
                                    <div class="media">
                                        <span class="me-3 fa-2x text-secondary"><i class="fas fa-file-contract"></i></span>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 card-title-enhanced">Privacy Practices & Compliance</h5>
                                            <p class="mb-2 card-text-enhanced">Our data handling aligns with our transparent
                                                <a href="#">Privacy Policy</a>, adhering to data protection principles. {{--
                                                Optional: <br> We are compliant with relevant regulations like [HIPAA/GDPR,
                                                etc.]. --}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- User Responsibility Section --}}
                <div class="user-responsibility-section mb-5">
                    <h4 class="text-center mb-4 section-heading-bs4">Your Role in Staying Secure</h4>
                    <div class="alert alert-warning d-flex align-items-center shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle fa-2x me-3 text-dark"></i>
                        <div>
                            <h5 class="alert-heading">Help Us Keep Your Account Safe!</h5>
                            While we implement strong safeguards, your actions are also crucial:
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Use a strong, unique password. Never share your login details.</li>
                                <li>Log out when using shared computers.</li>
                                <li>Beware of phishing attempts asking for your credentials.</li>
                                <li>Report any suspicious account activity to us immediately.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="contact-section text-center pt-4 border-top">
                    <h5 class="mb-3">Have Questions?</h5>
                    <p class="mb-1">For more details, please review our comprehensive <a href="#">Privacy Policy</a>.</p>
                    <p>If you have specific concerns about data security, feel free to <a href="#">Contact Our Support
                            Team</a>.</p>
                </div>

            </div> {{-- End Container --}}
        </section>
        <!-- Data Security Content Area End -->

    </main>
    <!-- main-area-end -->
@endsection

@push('styles')
    {{-- Custom CSS to complement Bootstrap 4.5 --}}
    <style>
        .breadcrumb-main-title {
            /* Adjust breadcrumb title size if needed */
            font-size: 2.8rem;
            /* Example size */
            color: #fff;
            /* Ensure text is visible on image */
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            /* Add shadow for readability */
        }

        .breadcrumb {
            /* Ensure breadcrumb links are visible */
            font-size: 1rem;
        }

        .breadcrumb-item a {
            color: #f0f0f0;
        }

        .breadcrumb-item a:hover {
            color: #fff;
        }

        .breadcrumb-item.active {
            color: #fff;
            font-weight: 500;
        }

        .section-heading-bs4 {
            /* Specific heading style */
            font-weight: 600;
            color: #333;
            margin-bottom: 2.5rem !important;
            /* Ensure spacing */
        }

        .security-measure-card .card-body {
            padding: 1.25rem;
            /* Standard BS4 card padding */
        }

        .security-measure-card .media .fa-2x {
            /* Icon size */
            line-height: 1.2;
            /* Adjust vertical alignment if needed */
        }

        .card-title-enhanced {
            font-weight: 600;
            font-size: 1.1rem;
            /* Slightly larger title */
            color: #2a2a2a;
        }

        .card-text-enhanced {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.6;
        }

        .user-responsibility-section .alert {
            border-left: 5px solid #ffc107;
            /* Accent border */
        }

        .user-responsibility-section .alert-heading {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .user-responsibility-section ul li {
            margin-bottom: 0.4rem;
        }

        .border-light {
            border-color: #f1f1f1 !important;
            /* Softer border */
        }
    </style>
@endpush

@push('scripts')
    {{-- Add custom JS if needed --}}
    <script>
        // Any specific JS for this page can go here
    </script>
@endpush