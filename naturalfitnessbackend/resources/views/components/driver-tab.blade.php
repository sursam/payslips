<ul class="nav nav-tabs">
    <li class="nav-item">
        <h2 class="text-lg font-medium mr-auto">
            <a href="{{ ($currentTab != 'edit') ? route('admin.driver.edit', $userData->uuid) : '#' }}" class="nav-link {{ ($currentTab == 'edit') ? 'active' : '' }}">
                {{ __('Update Driver') }}
            </a>
        </h2>
    </li>
    <li class="nav-item">
        <h2 class="text-lg font-medium mr-auto">
            <a href="{{ ($currentTab != 'vehicle') ? route('admin.driver.vehicle', $userData->uuid) : '#' }}" class="nav-link {{ ($currentTab == 'vehicle') ? 'active' : '' }}">
                {{ __('Vehicle Informations') }}
            </a>
        </h2>
    </li>
    <li class="nav-item">
        <h2 class="text-lg font-medium mr-auto">
            <a href="{{ ($currentTab != 'wallet') ? route('admin.driver.wallet', $userData->uuid) : '#' }}" class="nav-link {{ ($currentTab == 'wallet') ? 'active' : '' }}">
                {{ __('Wallet Informations') }}
            </a>
        </h2>
    </li>
</ul>
