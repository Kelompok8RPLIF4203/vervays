<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('dashboard');
});

Route::prefix('/get')->group(function() {
    Route::get('/get_book_s_publisher_name/{bookId}', 'api\BookController@getPublisherName');
    Route::get('/get_ebook_cover_by_book_id/{bookId}', 'api\EbookCoverController@getEbookCoverByBookId');
    Route::get('/have_user_given_book_rating/{bookId}', 'api\ReviewController@haveUserGivenBookRating');
    Route::get('/payment_code', 'api\OrderController@getPaymentCodeFromMidtrans');
});

Route::middleware(['LoginAndSignUpMiddleware'])->group(function() {
    Route::get('/login', 'LoginController@index')
        ->name('login');

    Route::post('/login', 'LoginController@checkLogin');

    Route::get('/signup', 'SignUpController@index')
        ->name('signup');

    Route::post('/signup', 'SignUpController@signUp');

    Route::prefix('/account')->group(function() {
        Route::get('/begin_reset_password', 'LoginController@beginResetPassword');
        Route::post('/begin_reset_password', 'LoginController@resetPassword');
        Route::get('/reset/password/from/email', 'LoginController@changePassword');
        Route::get('/reset/password/sent', 'LoginController@resetPasswordSent')->name('reset-password-sent');
        Route::post('/reset/password/from/email', 'LoginController@updatePassword');
    });
});

Route::post('/logout', 'LogoutController@index');

Route::get('/account/verificate', 'SignUpController@verificateEmail');

Route::get('/search/book', 'api\SearchController@search');

Route::middleware(['IsLogin'])->group(function() {
    Route::get('/email/verification', 'SignUpController@emailVerification')
        ->middleware('IsTheEmailNotVerified')
        ->name('email-verification');

    Route::middleware(['HasTheEmailBeenVerified', 'CheckOrderStatus'])->group(function(){
        // UNTUK BUYER
        Route::get('/home', 'buyer\DashboardController@index')
            ->name('dashboard');

        Route::get('/search', 'buyer\SearchController@index')
            ->name('search');

        Route::post('/bepublisher', 'publisher\DashboardController@bePublisher');

        Route::get('/book/detail/{id}/{slug}', 'buyer\BookController@index');

        Route::get('/koleksi/buku', 'buyer\HaveController@bookCollection')->name('bookCollection');
        Route::get('/info/order/{orderId}/', 'buyer\OrderController@showOrderDetail');

        Route::get('/wishes', 'buyer\WishesController@index')->name('wishlist');
        Route::get('/cart', 'buyer\CartController@index')->name('cart');
        Route::get('/orders', 'buyer\OrderController@showList')->name('orders');
        Route::get('/read/sample/{bookId}', 'buyer\ReadController@readSample');
        Route::get('/read/book/{bookId}', 'buyer\ReadController@readBook')->middleware(['DoUserHaveTheBook']);
        Route::get('/give_rating/{bookId}', 'buyer\ReviewController@giveRating')->middleware(['HaveUserNotReviewedTheBook', 'IsBookNotDeleted']);
        Route::get('/info/publisher/{publisherId}/{slug}', 'buyer\PublisherController@index');
        Route::get('/account/setting', 'buyer\UserController@setting')->name('account-setting');

        Route::prefix('/get')->group(function() {
            Route::get('/user_wishlist', 'api\WishesController@getUserWishlist');
            Route::get('/get_user_role_for_ebook_info_page/{bookId}', 'api\BookController@getUserRoleForEbookInfoPage');
            Route::get('/get_user_cart', 'api\CartController@getUserCart');
            Route::get('/whether_the_transaction_is_pending_or_success/{bookId}', 'api\OrderController@whetherTheTransactionIsPendingOrSuccess');
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            Route::get('/get_people_gave_stars_count_all_rating/{id}', 'api\BookController@getPeopleGaveStarsCountAllRating');
            Route::get('/get_people_gave_stars_count_by_rating/{id}/{rating}', 'api\BookController@getPeopleGaveStarsCountByRating');
            Route::get('/get_reviews_by_book_id/{bookId}', 'api\BookController@getReviewsByBookId');
            Route::get('/whether_the_user_has_added_book_to_cart/{bookId}', 'api\CartController@whetherTheUserHasAddedBookToCart');
            Route::get('/whether_the_user_has_added_book_to_wish_list/{bookId}', 'api\WishesController@whetherTheUserHasAddedBookToWishList');
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            Route::get('/get_user_orders_for_orders_page', 'api\OrderController@getUserOrdersForOrdersPage');
            Route::get('/get_books_by_order_id/{orderId}', 'api\OrderController@getBooksByOrderId');
            Route::get('/update_last_read/{bookId}/{lastRead}', 'api\HaveController@updateLastRead');
            Route::get('/get_last_read/{bookId}', 'api\HaveController@getLastRead');
            Route::get('/get_user_books', 'api\BookController@getUserBooks');
            Route::get('/flash_messages', 'api\FlashMessageController@getFlashMessages');
            Route::get('/is_book_not_deleted', 'api\BookController@isBookNotDeleted');
            Route::get('/get_publishers_book', 'api\BookController@getPublisherBook');
        });

        Route::prefix('/post')->group(function() {
            Route::post('/add_book_to_cart/{bookId}', 'api\CartController@addBookToCart');
            Route::post('/remove_book_from_cart/{bookId}', 'api\CartController@removeBookFromCart');
            Route::post('/add_book_to_wish_list/{bookId}', 'api\WishesController@addBookToWishList');
            Route::post('/remove_book_from_wish_list/{bookId}', 'api\WishesController@removeBookFromWishList');
            Route::post('/create_order', 'api\OrderController@create');
            Route::post('/review', 'api\ReviewController@store')->middleware(['HaveUserNotReviewedTheBook', 'IsBookNotDeleted']);
            Route::post('/update_profile', 'api\UserController@updateProfile');
            Route::post('/is_password_true', 'api\UserController@isPasswordTrue');
            Route::post('/update_password', 'api\UserController@updatePassword');
            Route::post('/destroy_account', 'api\UserController@destroy');
            Route::post('/store_flash_message', 'api\FlashMessageController@store');
        });

        // UNTUK PUBLISHER
        Route::prefix('/publisher')->middleware(['DoesPublishers', 'CheckOrderStatusForPublishers'])->group(function() {

            Route::get('/dashboard', 'publisher\DashboardController@index')
                ->name('dashboard-publisher');

            Route::get('/edit', 'publisher\DashboardController@editDataPublisher')
                ->name('edit-data-publisher');
            
            Route::post('/edit', 'publisher\DashboardController@updateDataPublisher')
                ->name('edit-data-publisher-POST');
            
            Route::get('/input/book', 'publisher\BookController@create')
                ->name('input-book');

            Route::post('/input/book', 'publisher\BookController@store')
                ->name('input-book-POST');

            Route::get('/cashout', 'publisher\BalanceController@cashout');

            Route::prefix('/post')->group(function (){
                Route::post('/cashout', 'api\BalanceController@withdrawBalance');
            });

            Route::middleware(['DoesPublisherHaveThatBook'])->group(function() {
                Route::get('/edit/book', 'publisher\BookController@edit')
                    ->name('edit-book');

                Route::post('/edit/book', 'publisher\BookController@update')
                    ->name('edit-book-POST');

                Route::post('/delete/book', 'publisher\BookController@destroy')
                    ->name('delete-book');
            });

        });
    });

        
});

