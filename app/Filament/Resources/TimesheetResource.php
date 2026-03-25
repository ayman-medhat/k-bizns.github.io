<?php

namespace App\Filament\Resources;

use App\Models\Timesheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;
    // protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'erp.nav.projects';
    protected static ?int $navigationSort = 3;

    public static function getLabel(): string
    {
        return __('erp.timesheet');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.timesheets');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.timesheet_details'))->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Select::make('task_id')
                        ->label(__('erp.task'))
                        ->relationship('task', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('employee_id')
                        ->label(__('erp.employee'))
                        ->relationship('employee', 'name_translations->en')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\DatePicker::make('date')
                        ->label(__('erp.date'))
                        ->default(now())
                        ->required(),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TimePicker::make('start_time')
                        ->label(__('erp.start_time'))
                        ->required(),
                    Forms\Components\TimePicker::make('end_time')
                        ->label(__('erp.end_time')),
                ]),
                Forms\Components\Textarea::make('description')
                    ->label(__('erp.description'))
                    ->rows(2),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('task.name')
                    ->label(__('erp.task'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name_translations.en')
                    ->label(__('erp.employee'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('erp.date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label(__('erp.start_time'))
                    ->time(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label(__('erp.end_time'))
                    ->time(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('task_id')
                    ->relationship('task', 'name')
                    ->label(__('erp.task')),
                Tables\Filters\SelectFilter::make('employee_id')
                    ->relationship('employee', 'name_translations->en')
                    ->label(__('erp.employee')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\TimesheetResource\Pages\ListTimesheets::route('/'),
            'create' => \App\Filament\Resources\TimesheetResource\Pages\CreateTimesheet::route('/create'),
            'edit' => \App\Filament\Resources\TimesheetResource\Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
}
