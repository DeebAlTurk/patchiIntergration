<?php

declare(strict_types=1);

namespace App\Orchid\Screens\orders;

use App\Exports\OrdersExport;
use App\Models\Orders;
use App\Orchid\Layouts\orders\OrdersListLayout;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class OrderListScreen extends Screen
{

    public $orders;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'orders' => Orders::with(['user', 'order_category', 'district'])->filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Orders';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'All Orders';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Export'))
                ->icon('cloud-download')
                ->route('platform.orders.export')
                ->target('_blank')
                ->canSee(!$this->orders->isEmpty()),
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.orders.create'),
        ];

    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            OrdersListLayout::class
        ];
    }



}
