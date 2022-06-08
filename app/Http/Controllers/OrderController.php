<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Order;
use App\Models\Pallet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //looking about adding another order by accoridng to status as well as scheduled production
        $orders = Order::orderBy('machine', 'desc')->get();
        $previousMachine=null;
        return view('orders.index', compact('orders','previousMachine'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pallets = Pallet::all();
        return view('orders.create',compact('pallets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create($this->validateOrder($request));
        // redirecting to show a page
        return redirect(route('orders.index', compact('order')));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
       // $order->addProduced();
//        dd($order->production);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $pallets = Pallet::all();
        return view('orders.edit', compact('order','pallets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update($this->validateOrder($request));
        return redirect(route('orders.show', $order));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect(route('orders.index'));
    }

    /**
     * this function validates the attributes of Order
     * @param Request $request
     * @return array
     */
    public function validateOrder(Request $request): array
    {
        $validatedAtributes = $request->validate([
            'order_number'=>'required',
            'pallet_id'=>'required',
            'machine'=>'',
            'quantity_production'=>'required|integer|min:1',
            'start_date'=>'nullable|date|after:today',
            'site_location'=>'required',
            'production_instructions'=>'',
            'client_name' =>'required|string',
            'client_address' =>'required|string',
            'status'=>'string',
        ]);

        return $validatedAtributes;
    }


    /**
     * changes the status of the current order to in production
     */
    public static function startProduction(Order $order)
    {
        if($order->machine !== null && $order->start_date !== null && ($order->status==='Production Pending'||$order->status==='Paused')) {
            if ($order->status === 'Production Pending') {
                $order->update(['status' => 'In Production', 'start_time' => date('Y-m-d H:i:s')]);
            } else {
                $order->update(['status' => 'In Production']);
            }
            return redirect(route('orders.show', $order));
        } else {
            return redirect(route('orders.show', $order))->with('error', 'Cannot start production for this order at the moment please contact administration');
        }
    }

    /**
     * changes the status of the current order to done
     */
    public static function stopProduction(Order $order ,Machine $machine)
    {
        $order->update(['status' => 'Done', 'end_time' => date('Y-m-d H:i:s')]);
        return redirect(route('machines.show',compact('machine')));
    }

    /**
     * changes the status of the current order to done
     */
    public static function pauseProduction(Order $order)
    {
        $order->update(['status' => 'Paused']);
        return redirect(route('orders.show', $order));
    }

    /**
     * changes the status of the current order to Canceled
     */
    public static function cancelOrder(Order $order)
    {
        $order->update(['status' => 'Canceled']);
        return redirect(route('orders.show', $order));
    }


    /**
     * changes the "selected" status of the current order to selected
     */
    public static function selectOrder(Order $order)
    {
        $order->update(['selected' => 1]);
        return redirect(route('orders.show', $order));
    }

    /**
     * changes the "selected" status of the current order to unselected
     */
    public static function unselectOrder(Order $order)
    {
        $order->update(['selected' => 0]);
        return redirect(route('orders.index'));
    }

    /**
     * Show the form for editing only quantity produced
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function editquantity(Order $order)
    {
//        dd($order);

        return view('orders.editquantity', compact('order'));
    }

    /**
     * Update the quantity produced in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function updatequantity(Request $request, Order $order)
    {
        $validated = $request->validate([
            'add_quantity' => 'required|integer',
        ]);
        try
        {
            $order->update($validated);
            $order->addProduced();
            $order->stopProduced();
            return redirect(route('orders.show', $order));
        }
        catch (\Exception $exception)
        {
            return redirect(route('orders.editquantity', $order))->with('error', 'The value is higher than the quantity to be produced');

        }

    }


}
