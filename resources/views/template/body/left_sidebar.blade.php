<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">
    <!-- Brand Logo Light -->
    <a href="{{ route('dashboard') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{asset('Backend/assets/images/logo.png')}}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{asset('Backend/assets/images/logo-sm.png')}}" alt="small logo">
        </span>
    </a>
    <!-- Brand Logo Dark -->
    <a href="{{ route('dashboard') }}" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{asset('Backend/assets/images/logo.png')}}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{asset('Backend/assets/images/logo-sm.png')}}" alt="small logo">
        </span>
    </a>
    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>
    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>
    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        @php
        $id = Auth::user()->id;
        $adminData = App\Models\User::find($id);
        @endphp
        <div class="leftbar-user">
            <a href="{{ route('admin.profile') }}">
                <img src="{{ (!empty($adminData->photo))? url('upload/admin_images/'.$adminData->photo):url('upload/no_image.png') }}" alt="{{ __('Personal picture') }}" class="img-fluid avatar-sm rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">{{ trans($adminData->name) }} {{ trans($adminData->username) }}</span>
            </a>
        </div>
        <!--- Sidemenu -->
        <ul class="side-nav">


            <li class="side-nav-title"></li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#Permission" aria-expanded="false" aria-controls="Permission" class="side-nav-link">
                    <i class="uil-lock-access"></i>
                    <span>{{ __('Role') }} {{ __('and') }} {{ __('Permission') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="Permission">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('all.permission') }}">{{ __('Permission') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('all.roles') }}">{{ __('Role') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('all.roles.permission') }}">{{ __('Permission') }} {{ __('By') }} {{ __('Role') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-title"></li>
            @if(Auth::user()->can('traduction.menu'))
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#Translation" aria-expanded="false" aria-controls="Translation" class="side-nav-link">
                    <i class="uil-keyboard-hide"></i>
                    <span>{{ __('Translation') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="Translation">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('all.traduction') }}">{{ __('Translation') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#User" aria-expanded="false" aria-controls="User" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span>{{ __('User') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="User">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('all.user') }}">{{ __('User') }}</a>
                        </li>
                    </ul>
                </div>
            </li>

            @if(Auth::user()->can('Liste_Carrieres.menu'))
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#gouvernorat" aria-expanded="false" aria-controls="gouvernorat" class="side-nav-link">
                    <i class="uil-map-pin-alt"></i>
                    <span>{{ __('Gestion') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="gouvernorat">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="#">{{ __('Liste des Carrières') }}</a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            @endif

            @if(Auth::user()->can('sect.menu'))
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#carte" aria-expanded="false" aria-controls="carte" class="side-nav-link">
                    <i class="uil-sign-alt"></i>
                    <span>{{ __('Cartes') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="carte">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('carte') }}">{{ __('Carte Des Carrières') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->can('local.menu'))
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#localisation" aria-expanded="false" aria-controls="localisation" class="side-nav-link">
                    <i class="uil-map-pin"></i>
                    <span>{{ __('Localisation') }}</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="localisation">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="#">{{ __('Localisation') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            <!-- Help Box -->
            <!-- end Help Box -->
        </ul>
        <!--- End Sidemenu -->
        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ============ -->