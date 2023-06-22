<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralFunctions;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    use GeneralFunctions;

    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository
    ) {
        //
    }

    public function index($subcategory): View
    {
        $data = [];
        $category = $this->categoryRepository->getById($subcategory, true);
        if(! $category) abort(500, "Something went Wrong !");

        foreach($category->product as $product) {
            if (! empty($product->serviceCategory->name)) {
                $data[$product->serviceCategory->name][] = $product;
            }
        }

        return view('cart', [
            'category' => $category,
            'pageData' => $data,
            'service_type' => array_keys($data),
            'cartArray' => getCartItems(),
        ]);
    }

    function checkout(Request $request): View|RedirectResponse
    {
        $this->setCartCheckpoint($request);

        $total = $totalSaving = 0;
        if (empty($request->category) || empty($request->subcategory)) {
            return redirect(route('homepage'));
        }

        $cartItems = getCartItems();
        $cat = $this->categoryRepository->getById($request->category, true);
        $subCat = $this->categoryRepository->getById($request->subcategory, true);
        if ((! $cat)|| (! $subCat)) {
            return redirect(route('homepage'));
        }
        $cartItemsArr = $this->filterCartItemsBasedOnCat($cartItems, $cat, $subCat);
        $cartItems = $this->productRepository->getAll()->whereIn('id', array_keys($cartItemsArr))->get();
        foreach ($cartItems as $cartItem) {
            $total = ($total + ($cartItem->price * $cartItemsArr[$cartItem->id]));
            $totalSaving = ($totalSaving + ($cartItem->strike_price * $cartItemsArr[$cartItem->id]));
        }

        return view('checkout', [
            'cartArray' => $cartItems,
            'cartItemsArr' => $cartItemsArr,
            'total' => $total,
            'totalSaving' => $totalSaving,
        ]);

    }

    public function addAddress (Request $request): JsonResponse
    {
        $request->validate([
            'house_no' => 'required|min:1|max:25',
            'landmark' => 'required|min:3|max:50',
            'address' => 'required|min:10|max:100',
        ]);

        $user = auth()->user();
        $update = $user->update([
            'house_no' => trim($request->house_no),
            'landmark' => trim($request->landmark),
            'address' => trim($request->address)
        ]);

        if ($update) {
            return response()->json([
                'success' => $update,
            ]);
        }
    }

    public function fetchAddress() {
        $address = auth()->user()->address;
        $house_no = auth()->user()->house_no;
        $landmark = auth()->user()->landmark;

        return response()->json([
            'success' => ($address) ? true : false,
            'house_no' => $house_no,
            'landmark' => $landmark,
            'address' => $address,
        ]);
    }

    public function placeOrder(Request $request) {

        if (empty($request->payment_method) || empty($request->category) || empty($request->subCategory) || empty($request->cartArray)) {
            return redirect(route('homepage'));
        }

        $total = $productCount = 0;
        $orderNumber = $this->generateOrderNumber();
        $categoryId = $request->category;
        $subCategoryId = $request->subCategory;
        $cartItems = json_decode(base64_decode($request->cartArray), true);
        $cartDetail = array_filter(getCartItems());

        $orderData = [
            'order_id' => $orderNumber,
            'user_id' => auth()->user()->id,
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            'name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
            'email' => auth()->user()->email,
            'address' => auth()->user()->address,
            'house_no' => auth()->user()->house_no,
            'landmark' => auth()->user()->landmark,
            'address_local' => auth()->user()->address,
            'pincode' => '000000',
            'country_id' => auth()->user()->country_id,
            'state_id' => auth()->user()->state_id,
            'city_id' => auth()->user()->city_id,
            'area_id' => auth()->user()->area_id,
            'address_lat' => auth()->user()->address_lat,
            'address_long' => auth()->user()->address_long,
            'product_count' => $productCount,
            'isPromoApplied' => 'No',
            'discount' => 0,
            'tax' => 0,
            'subtotal' => $total,
            'total' => $total,
            'is_warranty_order' => 'No',
            'payment_type' => 'Cash',
            'payment_status' => 'Pending',
            'order_status' => 'Pending',
        ];

        try {
            $orderId = Order::create($orderData);

            foreach ($cartItems as $cart) {

                $quantity = (int)$cartDetail[$cart['id']];
                for ($i = 0; $i < $quantity; $i++) {
                    $cartDetailData = [
                        'order' => $orderNumber,
                        'order_id' => $orderId->id,
                        'product_id' => $cart['id'],
                        'category_id' => $cart['category_id'],
                        'sub_category_id' => $cart['sub_category_id'],
                        'service_category_id' => $cart['service_category_id'],
                        'product_title' => $cart['title'],
                        'product_description' => $cart['description'],
                        'product_strike_price' => $cart['strike_price'],
                        'product_price' => $cart['price'],
                        'product_commission' => $cart['commission'],
                        'warranty' => $cart['warranty'],
                        'product_approx_duration' => $cart['approx_duration'],
                        'order_status' => "Pending",
                        'order_note' => '',
                    ];

                    $productCount++;
                    $total = $total + $cart['price'];
                    OrderDetail::create($cartDetailData);
                }

            }

            Order::where(['id' => $orderId->id, 'order_id' => $orderNumber])->update([
                'product_count' => $productCount,
                'subtotal' => $total,
                'total' => $total,
            ]);

            $past = time() - 3600;
            foreach ($_COOKIE as $key => $value) {
                if ($key == "cartTotal" || $key == "cartDetail") {
                    setcookie($key, $value, $past, '/');
                }
            }

            return redirect(route('orderPlaced', [
                'success' => 'Order Placed',
            ]));

        } catch (\Throwable $th) {
            return redirect(route('orderFailed', [
                'error' => 'Something went wrong',
                'message' => $th->getMessage()
            ]));
        }
    }

    public function orderPlaced()
    {
        return view('order_placed');
    }

    public function orderFailed()
    {
        return view('order_failed');
    }
}
