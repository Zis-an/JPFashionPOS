<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'JP Fashion',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>JP</b> Fashion',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-info',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-info',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-info',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-info elevation-4 custom-sidebar',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'md',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/admin',
    'logout_url' => '/admin/logout',
    'login_url' => '/admin/login',
    'register_url' => '/admin/register',
    'password_reset_url' => '/admin/password/reset',
    'password_email_url' => '/admin/password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
//        [
//            'type' => 'navbar-search',
//            'text' => 'search',
//            'topnav' => true,
//        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
//        [
//            'type' => 'sidebar-menu-search',
//            'text' => 'search',
//        ],
        [
            'text' => 'Dashboard',
            'url' => '/admin',
            'icon' => 'fas fa-tachometer-alt custom-icon-class',
//            'label' => 4,
            'label_color' => 'success',
        ],
        [
            'text' => 'Raw Material Master',
            'icon' => 'fas fa-industry custom-icon-class',
            'label_color' => 'success',
            'submenu' => [
                [
                    'text' => 'Raw Material',
                    'url' => 'admin/materials',
                    'icon' => 'fas fa-life-ring custom-icon-class',
                    'can' => ['materials.list', 'materials.create', 'materials.update', 'materials.delete', 'materials.restore',
                        'materials.force_delete', 'materials.trashed', 'materials.activity'],
                ],
                [
                    'text' => 'Raw Material Category',
                    'url' => 'admin/materialCategories',
                    'icon' => 'fas fa-mask custom-icon-class',
                    'can' => ['materialCategories.list', 'materialCategories.create', 'materialCategories.update', 'materialCategories.delete',
                        'materialCategories.restore', 'materialCategories.force_delete', 'materialCategories.trashed', 'materialCategories.activity'],
                ],
                [
                    'text' => 'Raw Material Purchase',
                    'url' => 'admin/rawMaterialPurchases',
                    'icon' => 'far fa-money-bill-alt custom-icon-class',
                    'can' => ['rawMaterialPurchases.list', 'rawMaterialPurchases.create', 'rawMaterialPurchases.update', 'rawMaterialPurchases.delete',
                        'rawMaterialPurchases.restore', 'rawMaterialPurchases.force_delete', 'rawMaterialPurchases.trashed', 'rawMaterialPurchases.activity'],
                ],
                [
                    'text' => 'Raw Material Stock',
                    'url' => 'admin/raw-material-stocks',
                    'icon' => 'fas fa-boxes custom-icon-class',
//                    'can' => ['rawMaterialStocks.list', 'rawMaterialStocks.create', 'rawMaterialStocks.update', 'rawMaterialStocks.delete',
//                        'rawMaterialStocks.restore', 'rawMaterialStocks.force_delete', 'rawMaterialStocks.trashed', 'rawMaterialStocks.activity'],
                    'can' => ['rawMaterialStocks.list', 'rawMaterialStocks.activity'],
                ],
            ]
        ],
        [
            'text' => 'Master',
            'icon' => 'fas fa-brain custom-icon-class',
            'label_color' => 'success',
            'submenu' => [
                [
                    'text' => 'Customer',
                    'url' => 'admin/customers',
                    'icon' => 'fas fa-smile custom-icon-class',
                    'can' => ['customers.list', 'customers.create', 'customers.update', 'customers.delete',
                        'customers.restore', 'customers.force_delete', 'customers.trashed', 'customers.activity'],
                ],
                [
                    'text' => 'Supplier',
                    'url' => 'admin/suppliers',
                    'icon' => 'fas fa-user-astronaut custom-icon-class',
                    'can' => ['suppliers.list', 'suppliers.create', 'suppliers.update', 'suppliers.delete',
                        'suppliers.restore', 'suppliers.force_delete', 'suppliers.trashed', 'suppliers.activity'],
                ],
                [
                    'text' => 'Payment Method',
                    'url' => 'admin/paymentMethods',
                    'icon' => 'fas fa-comment-dollar custom-icon-class',
                    'can' => ['paymentMethods.list', 'paymentMethods.create', 'paymentMethods.update', 'paymentMethods.delete',
                        'paymentMethods.restore', 'paymentMethods.force_delete', 'paymentMethods.trashed', 'paymentMethods.activity'],
                ],
                [
                    'text' => 'Warehouse',
                    'url' => 'admin/warehouses',
                    'icon' => 'fas fa-warehouse custom-icon-class',
                    'can' => ['warehouses.list', 'warehouses.create', 'warehouses.update', 'warehouses.delete',
                        'warehouses.restore', 'warehouses.force_delete', 'warehouses.trashed', 'warehouses.activity'],
                ],
                [
                    'text' => 'Employee',
                    'url' => 'admin/employees',
                    'icon' => 'fas fa-user-tag custom-icon-class',
                    'can' => ['employees.list', 'employees.create', 'employees.update', 'employees.delete',
                        'employees.restore', 'employees.force_delete', 'employees.trashed', 'employees.activity'],
                ],
                [
                    'text' => 'Department',
                    'url' => 'admin/departments',
                    'icon' => 'fas fa-building custom-icon-class',
                    'can' => ['departments.list', 'departments.create', 'departments.update', 'departments.delete',
                        'departments.restore', 'departments.force_delete', 'departments.trashed', 'departments.activity'],
                ],
                [
                    'text' => 'Showroom',
                    'url' => 'admin/showrooms',
                    'icon' => 'fas fa-store custom-icon-class',
                    'can' => ['showrooms.list', 'showrooms.create', 'showrooms.update', 'showrooms.delete',
                        'showrooms.restore', 'showrooms.force_delete', 'showrooms.trashed', 'showrooms.activity'],
                ],
                [
                    'text' => 'Unit',
                    'url' => 'admin/units',
                    'icon' => 'fas fa-balance-scale custom-icon-class',
                    'can' => ['units.list', 'units.create', 'units.update', 'units.delete', 'units.restore', 'units.force_delete', 'units.trashed', 'units.activity'],
                ],
                [
                    'text' => 'Color',
                    'url' => 'admin/colors',
                    'icon' => 'fas fa-fill-drip custom-icon-class',
                    'can' => ['colors.list', 'colors.create', 'colors.update', 'colors.delete', 'colors.restore', 'colors.force_delete', 'colors.trashed', 'colors.activity'],
                ],
                [
                    'text' => 'Brand',
                    'url' => 'admin/brands',
                    'icon' => 'fab fa-pied-piper-square custom-icon-class',
                    'can' => ['brands.list', 'brands.create', 'brands.update', 'brands.delete', 'brands.restore', 'brands.force_delete', 'brands.trashed', 'brands.activity'],
                ],
                [
                    'text' => 'Size',
                    'url' => 'admin/sizes',
                    'icon' => 'fas fa-ruler custom-icon-class',
                    'can' => ['sizes.list', 'sizes.create', 'sizes.update', 'sizes.delete', 'sizes.restore', 'sizes.force_delete', 'sizes.trashed', 'sizes.activity'],
                ],
            ],
        ],
        [
            'text' => 'Product Master',
            'icon' => 'fas fa-tshirt custom-icon-class',
            'label_color' => 'success',
            'submenu' => [
                [
                    'text' => 'Product Category',
                    'url' => 'admin/productCategories',
                    'icon' => 'fas fa-clipboard-list custom-icon-class',
                    'can' => ['productCategories.list', 'productCategories.create', 'productCategories.update', 'productCategories.delete', 'productCategories.restore',
                        'productCategories.force_delete', 'productCategories.trashed', 'productCategories.activity'],
                ],
                [
                    'text' => 'Product',
                    'url' => 'admin/products',
                    'icon' => 'fas fa-gift custom-icon-class',
                    'can' => ['products.list', 'products.create', 'products.update', 'products.delete', 'products.restore',
                        'products.force_delete', 'products.trashed', 'products.activity'],
                ],
                [
                    'text' => 'Production House',
                    'url' => 'admin/houses',
                    'icon' => 'fas fa-gift custom-icon-class',
                    'can' => ['houses.list', 'houses.create', 'houses.update', 'houses.delete', 'houses.restore',
                        'houses.force_delete', 'houses.trashed', 'houses.activity'],
                ],
                [
                    'text' => 'Product Stock',
                    'url' => 'admin/product-stocks',
                    'icon' => 'fas fa-luggage-cart custom-icon-class',
                    'can' => ['productStocks.list', 'productStocks.activity'],
                ],
            ],
        ],
        [
            'text' => 'Finance',
            'icon' => 'fab fa-bitcoin custom-icon-class',
            'label_color' => 'success',
            'submenu' => [
                [
                    'text' => 'Accounts',
                    'url' => 'admin/accounts',
                    'icon' => 'fas fa-tachometer-alt custom-icon-class',
                    'label_color' => 'success',
                    'can' => ['accounts.list','accounts.create','accounts.update','accounts.delete', 'accounts.restore',
                        'accounts.force_delete', 'accounts.trashed', 'accounts.activity'],
                ],
                [
                    'text' => 'Deposit',
                    'url' => 'admin/deposits',
                    'icon' => 'fas fa-coins custom-icon-class',
                    'label_color' => 'success',
                    'can' => ['deposits.list','deposits.create','deposits.update','deposits.delete', 'deposits.restore',
                        'deposits.force_delete', 'deposits.trashed', 'deposits.activity'],
                ],
                [
                    'text' => 'Withdraw',
                    'url' => 'admin/withdraws',
                    'icon' => 'far fa-money-bill-alt custom-icon-class',
                    'label_color' => 'success',
                    'can' => ['withdraws.list','withdraws.create','withdraws.update','withdraws.delete', 'withdraws.restore',
                        'withdraws.force_delete', 'withdraws.trashed', 'withdraws.activity'],
                ],
                [
                    'text' => 'Account Transfer',
                    'url' => 'admin/account-transfers',
                    'icon' => 'fas fa-hand-holding-usd custom-icon-class',
                    'label_color' => 'success',
                    'can' => ['account_transfers.list','account_transfers.create','account_transfers.update','account_transfers.delete', 'account_transfers.restore',
                        'account_transfers.force_delete', 'account_transfers.trashed', 'account_transfers.activity'],
                ],
                [
                    'text' => 'Expense',
                    'icon' => 'fas fa-wallet custom-icon-class',
                    'submenu' => [
                        [
                            'text' => 'Expenses',
                            'url' => 'admin/expenses',
                            'icon' => 'fas fa-coins custom-icon-class',
                            'can' => ['expenses.list','expenses.create','expenses.update','expenses.delete',
                                'expenses.restore', 'expenses.force_delete', 'expenses.trashed', 'expenses.activity'],
                        ],
                        [
                            'text' => 'Expense Category',
                            'url' => 'admin/expense-categories',
                            'icon' => 'fas fa-money-check-alt custom-icon-class',
                            'can' => ['expense-categories.list','expense-categories.create','expense-categories.update',
                                'expense-categories.delete', 'expense-categories.restore',
                                'expense-categories.force_delete', 'expense-categories.trashed', 'expense-categories.activity'],
                        ]
                    ],
                ],
                [
                    'text' => 'Asset',
                    'icon' => 'fas fa-gem custom-icon-class',
                    'submenu' => [
                        [
                            'text' => 'Assets',
                            'url' => 'admin/assets',
                            'icon' => 'fas fa-funnel-dollar custom-icon-class',
                            'can' => ['assets.list','assets.create','assets.update','assets.delete',
                                'assets.restore', 'assets.force_delete', 'assets.trashed', 'assets.activity'],
                        ],
                        [
                            'text' => 'Asset Category',
                            'url' => 'admin/asset-categories',
                            'icon' => 'fas fa-cash-register custom-icon-class',
                            'can' => ['asset-categories.list','asset-categories.create','asset-categories.update',
                                'asset-categories.delete', 'asset-categories.restore',
                                'asset-categories.force_delete', 'asset-categories.trashed', 'asset-categories.activity'],
                        ]
                    ],
                ],
            ]
        ],
        [
            'text' => 'Production',
            'url' => 'admin/productions',
            'icon' => 'fas fa-passport custom-icon-class',
            'can' => ['productions.list', 'productions.create', 'productions.update', 'productions.delete', 'productions.restore',
                'productions.force_delete', 'productions.trashed', 'productions.activity'],
        ],
        [
            'text' => 'Currency',
            'url' => 'admin/currencies',
            'icon' => 'fas fa-lira-sign custom-icon-class',
            'can' => ['currencies.list', 'currencies.create', 'currencies.update', 'currencies.delete', 'currencies.restore',
                'currencies.force_delete', 'currencies.trashed', 'currencies.activity'],
        ],
        [
            'text' => 'Sell',
            'url' => 'admin/sells',
            'icon' => 'fas fa-clipboard-check custom-icon-class',
            'can' => ['sells.list', 'sells.create', 'sells.update', 'sells.delete', 'sells.restore',
                'sells.force_delete', 'sells.trashed', 'sells.activity'],
        ],
        [
            'text' => 'Report',
            'url' => 'admin/reports',
            'icon' => 'fas fa-scroll custom-icon-class',
            'submenu' => [
                [
                    'text' => 'Raw Material Stock',
                    'url' => 'admin/raw-material-stock-reports',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['rawMaterialStockReports.list','rawMaterialStockReports.view'],
                ],
                [
                    'text' => 'Product Stock',
                    'url' => 'admin/product-stock-reports',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['productStockReports.list','productStockReports.view'],
                ],
                [
                    'text' => 'Sell',
                    'url' => 'admin/sell-reports',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['sellReports.list','sellReports.view'],
                ],
                [
                    'text' => 'Asset',
                    'url' => 'admin/asset-reports',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['assetReports.list','assetReports.view'],
                ],
                [
                    'text' => 'Expense',
                    'url' => 'admin/expense-reports',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['expenseReports.list','expenseReports.view'],
                ],
                [
                    'text' => 'Raw Material Purchase',
                    'url' => 'admin/raw-material-purchase-reports',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['rawMaterialPurchaseReports.list','rawMaterialPurchaseReports.view'],
                ],
                [
                    'text' => 'Account Balance Sheet',
                    'url' => 'admin/account-balance-sheets',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['balanceSheets.list','balanceSheets.view'],
                ],
                [
                    'text' => 'Deposit Balance',
                    'url' => 'admin/deposit-balance-sheets',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['depositBalance.list','depositBalance.view'],
                ],
                [
                    'text' => 'Withdraw Balance',
                    'url' => 'admin/withdraw-balance-sheets',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['withdrawBalance.list','withdrawBalance.view'],
                ],
                [
                    'text' => 'Transfer Balance',
                    'url' => 'admin/transfer-balance-sheets',
                    'icon' => 'fas fa-scroll custom-icon-class',
                    'can' => ['transferBalance.list','transferBalance.view'],
                ],
                [
                    'text' => 'Sell Profit/Loss',
                    'url' => 'admin/sell-profit-loss',
                    'icon' => 'fas fa-pause-circle custom-icon-class',
                    'can' => ['sellProfitLoss.list','sellProfitLoss.view'],
                ],
            ],
        ],
        [
            'text' => 'Secure Area',
            'icon' => 'fas fa-shield-alt custom-icon-class',
            'icon_color' => 'danger',
            'submenu' => [
                [
                    'text' => 'Roles',
                    'url' => 'admin/roles',
                    'icon' => 'fas fa-id-badge custom-icon-class',
                    'can' => ['roles.list','roles.create','roles.update','roles.delete'],
                ],
                [
                    'text' => 'Permissions',
                    'url' => 'admin/permissions',
                    'icon' => 'fas fa-key custom-icon-class',
                    'can' => ['permissions.list','permissions.create','permissions.update','permissions.delete'],
                ],
                [
                    'text' => 'Admin',
                    'url' => 'admin/admins',
                    'icon' => 'fas fa-user-cog custom-icon-class',
                    'can' => ['admins.list', 'admins.create', 'admins.update', 'admins.delete',
                        'admins.restore', 'admins.force_delete', 'admins.trashed', 'admins.activity'],
                ],
                [
                    'text'    => 'Commands',
                    'icon'    => 'fas fa-terminal custom-icon-class',
                    'can'  => 'commands_manage',
                    'submenu' => [
                        [
                            'text' => 'Clear Cache',
                            'can'  => 'command_cache_clear',
                            'url' => 'command/clear-cache'
                        ],
                        [
                            'text' => 'Clear Config',
                            'can'  => 'command_config_clear',
                            'url' => 'command/clear-config'
                        ],
                        [
                            'text' => 'Clear Route',
                            'can'  => 'command_route_clear',
                            'url' => 'command/clear-route'
                        ],
                        [
                            'text' => 'Optimize',
                            'can'  => 'command_optimize',
                            'url' => 'command/optimize'
                        ],
                        [
                            'text' => 'Seed',
                            'can'  => 'command_seed',
                            'url' => 'command/seed'
                        ],
                        [
                            'text' => 'Migrate',
                            'can'  => 'command_migrate',
                            'url' => 'command/migrate'
                        ],
                        [
                            'text' => 'Fresh Migrate',
                            'can'  => 'command_migrate_fresh',
                            'url' => 'command/migrate-fresh'
                        ],
                        [
                            'text' => 'Fresh Migrate Seed',
                            'can'  => 'command_migrate_fresh_seed',
                            'url' => 'command/migrate-fresh-seed'
                        ],
                    ],
                ],

            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'datatablesPlugins' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/datatables-plugins/buttons/js/buttons.colVis.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'jquery-ui' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/jquery-ui/jquery-ui.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => env('APP_URL').'/vendor/jquery-ui/jquery-ui.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' =>env('APP_URL').'/vendor/summernote/summernote-bs5.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' =>env('APP_URL').'/vendor/summernote/summernote-bs5.min.css',
                ],
            ],
        ],
        'Custom' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'custom.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'custom.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true,
];
