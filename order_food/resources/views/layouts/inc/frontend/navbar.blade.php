<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e75b1e;">
    <a class="navbar-brand" href="{{ url('/') }}" style="font-family:nautilus_pompiliusregular">salsbil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('collections') }}">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('gallery') }}">Gallery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('note') }}">Blog</a>
            </li>

            <li class="nav-item" >
                <a class="nav-link" href="{{ url('cart') }}">
                    <i class="fa fa-shopping-cart"></i> Cart (<livewire:frontend.cart.cart-count />)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('wishlist') }}">
                    <i class="fa fa-heart"></i> Wishlist (<livewire:frontend.wishlist-count />)
                </a>
            </li>
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @else
               <!-- ... (previous code) ... -->

               <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user"></i> {{ Auth::user()->name }}

                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {{-- <li><a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a></li> --}}
                    <li><a class="dropdown-item" href="{{ url('/orders') }}"><i class="fa fa-list"></i> My Orders</a></li>
                    {{-- <li><a class="dropdown-item" href="#"><i class="fa fa-heart"></i> My Wishlist</a></li> --}}
                    <li><a class="dropdown-item" href="{{ url('/cart') }}"><i class="fa fa-shopping-cart"></i> My Cart</a>
                    </li>
                    <li>
                        {{-- <a class="dropdown-item" href="#">
                            Logout
                        </a> --}}
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>

<!-- ... (remaining code) ... -->

            @endguest
        </ul>
    </div>
</nav>
