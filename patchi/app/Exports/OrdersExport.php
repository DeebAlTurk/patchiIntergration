<?php

namespace App\Exports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
      return Orders::all();
    }

    public function headings(): array
    {
        return [
            'User',
            'user_email',
            'policy_number',
            'receiver_name',
            'phone_number',
            'city',
            'district',
            'address',
            'preferred_delivery_date',
            'order_category',
            'supervisor',
            'status',
            'proof_of_delivery',
        ];
    }


    public function map( $order): array
    {
        return [
            'User' => $order->user->username,
            'user_email' => $order->user->email,
            'policy_number' => $order->policy_number,
            'receiver_name' => $order->receiver_name,
            'phone_number' => $order->phone_number,
            'city' => $order->city->name,
            'district' => $order->district->name,
            'address' => $order->address,
            'preferred_delivery_date' => $order->preferred_delivery_date,
            'order_category' => $order->user->order_category->title,
            'supervisor' => $order->supervisor,
            'status' => $order->status,
            'proof_of_delivery' => $order->proof_of_delivery];
    }
}
