<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenticationLog extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'authentication_log';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'login_at',
        'login_successful',
        'logout_at',
        'cleared_by_user',
        'location',
    ];

    protected $casts = [
        'cleared_by_user' => 'boolean',
        'location' => 'array',
        'login_successful' => 'boolean',
    ];

    protected $dates = [
        'login_at',
        'logout_at',
    ];

    
    public string $defaultSortColumn = 'login_at';
    public string $defaultSortDirection = 'desc';
    public string $tableName = 'authentication-log-table';

    public User $user;

    public function user()
    {
        return $this->belongsTo(User::class,'authenticatable_id');
    }

    public function __construct(array $attributes = [])
    {
        if (! isset($this->connection)) {
            $this->setConnection(config('authentication-log.db_connection'));
        }

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('authentication-log.table_name', parent::getTable());
    }

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }

    public function mount(User $user)
    {
        if (! auth()->user() || ! auth()->user()->isAdmin()) {
            $this->redirectRoute('frontend.index');
        }

        $this->user = $user;
    }

    public function columns(): array
    {
        return [
            Column::make('IP Address', 'ip_address')
                ->searchable(),
            Column::make('Browser', 'user_agent')
                ->searchable()
                ->format(function($value) {
                    $agent = tap(new Agent, fn($agent) => $agent->setUserAgent($value));
                    return $agent->platform() . ' - ' . $agent->browser();
                }),
            Column::make('Location')
                ->searchable(function (Builder $query, $searchTerm) {
                    $query->orWhere('location->city', 'like', '%'.$searchTerm.'%')
                        ->orWhere('location->state', 'like', '%'.$searchTerm.'%')
                        ->orWhere('location->state_name', 'like', '%'.$searchTerm.'%')
                        ->orWhere('location->postal_code', 'like', '%'.$searchTerm.'%');
                })
                ->format(fn($value) => $value['default'] === false ? $value['city'] . ', ' . $value['state'] : '-'),
            Column::make('Login At')
                ->sortable()
                ->format(fn($value) => $value ? timezone()->convertToLocal($value) : '-'),
            Column::make('Login Successful')
                ->sortable()
                ->format(fn($value) => $value === true ? 'Yes' : 'No'),
            Column::make('Logout At')
                ->sortable()
                ->format(fn($value) => $value ? timezone()->convertToLocal($value) : '-'),
            Column::make('Cleared By User')
                ->sortable()
                ->format(fn($value) => $value === true ? 'Yes' : 'No'),
        ];
    }

    public function query(): Builder
    {
        return Log::query()
            ->where('authenticatable_type', User::class)
            ->where('authenticatable_id', $this->user->id);
    }
    
}
