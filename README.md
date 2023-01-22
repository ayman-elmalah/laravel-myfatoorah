# Laravel Myfatoorah
laravel myfatoorah is a php package written by [Ayman Elmalah](https://github.com/ayman-elmalah) with laravel to handle myfatoorah functionality by making it's api more easy .

## Features
- Creating invoices
- Returning payments
- Check that payment is success or not
- Change the token on the fly
- Refund invoice

# Installation Guide
Composer installation
```
composer require ayman-elmalah/laravel-myfatoorah
```
The package is compatible with laravel ^6.0|^7.0|^8.0|^9.0 so you don't need to set providers or aliases for the package, we're using laravel auto discovery

## Configuration
To publish config run
```
php artisan vendor:publish --provider="AymanElmalah\MyFatoorah\MyFatoorahServiceProvider"
```
and modify the config file with your own information. File is located in `/config/myfatoorah.php`

## Get Your Credentials From Myfatoorah
- Go to [My fatoorah](https://www.myfatoorah.com/)
- You will get access token
- Go to your .env file and paste your credentials to be like this
- MYFATOORAH_MODE options ["test", "live", "live-sa"]

 ```
MYFATOORAH_MODE=test
MYFATOORAH_TOKEN=token
 ```
or you can add it using `setAccessToken($token?)->setMode($mode?)`

You are now ready to use the package

### Test cards page
You can get test cards from [DOCS](https://myfatoorah.readme.io/docs/test-cards)

### Usage examples

Create payment page
 ```
Route::get('payment', [\App\Http\Controllers\MyFatoorahController::class, 'index']);
Route::get('payment/callback', [\App\Http\Controllers\MyFatoorahController::class, 'callback']);
Route::get('payment/error', [\App\Http\Controllers\MyFatoorahController::class, 'error']);
 ```
At the controller, you can get the data from payment page at [DOCS](https://myfatoorah.readme.io/docs/send-payment)
 ```
 use AymanElmalah\MyFatoorah\Facades\MyFatoorah;
 
 public function index() {
      $data = [
        'CustomerName' => 'New user',
        'NotificationOption' => 'all',
        'MobileCountryCode' => '+966',
        'CustomerMobile' => '0000000000',
        'DisplayCurrencyIso' => 'SAR',
        'CustomerEmail' => 'test@test.test',
        'InvoiceValue' => '100',
        'Language' => 'en',
        'CallBackUrl' => 'https://yourdomain.test/callback',
        'ErrorUrl' => 'https://yourdomain.test/error',
    ];

// If you want to set the credentials and the mode manually.
//    $myfatoorah = MyFatoorah::setAccessToken($token)->setMode('test')->createInvoice($data);

// And this one if you need to access token from config
    $myfatoorah = MyFatoorah::createInvoice($data);

  // when you got a response from myFatoorah API, you can redirect the user to the myfatoorah portal 
  return response()->json($myfatoorah);
}
 ```
## Get callback to check if success payment
  ```
  public function callback(Request $request) {
     $myfatoorah = MyFatoorah::payment($request->paymentId);

     // It will check that payment is success or not
     // return response()->json($myfatoorah->isSuccess());
     
     // It will return payment response with all data
     return response()->json($myfatoorah->get());
  }
  ```

## Error page

  ```
  public function error(Request $request) {
     // Show error actions
     return response()->json(['status' => 'fail']);
  }
  ```

Refund payment
 ```
Route::get('reund', [\App\Http\Controllers\MyFatoorahController::class, 'refund']);
 ```
At the controller, you can get the data from payment page at [DOCS](https://myfatoorah.readme.io/docs/make-refund)
 ```
 use AymanElmalah\MyFatoorah\Facades\MyFatoorah;
 
 public function refund() {
      $data = [
        'KeyType' => 'invoiceid',     // can be invoiceId or PaymentId
        'Key' => '94272',             // key value like payment reference id, you can got it from the $request->paymentId in callback function 
        'RefundChargeOnCustomer' => false,
        'ServiceChargeOnCustomer' => false,
        'Amount' => 210,
        'Comment' => 'Refund',
        'AmountDeductedFromSupplier' => 0
      ];

    // If you want to set the credentials and the mode manually.
    // $myfatoorah = MyFatoorah::setAccessToken($token)->setMode('test')->refundInvoice($data);

    // And this one if you need to access token from config
    $myfatoorah = MyFatoorah::refundInvoice($data);

    // You can check the output
    return response()->json($myfatoorah);
}
 ```

## Authors

* **Ayman Elmalah** - *Initial work* - [ayman-elmalah](https://github.com/ayman-elmalah)

See also the list of [contributors](https://github.com/ayman-elmalah/laravel-myfatoorah/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* If yo have any questions, issues or PRs feel free to contact me.
