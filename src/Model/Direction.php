<?php
namespace Javad\Binance;

class Direction extends Model
{
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'direction_id';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    protected $fillable = [
        'fk_send_currency_id',
        'fk_receive_currency_id',
        'direction_wage',
        'direction_rate',
        'show_send_wage',
        'show_receive_wage',
        'min_send_amount',
        'max_send_amount',
        'min_receive_amount',
        'max_receive_amount',
        'auto_send',
        'auto_receive',
        'auto_send_description',
        'manual_send_description',
        'expire_after',
        'commission_rate',
        'final_description',
        'payment_gateway',
        'direction_status',
        'slug'
    ];
}
