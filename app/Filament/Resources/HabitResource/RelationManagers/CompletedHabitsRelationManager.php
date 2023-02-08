<?php

namespace App\Filament\Resources\HabitResource\RelationManagers;

use App\Filament\Resources\HabitResource\Pages\EditHabit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompletedHabitsRelationManager extends RelationManager
{
    protected static string $relationship = 'completedHabits';

    protected static ?string $recordTitleAttribute = 'completed_on';

    public function isEditPage()
    {
        return $this->pageClass === EditHabit::class;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('completed_on')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('completed_on'),
                Tables\Columns\TextColumn::make('user.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }  
    
    public static function getModelLabel(): string
    {
        return __('app.models.completed_habit.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.models.completed_habit.plural_label');
    }

    protected function canAssociate(): bool
    {
        return $this->isEditPage() ? parent::canAssociate() : false;
    }

    protected function canAttach(): bool
    {
        return $this->isEditPage() ? parent::canAttach() : false;
    }

    protected function canCreate(): bool
    {
        return $this->isEditPage() ? parent::canCreate() : false;
    }

    protected function canDelete(Model $record): bool
    {
        return $this->isEditPage() ? parent::canDelete($record) : false;
    }

    protected function canDeleteAny(): bool
    {
        return $this->isEditPage() ? parent::canDeleteAny() : false;
    }

    protected function canDetach(Model $record): bool
    {
        return $this->isEditPage() ? parent::canDetach($record) : false;
    }

    protected function canDetachAny(): bool
    {
        return $this->isEditPage() ? parent::canDetachAny() : false;
    }

    protected function canDissociate(Model $record): bool
    {
        return $this->isEditPage() ? parent::canDissociate($record) : false;
    }

    protected function canDissociateAny(): bool
    {
        return $this->isEditPage() ? parent::canDissociateAny() : false;
    }

    protected function canEdit(Model $record): bool
    {
        return $this->isEditPage() ? parent::canEdit($record) : false;
    }

    protected function canForceDelete(Model $record): bool
    {
        return $this->isEditPage() ? parent::canForceDelete($record) : false;
    }

    protected function canForceDeleteAny(): bool
    {
        return $this->isEditPage() ? parent::canForceDeleteAny() : false;
    }

    protected function canReplicate(Model $record): bool
    {
        return $this->isEditPage() ? parent::canReplicate($record) : false;
    }

    protected function canRestore(Model $record): bool
    {
        return $this->isEditPage() ? parent::canRestore($record) : false;
    }

    protected function canRestoreAny(): bool
    {
        return $this->isEditPage() ? parent::canRestoreAny() : false;
    }

    protected function canView(Model $record): bool
    {
        return $this->can('view', $record);
    }
}