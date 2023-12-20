<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">Menu</li>

        <li>
            <a href="{{ route('dashboard') }}" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                <span >Dashboards</span>
            </a>
        </li>
        <li>
            <a href="{{ route('categories.all') }}" class="waves-effect">
                <i class="bx bx-copy-alt"></i>
                <span >Manage Categories</span>
            </a>
        </li>
        <li>
            <a href="{{ route('category.variations') }}" class="waves-effect">
                <i class="fas fa-solid fa-file"></i>
                <span >Manage Variations</span>
            </a>
        </li>
        <li>
            <a href="{{ route('variations.import') }}" class="waves-effect">
                <i class="fas fa-solid fa-file-import"></i>
                <span >Import Variations</span>
            </a>
        </li>
        <li>
            <a href="{{ route('category.backgrounds') }}" class="waves-effect">
                <i class="fas fa-solid fa-images"></i>
                <span >Manage Backgrounds</span>
            </a>
        </li>
        <li>
            <a href="{{ route('setting') }}" class="waves-effect">
                <i class="bx bx-cog"></i>
                <span >Setting</span>
            </a>
        </li>
    </ul>
</div>