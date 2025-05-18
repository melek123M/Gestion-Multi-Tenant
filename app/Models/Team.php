<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\TenantScope;
use Illuminate\Support\Facades\App;

class Team extends Model
{
  use HasFactory;

  protected $fillable = ['tenant_id', 'name'];

  protected static function booted()
  {
    static::addGlobalScope(new TenantScope);

    static::creating(function ($model) {
      if (App::has('currentTenant') && is_null($model->tenant_id)) {
        $model->tenant_id = App::get('currentTenant')->id;
      }
    });
  }
  public function tenant()
  {
    return $this->belongsTo(Tenant::class);
  }

  public function users()
  {
    return $this->belongsToMany(User::class, 'team_user');
  }

  public function projects()
  {
    return $this->hasMany(Project::class);
  }
}