<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Role
{
    public function hasRole($role)
    {
        return Auth::user()->hasRole($role);
    }

    public function isSuperadmin()
    {
        if (Auth::user()->cabang_id == 0) {
            return true;
        } else {
            return $this->hasRole('superadmin');
        }
    }

    public function isKasir()
    {
        return $this->hasRole('kasir');
    }

    public function isGudang()
    {
        return $this->hasRole('gudang');
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    public function isAllBranch()
    {
        return Auth::user()->cabang_id == 0 ? true : false;
    }
}