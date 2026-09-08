<header class="site-header">
    <a class="brand" href="{{ route('home') }}" aria-label="Luxury Homes home"><img src="/images/luxury-homes/logo-primary.png" alt="Luxury Homes"></a>
    <button class="menu-toggle" aria-expanded="false" aria-controls="primary-nav"><span></span><span></span></button>
    <nav id="primary-nav" aria-label="Primary navigation">
        <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
        <a class="{{ request()->routeIs('works', 'project') ? 'active' : '' }}" href="{{ route('works') }}">Our Works</a>
        <a class="{{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
        <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
        <button class="search" aria-label="Search"></button>
    </nav>
</header>
