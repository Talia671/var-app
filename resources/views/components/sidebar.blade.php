<div class="sidebar-ui">
    <div class="sidebar-header">
        <div class="sidebar-brand-icon">
            V
        </div>
        <div class="sidebar-brand-text">
            VAR APP
        </div>
    </div>

    <div class="sidebar-content">
        {{-- DASHBOARD (ALL) --}}
        <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="sidebar-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            </div>
            <span class="sidebar-label">Dashboard</span>
        </a>

        {{-- SUPER ADMIN MENU --}}
        @if(Auth::user()->role === 'super_admin')
            <div class="sidebar-section-title">Super Admin</div>
            
            <a href="{{ route('super-admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
                <span class="sidebar-label">Dashboard SA</span>
            </a>
            <a href="{{ route('super-admin.tokens.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.tokens.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                </div>
                <span class="sidebar-label">Token Management</span>
            </a>
            <a href="{{ route('super-admin.users.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.users.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <span class="sidebar-label">User Management</span>
            </a>
            <a href="{{ route('super-admin.monitoring.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.monitoring.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>
                <span class="sidebar-label">System Monitoring</span>
            </a>

            <div class="sidebar-section-title">Master Data</div>
            
            <a href="{{ route('super-admin.companies.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.companies.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="9" y1="22" x2="9" y2="22.01"></line><line x1="15" y1="22" x2="15" y2="22.01"></line><line x1="9" y1="2" x2="9" y2="2.01"></line><line x1="15" y1="2" x2="15" y2="2.01"></line></svg>
                </div>
                <span class="sidebar-label">Companies</span>
            </a>
            <a href="{{ route('super-admin.zones.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.zones.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                </div>
                <span class="sidebar-label">Zones</span>
            </a>
            
            <a href="{{ route('super-admin.master.simper.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.master.simper.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">Master SIMPER</span>
            </a>
            <a href="{{ route('super-admin.master.ujsimp.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.master.ujsimp.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">Master UJSIMP</span>
            </a>
            <a href="{{ route('super-admin.master.checkup.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.master.checkup.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">Master Checkup</span>
            </a>
            <a href="{{ route('super-admin.master.ranmor.index') }}" class="sidebar-item {{ request()->routeIs('super-admin.master.ranmor.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">Master Ranmor</span>
            </a>
        @endif

        {{-- ADMIN MENU --}}
        @if(in_array(Auth::user()->role, ['admin', 'admin_perijinan']))
            <div class="sidebar-section-title">Admin Menu</div>
            
            <a href="{{ route('admin.tokens.index') }}" class="sidebar-item {{ request()->routeIs('admin.tokens.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                </div>
                <span class="sidebar-label">Tokens</span>
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <span class="sidebar-label">Activity Logs</span>
            </a>

            <div class="sidebar-section-title">Modules</div>

            <a href="{{ route('admin.simper.index') }}" class="sidebar-item {{ request()->routeIs('admin.simper.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">SIMPER ({{ $pendingVerificationCounts['simper'] ?? 0 }})</span>
            </a>
            <a href="{{ route('admin.ujsimp.index') }}" class="sidebar-item {{ request()->routeIs('admin.ujsimp.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">UJSIMP ({{ $pendingVerificationCounts['ujsimp'] ?? 0 }})</span>
            </a>
            <a href="{{ route('admin.checkup.index') }}" class="sidebar-item {{ request()->routeIs('admin.checkup.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                </div>
                <span class="sidebar-label">Checklist ({{ $pendingVerificationCounts['checkup'] ?? 0 }})</span>
            </a>
            <a href="{{ route('admin.ranmor.index') }}" class="sidebar-item {{ request()->routeIs('admin.ranmor.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                </div>
                <span class="sidebar-label">Ranmor ({{ $pendingVerificationCounts['ranmor'] ?? 0 }})</span>
            </a>
        @endif

        {{-- PETUGAS MENU --}}
        @if(in_array(Auth::user()->role, ['petugas', 'checker_lapangan']))
            <div class="sidebar-section-title">Petugas Menu</div>
            
            <a href="{{ route('petugas.simper.index') }}" class="sidebar-item {{ request()->routeIs('petugas.simper.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">SIMPER</span>
            </a>
            <a href="{{ route('petugas.ujsimp.index') }}" class="sidebar-item {{ request()->routeIs('petugas.ujsimp.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">UJSIMP</span>
            </a>
            <a href="{{ route('petugas.checkup.index') }}" class="sidebar-item {{ request()->routeIs('petugas.checkup.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                </div>
                <span class="sidebar-label">Checkup</span>
            </a>
            <a href="{{ route('petugas.ranmor.index') }}" class="sidebar-item {{ request()->routeIs('petugas.ranmor.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                </div>
                <span class="sidebar-label">Ranmor</span>
            </a>
        @endif

        {{-- AVP MENU --}}
        @if(Auth::user()->role === 'avp')
            <div class="sidebar-section-title">AVP Menu</div>
            
            <a href="{{ route('avp.approval-queue') }}" class="sidebar-item {{ request()->routeIs('avp.approval-queue*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">Approval Queue</span>
            </a>
            <a href="{{ route('avp.approval-history') }}" class="sidebar-item {{ request()->routeIs('avp.approval-history*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <span class="sidebar-label">Approval History</span>
            </a>
        @endif

        {{-- VIEWER MENU --}}
        @if(in_array(Auth::user()->role, ['viewer', 'user']))
            <div class="sidebar-section-title">Viewer Menu</div>
            
            <a href="{{ route('viewer.simper.index') }}" class="sidebar-item {{ request()->routeIs('viewer.simper.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">SIMPER</span>
            </a>
            <a href="{{ route('viewer.ujsimp.index') }}" class="sidebar-item {{ request()->routeIs('viewer.ujsimp.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="sidebar-label">UJSIMP</span>
            </a>
            <a href="{{ route('viewer.checkup.index') }}" class="sidebar-item {{ request()->routeIs('viewer.checkup.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                </div>
                <span class="sidebar-label">Checkup</span>
            </a>
            <a href="{{ route('viewer.ranmor.index') }}" class="sidebar-item {{ request()->routeIs('viewer.ranmor.*') ? 'active' : '' }}">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                </div>
                <span class="sidebar-label">Ranmor</span>
            </a>
        @endif
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">{{ Auth::user()->role }}</div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="sidebar-item" style="color: var(--color-danger);">
                <div class="sidebar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </div>
                <span class="sidebar-label">Logout</span>
            </a>
        </form>
    </div>
</div>