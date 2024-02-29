<?php

namespace App\Orchid\Screens\orders;

use App\Mail\OrderUpdated;
use App\Models\Orders;
use App\Models\SmsCode;
use App\Models\User;
use App\Orchid\Layouts\orders\OrderEditLeftLayout;
use App\Orchid\Layouts\orders\OrderEditRightLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class OrderEditScreen extends Screen
{

    /**
     * @var Orders
     */
    public $order;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Orders $order): iterable
    {

        return [
            'order' => $order
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->order->exists ? 'Edit Order' : 'Create Order';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Order Details';
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
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Print Order'))
                ->icon('printer'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm('this will delete the order permanently')
                ->method('remove')
                ->canSee($this->order->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([OrderEditLeftLayout::class, OrderEditRightLayout::class])
        ];
    }

    public function save(Orders $orders, Request $request)
    {
       $data= $request->validate(
            [
                'order.user_id' => 'required|exists:users,id',
                'order.policy_number' => 'required|string',
                'order.receiver_name' => 'required|string',
                "order.phone_number" => ['required', 'string', 'min:1', 'regex:/^(?:966|00966|0)(5\d(?:\s?\d){7})$/'],
                "order.district_id" => 'required|int|exists:districts,id',
                'order.delivery_providers_id' => 'required|int|exists:delivery_providers,id',
                "order.address" => 'required|string',
                "order.comment" => 'string',
                "order.preferred_delivery_date" => 'required|date|after:tomorrow',
                'order.status' => ['required', Rule::in([
                    'Open',
                    'Under process',
                    'Shipped',
                    'Delivered',
                    'Invalid',
                ])],
                'order.supervisor'=>'required|string',
                'order.proof_of_delivery'=>'nullable|file'

            ]
        );
       $data=$data['order'];
       $user=User::find($data['user_id']);
       $data=\Arr::add($data,'order_category_id',$user->order_category_id);

       if ($orders->isClean()){

           $newOrderStatus=$data['status'];
           switch ($newOrderStatus) {
               case 'Delivered':
                   $request->validate([
                       'sms_code'=>'required|string|min:6|max:6'
                   ]);
                   if (!$orders->validateSMS($request->input('sms_code'))){
                       Toast::warning('SMS Code not Valid');
                       return back();
                   }
                   break;
               case 'Shipped':
                   if ($orders->status!=='Shipped' && $orders->status!=='Delivered'){
                       $smsOrder=SmsCode::createViaOrder($orders);
                       if ($smsOrder?->sendSmsMessage()){
                           Alert::info('SMS Sent Successful');
                       }else{
                           Alert::error('Unable to Send SMS');
                       }

                   }else{
                       Toast::warning('Please Update Status to Delivered and enter the Verification Code');
                       return back();
                   }
                   break;
               default:
                   break;
           }

           $orders->fill($data);
           $orders->save();

           //Check Status for Status Logging
           $orderStatusNew = $orders->orderStatuses()->where('status', $data['status'])->get();

           if ($orderStatusNew->isEmpty()) {
               if ($data['status']!=='Open'){
                   $supervisor= $orders?->supervisor;
               }else{
                   $supervisor= $data['status'];
               }
               $orderStatusNew = $orders->orderStatuses()->create([
                   'status' => $data['status'],
                   'supervisor' => $supervisor
               ]);
               \Mail::to($orders->city->primary_email)->cc($orders->city->getCCEmails())->send(new OrderUpdated(route('platform.orders.edit', $orders)));

           }

       }

        Toast::info(__('Order was saved.'));

        return redirect()->route('platform.orders.list');
    }
    public function remove(Orders $orders){
        if ($orders->delete()){
            Toast::info(__('Order was deleted successfully.'));
            return redirect()->route('platform.orders.list');

        }
    }
}
