<?php

namespace App\Filament\Resources;

use App\Models\PayrollPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PayrollPeriodResource extends Resource
{
    protected static ?string $model = PayrollPeriod::class;
    // protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'erp.nav.hr';
    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('erp.payroll_period');
    }

    public static function getPluralLabel(): string
    {
        return __('erp.payroll_periods');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('erp.period_details'))->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('erp.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->label(__('erp.status'))
                        ->options([
                            'draft' => __('erp.draft'),
                            'processing' => __('erp.processing'),
                            'completed' => __('erp.completed'),
                            'paid' => __('erp.paid'),
                        ])
                        ->default('draft')
                        ->required(),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\DatePicker::make('start_date')
                        ->label(__('erp.start_date'))
                        ->required(),
                    Forms\Components\DatePicker::make('end_date')
                        ->label(__('erp.end_date'))
                        ->required(),
                    Forms\Components\DatePicker::make('payment_date')
                        ->label(__('erp.payment_date')),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('erp.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('erp.start_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('erp.end_date'))
                    ->date(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label(__('erp.payment_date'))
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('erp.status'))
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'processing',
                        'primary' => 'completed',
                        'success' => 'paid',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => __('erp.draft'),
                        'processing' => __('erp.processing'),
                        'completed' => __('erp.completed'),
                        'paid' => __('erp.paid'),
                    ]),
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
            'index' => \App\Filament\Resources\PayrollPeriodResource\Pages\ListPayrollPeriods::route('/'),
            'create' => \App\Filament\Resources\PayrollPeriodResource\Pages\CreatePayrollPeriod::route('/create'),
            'edit' => \App\Filament\Resources\PayrollPeriodResource\Pages\EditPayrollPeriod::route('/{record}/edit'),
        ];
    }
}
