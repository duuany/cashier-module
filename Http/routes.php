<?php

Route::group(['middleware' => 'web', 'prefix' => 'cashier', 'namespace' => 'Modules\Cashier\Http\Controllers'], function()
{
    Route::get('credits', 'CashierCreditController@index')->name('cashiers.credit.index');
    Route::get('credits/new', 'CashierCreditController@create')->name('cashiers.credit.create');
    Route::post('credits', 'CashierCreditController@store')->name('cashiers.credit.store');
    Route::post('credits/{cashier}/paid', 'CashierCreditController@paid')->name('cashiers.credit.paid');
    Route::post('credits/{cashier}/unpaid', 'CashierCreditController@unpaid')->name('cashiers.credit.unpaid');
    Route::get('credits/{cashier}', 'CashierCreditController@edit')->name('cashiers.credit.edit');
    Route::post('credits/{cashier}', 'CashierCreditController@update')->name('cashiers.credit.update');
    Route::get('credits/{cashier}/delete', 'CashierCreditController@delete')->name('cashiers.credit.delete');
    Route::delete('credits/{cashier}', 'CashierCreditController@destroy')->name('cashiers.credit.destroy');

    Route::get('debits', 'CashierDebitController@index')->name('cashiers.debit.index');
    Route::get('debits', 'CashierDebitController@index')->name('cashiers.debit.index');
    Route::get('debits/new', 'CashierDebitController@create')->name('cashiers.debit.create');
    Route::post('debits', 'CashierDebitController@store')->name('cashiers.debit.store');
    Route::post('debits/{cashier}/paid', 'CashierDebitController@paid')->name('cashiers.debit.paid');
    Route::post('debits/{cashier}/unpaid', 'CashierDebitController@unpaid')->name('cashiers.debit.unpaid');
    Route::get('debits/{cashier}', 'CashierDebitController@edit')->name('cashiers.debit.edit');
    Route::post('debits/{cashier}', 'CashierDebitController@update')->name('cashiers.debit.update');
    Route::get('debits/{cashier}/delete', 'CashierDebitController@delete')->name('cashiers.debit.delete');
    Route::delete('debits/{cashier}', 'CashierDebitController@destroy')->name('cashiers.debit.destroy');

    Route::get('', 'CashierController@index')->name('cashiers.index');
    Route::get('{cashier}/edit', 'CashierController@edit')->name('cashiers.edit');
    Route::post('', 'CashierController@store')->name('cashiers.store');
    Route::post('{cashier}', 'CashierController@update')->name('cashiers.update');
    Route::get('{cashier}/delete', 'CashierController@delete')->name('cashiers.delete');
    Route::delete('{cashier}', 'CashierController@destroy')->name('cashiers.destroy');
});

// ACCOUNTS

Route::group(['middleware' => 'web', 'prefix' => 'account', 'namespace' => 'Modules\Cashier\Http\Controllers'], function() {

    Route::get('', 'AccountController@index')->name('accounts.index');
    Route::post('', 'AccountController@store')->name('accounts.store');
    Route::get('/{account}/delete', 'AccountController@delete')->name('accounts.delete');
    Route::delete('/{account}', 'AccountController@destroy')->name('accounts.destroy');
    
});