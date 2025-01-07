<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'menu_permission', 'id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'menu_parent', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'menu_parent', 'id');
    }
}
