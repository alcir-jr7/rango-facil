<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Store;

class StorePolicy
{
    // 🔓 Qualquer pessoa pode ver a loja
    public function view(?User $user, Store $store)
    {
        return true;
    }

    // ➕ Criar loja (usuário logado)
    public function create(User $user)
    {
        return true;
    }

    // 👑 Dono da loja
    public function viewDashboard(User $user, Store $store)
    {
        return $store->user_id === $user->id;
    }

    public function update(User $user, Store $store)
    {
        return $store->user_id === $user->id;
    }

    public function delete(User $user, Store $store)
    {
        return $store->user_id === $user->id;
    }
}
