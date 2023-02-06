<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HabitResource\Pages;
use App\Filament\Resources\HabitResource\RelationManagers;
use App\Models\Habit;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Stevebauman\Purify\Facades\Purify;

class HabitResource extends Resource
{
    protected static ?string $model = Habit::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('app.filament.forms.sections.general_information.label'))
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus()
                                    ->localize('app.general.attributes.name'),
                                Forms\Components\TextInput::make('question')
                                    ->maxLength(255)
                                    ->localize('app.models.habit.attributes.question'),
                                Forms\Components\Textarea::make('notes')
                                    ->maxLength(255)
                                    ->localize('app.models.habit.attributes.notes'),
                                Forms\Components\ColorPicker::make('color')
                                    ->required()
                                    ->default('#0000ff')
                                    ->localize('app.models.habit.attributes.color'),
                                Forms\Components\Select::make('user_id')
                                    ->required()
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->allowHtml()
                                    ->getSearchResultsUsing(function (string $search) {
                                        $users = User::where('name', 'like', "%{$search}%")->limit(50)->get();

                                        return $users->mapWithKeys(function ($user) {
                                            return [$user->getKey() => static::getCleanOptionString($user)];
                                        })->toArray();
                                    })
                                    ->getOptionLabelUsing(function ($value): string {
                                        $user = User::find($value);

                                        return static::getCleanOptionString($user);
                                    })
                                    ->localize('app.models.habit.relations.user'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                        Forms\Components\Section::make(__('app.filament.forms.sections.frequency.label'))
                            ->schema([
                                Forms\Components\TextInput::make('times')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->localize('app.models.habit.attributes.times'),
                                Forms\Components\TextInput::make('multiplier')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->localize('app.models.habit.attributes.multiplier'),
                                Forms\Components\Select::make('unit')
                                    ->required()
                                    ->default('day')
                                    ->options(['day', 'week', 'month', 'year'])
                                    ->localize('app.models.habit.attributes.unit'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 1,
                        'sm' => fn (Component $livewire): int => $livewire instanceof Pages\CreateHabit ? 3 : 2,
                    ]),
                Forms\Components\Group::make()
                    ->hiddenOn('create')
                    ->schema([
                        Forms\Components\Section::make(__('app.filament.forms.sections.metadata.label'))
                            ->schema([
                                Forms\Components\DateTimePicker::make('created_at')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->displayFormat('d.m.Y H:i:s')
                                    ->localize('app.general.attributes.created_at'),
                                Forms\Components\DateTimePicker::make('updated_at')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->displayFormat('d.m.Y H:i:s')
                                    ->localize('app.general.attributes.created_at'),
                            ])
                            ->columns([
                                'default' => 1,
                            ]),
                    ]),
            ])->columns([
                'default' => 1,
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        $filters = [
            //
        ];

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->localize('app.general.attributes.id', helper: false, hint: false),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->localize('app.general.attributes.name', helper: false, hint: false),
                Tables\Columns\TextColumn::make('question')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->localize('app.models.habit.attributes.question', helper: false, hint: false),
                Tables\Columns\TextColumn::make('notes')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->localize('app.models.habit.attributes.notes', helper: false, hint: false),
                Tables\Columns\ColorColumn::make('color')
                    ->sortable()
                    ->searchable()
                    ->localize('app.models.habit.attributes.color', helper: false, hint: false),
                Tables\Columns\TextColumn::make('times')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->localize('app.models.habit.attributes.times', helper: false, hint: false),
                Tables\Columns\TextColumn::make('multiplier')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->localize('app.models.habit.attributes.multiplier', helper: false, hint: false),
                Tables\Columns\TextColumn::make('unit')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->localize('app.models.habit.attributes.unit', helper: false, hint: false),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->localize('app.models.habit.relations.user', helper: false, hint: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->localize('app.general.attributes.created_at', helper: false, hint: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->localize('app.general.attributes.updated_at', helper: false, hint: false),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->filters($filters)
            ->defaultSort('name');
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHabits::route('/'),
            'create' => Pages\CreateHabit::route('/create'),
            'view' => Pages\ViewHabit::route('/{record}'),
            'edit' => Pages\EditHabit::route('/{record}/edit'),
        ];
    } 
    
    public static function getCleanOptionString(Model $model): string
    {
        return Purify::clean(
                view('filament.components.select-user-result')
                    ->with('name', $model?->name)
                    ->with('email', $model?->email)
                    ->render()
        );
    }

    /**
     * Get the advanced search result Details.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $record
     * @return array
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('app.models.habit.relations.user.label') => $record->user->name,
        ];
    }

    /**
     * Get the Eloquent query for global search. Excludes the records the user is not authorized to see.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        $query = parent::getGlobalSearchEloquentQuery();

        if (! Auth::user()->hasPermissionTo('view_any_habit')) {
            $query = $query->where('id', -1);
        }

        return $query;
    }

    /**
     * Gets the URL the User is redirected to after clicking on a global search result.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $record
     * @return string
     */
    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return route('filament.resources.habits.view', ['record' => $record]);
    }

    public static function getModelLabel(): string
    {
        return __('app.models.habit.label') !== 'app.models.habit.label' ? __('app.models.habit.label') : parent::getModelLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.models.habit.plural_label') !== 'app.models.habit.plural_label' ? __('app.models.habit.plural_label') : parent::getPluralModelLabel();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('app.models.habit.navigation_group') !== 'app.models.habit.navigation_group' ? __('app.models.habit.navigation_group') : parent::getNavigationGroup();
    }
}
