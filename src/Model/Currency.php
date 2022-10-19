<?php

namespace Javad\Binance;

class Currency extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'currency_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    protected $fillable = [
        'status',
        'title',
        'decimal_point',
        'reserve',
        'show_reserve',
        'symbol',
        'allow_receive',
        'allow_send',
        'slug',
        'xml_symbol',
        'min_reserve_alert',
        'send_wage',
        'send_percentage_wage',
        'receive_wage',
        'receive_percentage_wage',
        'send_wage_type',
        'receive_wage_type',
        'send_wage_left',
        'send_percentage_wage_left',
        'receive_wage_left',
        'receive_percentage_wage_left',
        'send_wage_type_left',
        'receive_wage_type_left',
        'wallet',
        'wallet_type',
        'wallet_length',
        'rate_source_address',
        'exchange_rate_type',
        'exchange_rate',
        'priority',
        'allow_withdraw',
        'is_crypto',
        'crypto_rate_base',
        'expire_after',
        'commission_withdraw_rate',
        'payment_gateway'
    ];

}
