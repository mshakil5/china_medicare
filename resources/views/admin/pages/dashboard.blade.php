@extends('admin.pages.master')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    
    <!-- Top Stats Row (Kept your active Visitors card) -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                Todays Visitors</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ $todaysUniqueVisitors }}">0</span>
                            </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-warning rounded fs-3">
                                <i class="bx bx-user-circle text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Topics / Quick Access Section -->
    <div class="row">
        <div class="col-12">
            <h4 class="card-title mb-4">Quick Menu</h4>
        </div>

        <!-- Packages -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.medical_package') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Packages</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Manage Packages</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                    <i class="ri-first-aid-kit-line text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Services -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.medical_services') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Services</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Manage Services</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-success rounded fs-3">
                                    <i class="ri-stethoscope-line text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Hospital -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.hospitals') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Hospitals</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Manage Hospitals</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info rounded fs-3">
                                    <i class="ri-hospital-line text-info"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Our Partners -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.partners') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Our Partners</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">View Partners</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-danger rounded fs-3">
                                    <i class="ri-hand-heart-line text-danger"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Blog -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.blogs') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Blog</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Manage Posts</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-warning rounded fs-3">
                                    <i class="ri-article-line text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Our Team -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.team') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Our Team</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">View Team</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-dark rounded fs-3">
                                    <i class="ri-team-line text-dark"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Why Choose Us -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.why_choose') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Why Choose Us</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Edit Details</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-secondary rounded fs-3">
                                    <i class="ri-shield-check-line text-secondary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Contact Messages -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('contacts.index') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Contact Messages</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">View Inbox</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info rounded fs-3">
                                    <i class="ri-mail-open-line text-info"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Admin -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('user.index') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Admin Users</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Manage Admins</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                    <i class="ri-admin-line text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Galleries -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.galleries') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Galleries</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Manage Media</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-success rounded fs-3">
                                    <i class="ri-image-line text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Settings -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <a href="{{ route('admin.companyDetails') }}" class="text-reset text-decoration-none">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Settings</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <span class="text-decoration-underline text-muted">Site Settings</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-dark rounded fs-3">
                                    <i class="ri-settings-3-line text-dark"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <!-- End Main Topics Row -->

</div>
@endsection

@section('script')

@endsection