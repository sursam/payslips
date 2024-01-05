<div class="profile-dashboard-left">
    <a href="{{ route('customer.dashboard') }}" class="w3-bar-item w3-button tablink profile-dashboard-left-button {{ authSidebar(['customer.dashboard']) }}" >
        <span><i class="fa fa-user" aria-hidden="true"></i></span> My Profile
    </a>
    <a href="{{ route('customer.wish.list') }}" class="w3-bar-item w3-button tablink profile-dashboard-left-button {{ authSidebar(['customer.wish.list']) }}" >
        <span><i class="fa-solid fa-heart" aria-hidden="true"></i></span> My Wishlist
    </a>
    <a href="{{ route('customer.cart') }}" class="w3-bar-item w3-button tablink profile-dashboard-left-button {{ authSidebar(['customer.cart']) }}">
        <span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> My Cart
    </a>
    <a href="{{ route('customer.order.list') }}" class="w3-bar-item w3-button tablink profile-dashboard-left-button {{ authSidebar(['customer.order.*']) }}">
        <span><i class="fa fa-shopping-bag" aria-hidden="true"></i></span> My Orders
    </a>
    <a href="{{ route('customer.address.book.index') }}" class="w3-bar-item w3-button tablink profile-dashboard-left-button {{ authSidebar(['customer.address.book.*']) }}">
        <span><i class="fa fa-map-marker" aria-hidden="true"></i></span> Address Book
    </a>
    <a href="{{ route('customer.settings') }}" class="w3-bar-item w3-button tablink profile-dashboard-left-button {{ authSidebar(['customer.settings']) }}">
        <span><i class="fa fa-cog" aria-hidden="true"></i></span> Settings
    </a>
    <a class="w3-bar-item w3-button tablink profile-dashboard-left-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
        <span><i class="fa fa-sign-out" aria-hidden="true"></i></span> Logout
    </a>
</div>
<form id="form-logout" class="d-none" action="{{ route('logout') }}" method="POST">
    @csrf
</form>
