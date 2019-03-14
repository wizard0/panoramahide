<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\OrderedSubscription;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderLegalUser;
use App\Models\OrderPhysUser;
use App\Models\Paysystem;
use App\Services\Toastr\Toastr;
use Chelout\Robokassa\Robokassa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lexty\Robokassa\Payment;
use Session;
use Redirect;

class PersonalController extends Controller
{
    public function __construct()
    {
        self::getRouteNameToView();
        View::share('bodyClass', 'body-personal');
    }

    public function orders(Request $request, $id = null)
    {
        $orders = $id ? Auth::user()->orders()->find($id) : Auth::user()->orders()->get();
        if (!$orders) {
            return redirect(route('personal.orders'));
        }
        return view('personal.'.__FUNCTION__, compact('orders', 'id'));
    }

    public function orderMake()
    {
        if (Session::has('cart') && Session::get('cart')->totalQty > 0) {
            return view('personal.orders.make');
        }
        return Redirect::back();
    }

    public function processOrder(Request $request)
    {
        // saving order data
        $order = new Order();
        $order->saveOrder($request->all());

        // cart clean up
        Session::forget('cart');
        return responseCommon()->success([
            'redirect' => route('order.complete', [
                'id' => $order->id,
            ]),
        ], 'Заказ успешно оформлен.');
    }

    public function cancelOrder($id)
    {
        $order = Auth::user()->orders()->find($id);
        if (!$order)
            return redirect(route('personal.orders'));
        $order->update(['status' => Order::STATUS_CANCELLED]);

        return redirect()->back();
    }

    public function completeOrder($id)
    {
        $order = Auth::user()->orders()->find($id);
        if (!$order)
            return redirect(route('personal.orders'));
        $payData = $order->collectPayData();

        return view('personal.orders.complete', compact(
            'order',
            'payData'
        ));
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect(route('personal'));
        } else {
            return view('personal.'.__FUNCTION__, $request->only('backTo'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('index'));
    }

    public function index(Request $request)
    {
        return view('personal.'.__FUNCTION__);
    }

    public function cart(Request $request)
    {
        $displayCheckout = true;
        $cart = Session::get('cart', null);
        if (!empty($cart->items)) {
            foreach ($cart->items as &$item) {
                $item->typeVers = Order::typeVers($item->version, $item->type);
            }
        }
        return view('personal.'.__FUNCTION__, compact('cart', 'displayCheckout'));
    }

    public function subscriptions(Request $request)
    {
        $subscriptions = Auth::user()->getSubscriptions($request->get('sort') ?? ['type' => 'asc']);
        $sort = self::getSortBy('type', $request, $subscriptions);

        return view('personal.'.__FUNCTION__, compact('subscriptions', 'sort'));
    }

    public function subscriptionsReleases($id)
    {
        $subscription = OrderedSubscription::find($id);
        $releases = $subscription->getReleases();
        return view('release.list', compact('releases'));
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'gender' => ['required'],
                'version' => ['required'],
            ], [], [
                'gender' => 'Пол',
                'version' => 'Версии журнала',
            ]);
            if ($validation->fails()) {
                return responseCommon()->validationMessages($validation);
            }
            $user->update($request->all());

            return responseCommon()->success([], 'Данные успешно обновлены.');
        }
        return view('personal.'.__FUNCTION__, ['user' => $user]);
    }

    public function magazines(Request $request)
    {
        // Получаем доступные пользователю выпуски
        $releases = Auth::user()->getReleases();
        // Группируем по журналам
        $journals = $releases->groupBy('journal_id');
        $journals = $journals->sortBy(function($releases) {
                                   return $releases->first()->name;
                               });
        return view('personal.'.__FUNCTION__, compact('journals'));
    }
    // Сортировка $data по столбцу $name в направлении $request->get('sort')
    public static function getSortBy($name, $request, &$data)
    {
        $sort = $request->get('sort') ?? [$name => 'asc'];
        if ($sort[$name] === 'asc') {
            $sort = ['sort' => [$name => 'desc']];
        } else {
            $sort = ['sort' => [$name => 'asc']];
        }
        return $sort;
    }

    public function changePassword(Request $request)
    {
        // Проверяем правильность ввода текущего пароля
        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->get('password')]))
            return responseCommon()->validationMessages(null, ['password' => 'Неверно указан текущий пароль']);

        // Валидация нового пароля
        $validation = Validator::make($request->all(), ['new_password' => 'required|string|min:6|confirmed']);
        if ($validation->fails()) {
            return responseCommon()->validationMessages($validation);
        } else {
            Auth::user()->password = bcrypt($request->get('new_password'));
            Auth::user()->save();

            return responseCommon()->success([], 'Пароль успешно изменён.');
        }
    }
}
