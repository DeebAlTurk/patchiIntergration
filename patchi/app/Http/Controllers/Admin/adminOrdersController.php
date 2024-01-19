<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Mail\OrderAdded;
use App\Mail\OrderUpdated;
use App\Models\City;
use App\Models\Orders;
use App\Models\SmsCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Facades\Voyager;

class adminOrdersController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{
    public function export(){
        return Excel::download(new OrdersExport(), "orders".now()->timestamp.".xlsx");
    }
    public function update(Request $request, $id)
    {
        $order = Orders::find($id);
        $newOrderStatus=$request->get('status');
        switch ($newOrderStatus) {
            case 'Delivered':
                $request->validate([
                    'sms_code'=>'required|string|min:6|max:6'
                ]);
                if (!$order->validateSMS($request->get('sms_code'))){
                   return back()->with($this->alertError('SMS Code not Valid'));
                }
                break;
            case 'Shipped':
                if ($order->status!=='Shipped' && $order->status!=='Delivered'){
                    $smsOrder=SmsCode::createViaOrder($order);
                    $smsOrder?->sendSmsMessage();
                }else{
                    return back()->with($this->alertError('Please Update Status to Delivered and enter the Verification Code'));
                }
                break;
            default:
                break;
        }


        //Check Status for Status Logging
        $orderStatusNew = $order->orderStatuses()->where('status', $request->get('status'))->get();
        if ($orderStatusNew->isEmpty()) {
            $orderStatusNew = $order->orderStatuses()->create([
                'status' => $request->get('status'),
                'supervisor' => $order->supervisor
            ]);
            \Mail::to($order->city->primary_email)->cc($order->city->getCCEmails())->send(new OrderUpdated(route('voyager.orders.show', $order)));
        }
        return parent::update($request, $id);
    }

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

        $city = City::find($request->get('city_id'));
        $data->orderStatuses()->create(
            [
                'order_id' => $data->id,
                'status' => "Open",
                'supervisor' => 'unassigned'
            ]
        );
        \Mail::to($city->primary_email)->cc($city->getCCEmails())->send(new OrderAdded(route('voyager.orders.show', $data)));

        event(new BreadDataAdded($dataType, $data));

        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            } else {
                $redirect = redirect()->back();
            }

            return $redirect->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }


}
