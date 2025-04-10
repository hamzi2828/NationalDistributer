<?php

    return [

        'system_access' => [
            'admin',
            'parteners',
        ],

        'account_heads' => [
            'inventory' => [
                'id'   => 7,
                'type' => 'debit'
            ],
        ],

        'vendors'   => 9,
        'customers' => 17,

        'cash_sale' => [
            'cash_in_hand'          => 19,
            'sales'                 => 1,
            'cost_of_products_sold' => 16,
            'inventory'             => 7,
        ],

        'credit_sale' => [
            'sales'                 => 1,
            'cost_of_products_sold' => 16,
            'inventory'             => 7,
        ],

        'stock' => [
            'inventory' => 7,
        ],

        'account_receivable'   => 17,
        'account_payable'      => 9,
        'expenses'             => 4,
        'cash_in_hand'         => 19,
        'direct_cost'          => 15,
        'tax'                  => 8,
        'account_type_in'      => [
            5,
            1
        ],
        'adjustment_increase'  => 198,
        'damage_loss'          => 199,
        'adjustment_decrease'  => 200,
        'cash_balances'        => 2,
        'banks'                => 3,
        'discount_on_invoices' => 396,
        'income'               => 274,
        'current_assets'       => 211,
        'non_current_assets'   => 212,
        'liabilities'          => 107,
        'capital'              => 105,
        'cost_of_logistics'    => 475
    ];
