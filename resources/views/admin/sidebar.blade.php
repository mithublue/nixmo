<div class="col-md-2">
    <div class="card">
        <div class="card-header">
            Sidebar
        </div>

        <div class="card-body">
            <ul class="nav" role="tablist">
                <li role="presentation">
                    <a href="{{ url('/admin') }}">
                        {{ do_action('before_admin_menu') }}
                        {{ \App\Includes\Classes\AdminMenu::instance()->generate_menu() }}
                        {{ do_action('after_admin_menu') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
