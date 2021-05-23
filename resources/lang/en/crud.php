<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'image' => 'Image',
            'status' => 'Status',
            'validity' => 'Validity',
        ],
    ],

    'deliveries' => [
        'name' => 'Deliveries',
        'index_title' => 'Deliveries List',
        'new_title' => 'New Delivery',
        'create_title' => 'Create Delivery',
        'edit_title' => 'Edit Delivery',
        'show_title' => 'Show Delivery',
        'inputs' => [
            'quantity' => 'Quantity',
            'production_id' => 'Production',
            'order_id' => 'Order',
        ],
    ],

    'measure_units' => [
        'name' => 'Measure Units',
        'index_title' => 'MeasureUnits List',
        'new_title' => 'New Measure unit',
        'create_title' => 'Create MeasureUnit',
        'edit_title' => 'Edit MeasureUnit',
        'show_title' => 'Show MeasureUnit',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'finished_product_stocks' => [
        'name' => 'Finished Product Stocks',
        'index_title' => 'FinishedProductStocks List',
        'new_title' => 'New Finished product stock',
        'create_title' => 'Create FinishedProductStock',
        'edit_title' => 'Edit FinishedProductStock',
        'show_title' => 'Show FinishedProductStock',
        'inputs' => [
            'quantity' => 'Quantity',
            'validity' => 'Validity',
            'finished_product_stock_id' => 'Finished Product Stock',
            'production_id' => 'Production',
        ],
    ],

    'productions' => [
        'name' => 'Productions',
        'index_title' => 'Productions List',
        'new_title' => 'New Production',
        'create_title' => 'Create Production',
        'edit_title' => 'Edit Production',
        'show_title' => 'Show Production',
        'inputs' => [
            'name' => 'Name',
            'date' => 'Date',
            'validity' => 'Validity',
            'image' => 'Image',
            'quanity' => 'Quanity',
            'price' => 'Price',
            'order_id' => 'Order Id',
            'product_id' => 'Product',
        ],
    ],

    'raw_product_stocks' => [
        'name' => 'Raw Product Stocks',
        'index_title' => 'RawProductStocks List',
        'new_title' => 'New Raw product stock',
        'create_title' => 'Create RawProductStock',
        'edit_title' => 'Edit RawProductStock',
        'show_title' => 'Show RawProductStock',
        'inputs' => [
            'quantity' => 'Quantity',
            'expiry_date' => 'Expiry Date',
            'ingredient_id' => 'Ingredient',
        ],
    ],

    'ingredients' => [
        'name' => 'Ingredients',
        'index_title' => 'Ingredients List',
        'new_title' => 'New Ingredient',
        'create_title' => 'Create Ingredient',
        'edit_title' => 'Edit Ingredient',
        'show_title' => 'Show Ingredient',
        'inputs' => [
            'name' => 'Name',
            'image' => 'Image',
            'measure_unit_id' => 'Measure Unit',
        ],
    ],

    'companies' => [
        'name' => 'Companies',
        'index_title' => 'Companies List',
        'new_title' => 'New Company',
        'create_title' => 'Create Company',
        'edit_title' => 'Edit Company',
        'show_title' => 'Show Company',
        'inputs' => [
            'name' => 'Name',
            'status' => 'Status',
            'service_id' => 'Service',
        ],
    ],

    'services' => [
        'name' => 'Services',
        'index_title' => 'Services List',
        'new_title' => 'New Service',
        'create_title' => 'Create Service',
        'edit_title' => 'Edit Service',
        'show_title' => 'Show Service',
        'inputs' => [
            'name' => 'Name',
            'status' => 'Status',
        ],
    ],

    'packages' => [
        'name' => 'Packages',
        'index_title' => 'Packages List',
        'new_title' => 'New Package',
        'create_title' => 'Create Package',
        'edit_title' => 'Edit Package',
        'show_title' => 'Show Package',
        'inputs' => [
            'name' => 'Name',
            'price' => 'Price',
            'validity' => 'Validity',
            'status' => 'Status',
            'description' => 'Description',
            'company_id' => 'Company',
            'type' => 'Type',
        ],
    ],

    'categories' => [
        'name' => 'Categories',
        'index_title' => 'Categories List',
        'new_title' => 'New Category',
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'show_title' => 'Show Category',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'products' => [
        'name' => 'Products',
        'index_title' => 'Products List',
        'new_title' => 'New Product',
        'create_title' => 'Create Product',
        'edit_title' => 'Edit Product',
        'show_title' => 'Show Product',
        'inputs' => [
            'name' => 'Name',
            'price' => 'Price',
            'validity' => 'Validity',
            'package_id' => 'Package',
            'category_id' => 'Category',
            'barcode' => 'Barcode',
        ],
    ],

    'orders' => [
        'name' => 'Orders',
        'index_title' => 'Orders List',
        'new_title' => 'New Order',
        'create_title' => 'Create Order',
        'edit_title' => 'Edit Order',
        'show_title' => 'Show Order',
        'inputs' => [
            'number' => 'Number',
            'delivery_date' => 'Delivery Date',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'product_id' => 'Product',
            'user_id' => 'User',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
