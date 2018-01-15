<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 27/11/2017
 * Time: 22:16
 */

namespace Modules\Cashier\Presenters;


use Carbon\Carbon;
use Illuminate\Support\HtmlString;
use Laracasts\Presenter\Presenter;

class CashierPresenter extends Presenter
{
    public function truncateDescription()
    {
        return mb_strimwidth($this->description, 0, 80, "...");
    }
    public function type()
    {
        $cashType = ['inbound' => 'Receita', 'outbound' => 'Despesa'];
        return $cashType[$this->cashier_type];
    }

    public function typeIcon()
    {
        $cashIcon = ['inbound' => 'glyphicon-arrow-up', 'outbound' => 'glyphicon-arrow-down'];
        return $cashIcon[$this->cashier_type];
    }

    public function typeColor()
    {
        $cashColor = ['inbound' => 'success', 'outbound' => 'danger'];
        return $cashColor[$this->cashier_type];
    }

    public function amountValue()
    {
        return number_format($this->amount / 100, 2, ',','.');
    }

    public function billedDate()
    {
        return optional($this->billed_at)->format('d/m/Y') ?: '-';
    }

    public function payatDate()
    {
        return optional($this->pay_at)->format('d/m/Y') ?: '-';
    }

    public function status()
    {
        $today = Carbon::today();
        if(!is_null($this->billed_at)) {
            return new HtmlString("<label class='label label-success'>Pago</label>");
        }

        if($this->pay_at < $today and is_null($this->billed_at)) {
            return new HtmlString("<label class='label label-danger'>Atrasado</label>");
        }

        return new HtmlString("<label class='label label-primary'>Aguardando</label>");
    }
}