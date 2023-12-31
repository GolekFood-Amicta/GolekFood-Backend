<header id="header" class="header fixed-top d-flex align-items-center bg-primary">

    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block text-light">GolekFood | Admin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn text-light"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto ">
        <ul class="d-flex align-items-center px-5">
            <li class="nav-item dropdown pe-3"></li>

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{ $urlAvatar }}" alt="Profile" class="rounded-circle border border-4">
                <span class="d-none d-md-block dropdown-toggle ps-2 text-light"></span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6> Hai ! {{ auth()->user()->name }} </h6>
                    <span> {{ auth()->user()->roles->name }} </span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                        <i class="bi bi-gear"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('change-password') }}">
                        <i class="bi bi-gear"></i>
                        <span>Change Password</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action=" {{ route('logout') }} " method="POST">
                        @csrf
                        <button  class="dropdown-item d-flex align-items-center" type="submit">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                </li>

            </ul><!-- End Profile Dropdown Items -->


            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>