<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function budgetRequestApproves()
    {
        return $this->hasMany(BudgetRequest::class, 'approved_by');
    }

    public function budgetRequests()
    {
        return $this->hasMany(BudgetRequest::class, 'user_id');
    }

    public function consumes()
    {
        return $this->hasMany(Consume::class, 'user_id');
    }

    public function approvedConsumes()
    {
        return $this->hasMany(Consume::class, 'approved_by');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'user_id');
    }

    public function reviewedQuotations()
    {
        return $this->hasMany(Quotation::class, 'reviewed_by');
    }

    public function approvedQuotations()
    {
        return $this->hasMany(Quotation::class, 'approved_by');
    }

    public function resetPasswordRequests()
    {
        return $this->hasMany(ResetPasswordRequest::class, 'user_id');
    }

    public function resetPasswords()
    {
        return $this->hasMany(ResetPasswordRequest::class, 'reset_by');
    }

    public function returnProducts()
    {
        return $this->hasMany(ReturnProduct::class, 'user_id');
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'user_id');
    }

    public function unusedProducts()
    {
        return $this->hasMany(UnusedProduct::class, 'user_id');
    }

    public function approvedUnusedProducts()
    {
        return $this->hasMany(UnusedProduct::class, 'approved_by');
    }
}
