<?php
namespace App\Http\Traits;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

trait GeneralFunctions {
    /**
     * Filter the cart items stored in session and returns only value for perticulur category, subcategory
     * @param array $cartItems
     * @param Category $category
     * @param Category $subcategory
     * @return array
     */
    public function filterCartItemsBasedOnCat(array $cartItems, $category, $subCategory): array
    {
        $cartItems = array_filter($cartItems);
        $products = Product::select('id', 'title', 'category_id', 'sub_category_id', 'service_category_id','description', 'image', 'strike_price', 'price', 'warranty', 'approx_duration')->where([
            'category_id' => $category->id,
            'sub_category_id' => $subCategory->id,
            'status' => 'Active',
        ])
        ->whereIn('id', array_keys($cartItems))
        ->get();

        foreach($products as $product) {
            if (in_array($product->id, array_keys($cartItems))) {
                $returnArr[$product->id] = $cartItems[$product->id];
            }
        }

        return $returnArr;
    }

    /**
     * Set cart data in session for login back to cart purpose
     * @param Object $request
     * @return void
     */
    public function setCartCheckpoint(Request $request)
    {
        if (! auth()->user()) {
            Session::put('cartProcced', true);
            Session::put('cartLink', $request->getRequestUri());
        }
    }

    /**
     * Generates a random strong password
     * @param int $length
     * @return string
     */
    function generateStrongPassword($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+=-';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $password .= $characters[$randomIndex];
        }

        return $password;
    }

    /**
     * Generates a random number according to time
     * @return string
     */
    function generateOrderNumber() {
        // Get the current date and time
        $currentDateTime = date('YmdHis');
        // Generate a unique identifier (e.g., random number or unique ID from database)
        $uniqueIdentifier = time();
        // Concatenate the date/time and unique identifier to form the order number
        $orderNumber = $currentDateTime . $uniqueIdentifier;

        return $orderNumber;
    }
}
